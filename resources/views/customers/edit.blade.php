@extends('layouts.layout')

@section('title')
    Edit Details for Customer {{ $customer->name }}
@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <h1> Edit Customers Page </h1>
    <p> This Page is to Edit Customers </p>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <form action="{{ route('customers.update', [ 'customer' => $customer ] ) }}" method="POST">
      @method('PATCH')
      @csrf
      @include('customers.form')
      <input type="submit" class="btn btn-primary" value="Save Customer">

    </form>
  </div>
</div>

@endsection
