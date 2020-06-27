<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactFromController extends Controller
{
    public function create(){

      return view('contact.create');
    }

    public function store(){

      $data = request()->validate([
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required',
      ]);

      Mail::to('testing@testing.test')->queue(new ContactFormEmail($data));

      //Does the same thing as method chaining the return call i.e,  with('message', 'Mail has been Sent Successfully !!')
      // session()->flash('message', 'Mail has been Sent Successfully !!');

      return back()->with('message', 'Mail has been Sent Successfully !!');
    }

}
