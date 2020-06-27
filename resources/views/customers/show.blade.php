@extends('layouts.layout')

@section('title')
    Details for {{ $customer->name }}
@endsection

@section('content')

<div class="row">
  <a class="btn btn-primary mr-2" href="/customers/{{ $customer->id }}/edit">Edit Customer </a>
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

  </div>

@endsection
