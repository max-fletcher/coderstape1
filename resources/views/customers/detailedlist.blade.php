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

  <a href="/customers/create" class="btn btn-primary"> Create Customer </a>

  </button>

    <div class="row mt-3">
      <div class="col-6">
        <h2> Active Customers </h2>
        @foreach ($activecustomers as $activecustomer)
          <li> {{ $activecustomer->name }} | <span class="text-muted"> {{ $activecustomer->email }} </span> | {{ $activecustomer->company->name }} </li>
        @endforeach
      </div>

      <div class="col-6">
        <h2> Inactive Customers </h2>
        @foreach ($inactivecustomers as $inactivecustomer)
          <li> {{ $inactivecustomer->name }} | <span class="text-muted"> {{ $inactivecustomer->email }} </span> | {{ $inactivecustomer->company->name }} </li>
        @endforeach
      </div>
    </div>

    <div class="row mt-3">
      @foreach ($companies as $company)
        <div class="col-6">
          <h2> {{ $company->name }} </h2>
          @foreach ( $company->customer as $customer)
            <li> {{ $customer->name }} | <span class="text-muted"> {{ $customer->email }} </span> </li>
          @endforeach
        </div>

      @endforeach
    </div>

@endsection
