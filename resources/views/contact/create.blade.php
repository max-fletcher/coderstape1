@extends('layouts.layout')

@section('title')
    Contact Us
@endsection

@section('content')
    <h1> Contact Us </h1>
    <p> This is the contact us page </p>

    <!-- If session has any message variable flashed to it, show the message as alert -->
    @if ( session('message') )
      <div class="alert alert-success" role="alert">
        <strong> Success !! </strong> {{ session('message') }}
      </div>
    @endif

    <form class="" action="{{ route('contact.store') }}" method="post">
        @csrf
          <div class="form-group">
              <label for="name"> Name </label>
              <!-- Since we passed an empty Customer model in the create method -->
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ old('name') }}">
              @if( $errors->any() )
                <!--
                  Another way to add validation messages to blade. Kept it here just for reference. This uses the blade directive called
                  @/error to check if an error for the "name" variable exists. If not, the next indented div alert will not work
                -->
              @error('name')
                <div class="alert alert-danger mt-2"> {{ $errors->first('name') }} </div>
              @enderror
            @endif
          </div>
          <div class="form-group">
            <label for="email"> Email </label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email Address" value="{{ old('email') }}">
          </div>

          <div class="form-group">
            <label for="message"> Message </label>
            <textarea class="form-control" name="message" rows="8" cols="80" placeholder="Enter Message"> {{ old('message') }} </textarea>
          </div>

          <input class="btn btn-primary" type="Submit" name="submit" value="Send Message">
    </form>
@endsection
