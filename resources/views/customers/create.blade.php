@extends('layouts.layout')

@section('title')
    Add Customer
@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <h1> Add Customers Page </h1>
    <p> This Page is to Add Customers </p>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <form action="{{ route('customers.store') }}" method="POST">
      @csrf
      @include('customers.form')
      <input type="submit" class="btn btn-primary" value="Add Customer">

    </form>
  </div>
</div>

@endsection
