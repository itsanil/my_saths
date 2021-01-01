
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }} | @yield('title')</title>

  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="manifest" href="site.webmanifest"> -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/frontend/img/favicon.png') }}">
 
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/toastr/toastr.min.css') }}">
  @yield('css')
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
    <style>
    .page-item.active .page-link {
        z-index: 0;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
  </style>
</head>
<body class="hold-transition login-page">
  @yield('content')
<!-- /.login-box -->

<!-- jQuery -->
<!-- jQuery -->
<script src="{{ asset('public/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('public/adminlte/plugins/toastr/toastr.min.js') }}"></script>

@yield('js')
<!-- AdminLTE -->
<script src="{{ asset('public/adminlte/dist/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->

</body>
</html>
