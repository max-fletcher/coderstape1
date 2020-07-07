@extends('layouts.layout')

@section('title')
    Details for {{ $customer->name }}
@endsection

@section('content')

<div class="row">
  <a class="btn btn-primary mr-2" href="{{ route('customers.edit', ['customer' => $customer]) }}"> Edit Customer </a>  
  <form class="" action="/customers/{{ $customer->id }}" method="post">
    @csrf
    @method('delete')
    <input class="btn btn-danger" type="submit" name="submit" value="Delete">
  </form>
</div>
  <br>
  <br>

  <h2> Details for {{ $customer->name }} </h2>
  <div class="row">
    <div class="col-12">
      <p><strong> Name: <strong> {{ $customer->name }} </p>
      <p><strong> Email: <strong> {{ $customer->email }} </p>
      <p><strong> Company Name: <strong> {{ $customer->company->name }} </p>
      <p><strong> Status: <strong> {{ $customer->active }} </p>
    </div>

    @if($customer->image)
      <div class="row">
        <div class="col-12">
          <img src="{{ asset('storage/'.$customer->image) }}" alt="" class="img-thumbnail">
        </div>
      </div>

    @endif

  </div>

@endsection
