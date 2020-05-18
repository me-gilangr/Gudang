<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AdminLTE 3 | Top Navigation</title>

  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/adminlte.min.css">
  <link href="{{ asset('backend') }}/font/Sans-Pro.css" rel="stylesheet">

  @yield('css')

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  @include('frontend.layouts.navbar')

  <div class="content-wrapper">
    <div class="content-header" style="padding: 8px !important;"> 
    </div>

    <div class="content">
      <div class="container">
        <div class="row">
          @yield('content')
        </div>
      </div> 
    </div>
  </div>
</div>


<script src="{{ asset('backend') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('backend') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('backend') }}/dist/js/adminlte.min.js"></script>

@yield('script')
</body>
</html>
