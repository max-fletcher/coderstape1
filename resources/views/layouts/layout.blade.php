<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- This will show a custom title if it any is passed form another view using @/section('title').
     If not, it will just display the default app name inside .env using config -->
    <title>@yield('title', config('app.name') )  </title>
  </head>
  <body>
    <div id="app">
      <!-- Just a demonteration of how the @/include can have an array as second parameter
       and show that data in view  -->
      @include('inc.navbar', [ 'message' => 'Sayonara Carbanara !!' ])
      <main>
        <div class="container">
          <br>
          @include('inc.messages')
          @yield('content')
        </div>
        <script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
      </main>

    </div>
  </body>
</html>
