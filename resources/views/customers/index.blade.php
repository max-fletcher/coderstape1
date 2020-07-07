@extends('layouts.layout')

@section('title')
    Customer List
@endsection

@section('content')

  <div class="row">
    <div class="col-12">
      <h1> Customers Details Page </h1>
      <p> This is the Customers page </p>
    </div>
  </div>

  @can('create', App\Customer::class)
    <a href="/customers/create" class="btn btn-primary"> Create Customer </a>
  @endcan
  <div class="mt-3">
  <h2> Customers </h2>

  <div class="row">
    <div class="col-2 font-weight-bold"> ID </div>
    <div class="col-4 font-weight-bold"> Name </div>
    <div class="col-4 font-weight-bold"> Email </div>
    <div class="col-2 font-weight-bold"> Status </div>
  </div>

  @foreach ($customers as $customer)
    <div class="row">
      <div class="col-2"> {{ $customer->id }} </div>
      <div class="col-4">
        @can('view', $customer)
           <a href="{{ route('customers.show', ['customer' => $customer]) }}"> {{ $customer->name }} </a>
        @endcan

        @cannot('view', $customer)
            {{ $customer->name }}
        @endcannot
      </div>

      <div class="col-4"> {{ $customer->email }} </div>
      <div class="col-2"> {{ $customer->active }} </div>
    </div>
  @endforeach

<div class="row">
  <div class="col-12 d-flex justify-content-center mt-4">
    {{ $customers->links() }}
  </div>
</div>

@endsection
