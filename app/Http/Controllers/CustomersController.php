<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Company;
use App\Events\NewCustomerHasRegisteredEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeNewUserMail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CustomersController extends Controller
{

    public function __construct(){
      $this->middleware(['auth', 'verified'])->except(['index']);
    }

    public function index(){
      // Using Eager Loading instead of Lazy Loading
      $customers = Customer::with('company')->paginate(15);

      return view('customers.index')->with('customers', $customers);
    }

    public function detailedlist(){
    //these queries are using scope declared within the Customer model. Check them out
      $activecustomers = Customer::active()->get();
      $inactivecustomers = Customer::inactive()->get();
      $companies = Company::all();

      return view('customers.detailedlist')->with('activecustomers', $activecustomers)->with('inactivecustomers', $inactivecustomers)->with('companies', $companies);
    }

    public function create(){

      $companies = Company::all();
  // We are passing this empty customer model to make a line of code in blade work which is in form.blade.php
  // <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ old('name') ?? $customer->name }}">
      $customer = new Customer();

      //get current url
      $url = url()->current();

      return view('customers.create')->with('companies', $companies)->with('customer', $customer)->with('url', $url);
    }

// store method no longer requires you to declare a request object. However it is stil there. You will however,
// need to follow some different conventions. Say you want to dd the name inside request. You will have to
// use dd(request('name'));  instead of  dd($request->input('name'));  or  dd($request->name);
    public function store(){
// Uses Gates and Policies. This is the CustomerPolicy.
      $this->authorize('create', Customer::class);
// $data here contains the validated data. validateRequest is a seprate function defined below that contains
// validation logic You could not do this line and say Customer::create($this->validateRequest()); instead
// if you don't mind the complexity.
// NOTE: This fucker contains a normal PHP array not a collection.
// So it will fail most standard laravel functions e.g update, store etc.
        $data = $this->validateRequest();

// This is a new syntax for saving data to database. It is short form of the several lines code commented
// out below. It takes the validated $data as a parameter and stores it. Its called mass assignemnt and doesn't
// work if you don't use the fillable or guarded property in model to define the mass assignable fields
// This method can also take an associative array BTW.

        $customer = Customer::create($data);

// Store image that comes with $customer if any exists. Basically we are using the storeImage() function
// that is defined somewhere below. The logic inside storeimage() can be implemented here but its
// shoved off in a separate function just to keep things clean
        $this->storeImage($customer);


  // This is an event. If this is triggered, will cause a bunch of lines inside listeners to execute. This
  //accepts $customer as a parameter so $customer is being sent to it to be used.
        event(new NewCustomerHasRegisteredEvent($customer));

        /*
        $customer = new Customer();
        //new way to access request object data if you don't declare the request object as a parameter to store
        $customer->email = request('email');
        $customer->name = request('name');
        $customer->active = request('active');
        $customer->save();
        */

        return redirect('customers')->with('success', 'Customer Added Successfully !!');
    }

    public function show(Customer $customer){

      // This method is using route model binding. It applies if you use a model object as a parameter
      // in methods(i.e this show method). Though the show routes defined in the blade files is passing an id,
      // what route model binding does is automatically fetch any rows/model in DB that has an id matching the id
      // that was passed in route when it is called. Though the only thing it does is eliminate the necessity of the
      // next line which fetches a single row of data from DB. Looks fancy, does just 1 thing.
      // $customer = Customer::findOrFail($customer);

      return view('customers.show')->with('customer', $customer );
    }

    public function edit(Customer $customer){

      // uses route model binding. See above.
      $companies = Company::all();

      //get current url
      $url = url()->current();

      return view('customers.edit')->with('customer', $customer)->with('companies', $companies)->with('url', $url);
    }

    public function update(Customer $customer){

      // uses route model binding. See above.
      // $data here contains the validated data
      $data = $this->validateRequest();
      //delete previous image. Needs to be done before update and store new image.
      Storage::delete('public/'.$customer->image);
      //update customer
      $customer->update($data);
      // update Image
      $this->storeImage($customer);

      return redirect('customers/'.$customer->id.'/show');
    }

    public function destroy(Customer $customer){

      $this->authorize('delete', $customer);
      // uses route model binding. See above.
      // delete customer
      $customer->delete();

      return redirect('customers')->with('success', ' User Deleted Successfully !! ');
    }

// This function is used to validate data. Use it if your forms are similar. Use the $this->validateRequest()
// to call it
    private function validateRequest(){
      return request()->validate([
        'name' => 'required|min:3',
        'email' => 'required|email',
        'active' => 'required',
        'company_id' => 'required',
        'image' => 'sometimes|file|image|max:5000',
      ]);
    }

    private function storeImage($customer){
// If the request sent has an image file, then update the customer model with the new image file and store it
// I believe this uses a laravel built in function that can automatically identify image classes in model
// and update the database field with the respective name of the file. Uploads is the name of the folder
// so path is App\Storage\uploads
      if (request()->has('image')) {
            $customer->update([
                'image' => request()->image->store('uploads', 'public'),
            ]);
        }

// Import "use Intervention\Image\Facades\Image;" to use intervention image after installing it.
// Use the Image class and call the make function. Provide the make function with a URL/path to the image.
// Then method chain it with fit to crop it to a certain size(width by height).
// public_path() is a laravel helper function that can be used to generate a fully qualified url/path within
// the laravel application you are developing.
// Intervention Image has a lot of functions other than fit. It can crop as well. See docs for details
      $image = Image::make(public_path('storage/'.$customer->image))->fit('300','300');
      $image->save();
    }

}
