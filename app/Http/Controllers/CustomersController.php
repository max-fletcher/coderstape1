<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Company;
use App\Events\NewCustomerHasRegisteredEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeNewUserMail;

class CustomersController extends Controller
{

    public function __construct(){
        $this->middleware(['auth', 'verified'])->except(['index']);
    }

    public function index(){
      $customers = Customer::all();

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
// need to follow some different conventions. Say you want to dd the name inside request. You will have to use
// dd(request('name'));  instead of  dd($request->input('name'));  or  dd($request->name);
    public function store(){
// $data here contains the validated data. validateRequest is now a seprate function that contains validation logic
// You could not do this line and say Customer::create($this->validateRequest()); instead if you don't mind the complexity
        $data = $this->validateRequest();

  // This is a new syntax for saving data to database. It is short form of the several lines code commented
  // out below. It takes the validated $data as a parameter and stores it. Its called mass assignemnt and doesn't
  // work if you don't use the fillable or guarded property in model to define the mass assignable fields
  // This method can also take an associative array BTW.
        $customer = Customer::create($data);

        event(new NewCustomerHasRegisteredEvent($customer));

  // This is an event. If this is triggered, will cause a bunch of lines inside listeners to execute. This
  //accepts $data as a parameter so $data is being sent to it to be used.
        //event(new NewCustomerHasRegistered($data));

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
      //update customer
      $customer->update($data);

      return redirect('customers/'.$customer->id.'/show');
    }

    public function destroy(Customer $customer){

      // uses route model binding. See above.
      // delete customer
      $customer->delete();

      return redirect('customers');
    }
// This function is used to validate data. Use it if your forms are similar. Use the $this->validateRequest()
// to call it
    public function validateRequest(){
      return request()->validate([
        'name' => 'required|min:3',
        'email' => 'required|email',
        'active' => 'required',
        'company_id' => 'required',
      ]);
    }

}
