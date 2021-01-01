<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/frontend/img/favicon.png') }}">
  <title>{{ config('app.name') }} | @yield('title')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/images/favicon_io/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/images/favicon_io/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/images/favicon_io/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('public/images/favicon_io/site.webmanifest') }}">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
    <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/toastr/toastr.min.css') }}">
  @yield('css')
  <link rel="stylesheet" href="{{ asset('public/adminlte/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
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

    .orientation-div {
    display: -webkit-box!important;
    display: -ms-flexbox!important;
    display: flex!important;
    pointer-events: auto;
    position: fixed;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    min-height: 100vh;
    background: #008ecc;
    z-index: 9999999999;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
 .orientation-div .orientation {
    width: 80%;
    display: -webkit-box!important;
    display: -ms-flexbox!important;
    display: flex!important;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

html .orientation-div .orientation .alert-text {
    font-size: 14px;
    color: #fff;
    text-align: center;
    display: block!important;
}

 @media (max-width: 768px) and (orientation:portrait) {
    .orientation-section {
        display: none;
    }
}
@media screen and (min-width: 768px) {
.orientation-section {
        display: none;
    }

}

@media screen and (max-width: 992px) {
    .input-group{
      margin-top: 20px;
    }
}

/* On screens that are 600px wide or less, the background color is olive */
@media screen and (max-width: 600px) {
    .input-group{
      margin-top: 20px;
    }
}

.orientation-div { display: none; } 
  </style>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MT0B9Q5ZZE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-MT0B9Q5ZZE');
</script>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
  <!--  <section class="orientation-section">
     <div class="orientation-div">  --><!-- <div class="orientation"> <center><div class="content" style="color: #ffff;"> <img src="{{ asset('public/images/landscape-m.png') }}" alt="sgonline" style="width:50%;height: 50%;"> <br> Please rotate your device </div></center> <div class="alert-text"> We don't support landscape mode yet. Please go back to portrait mode for the best experience </div> </div> --> <!-- </div>  
  </section> -->
<div class="wrapper">
  @include('backend.include.header')
  @include('backend.include.sidebar')

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="alert alert-warning text-center text-white" role="alert">
        <b>@yield('section_page')</b>
      </div>
      <!-- <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('section_page')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">@yield('section_page')</li>
            </ol>
            
          </div>
        </div>
      </div> --><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<?php  if(empty(Auth::user())){ ?>
<div id="myButton"></div>
<?php } ?>
  <!-- Main Footer -->
  <footer class="main-footer" style="color: black;">
    
    Copyright &copy; 2020 - <strong>Crowd Funding</strong> | All Rights Reserved | Managed by <strong><a href="https://www.sanchitsolutions.com/" target="_blank">Accunity Service</a></strong>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('public/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


<!-- Toastr -->
<script src="{{ asset('public/adminlte/plugins/toastr/toastr.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('public/adminlte/dist/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<!-- <script src="{{ asset('public/adminlte/plugins/chart.js/Chart.min.js') }}"></script> -->
<script src="{{ asset('public/adminlte/dist/js/demo.js') }}"></script>

  @yield('js')

</body>
</html>
