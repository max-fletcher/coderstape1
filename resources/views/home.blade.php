@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                      <example-component></example-component>
                  <!-- This example is a vue component that uses an api route(inside routes/api.web)
                  and a controller called TestingVueController. Also you can access the component file
                  in resources/js/components/MyButton.vue. The component is registered inside
                  resources/js/app.js
                  -->
                      <my-button text="My Button Text Boi !!" type="submit"></my-button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
