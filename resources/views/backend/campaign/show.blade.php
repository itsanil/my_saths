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
  <body class="hold-transition">
<div class="wrapper">

<section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ $campaign->title }}</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
              <div class="row">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    @if(empty($campaign->add_photo))
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    @else
                        @foreach(json_decode($campaign->add_photo) as $key => $value)
                        @if($key == 0)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="active"></li>
                        @else
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class=""></li>
                        @endif
                        @endforeach
                    @endif
                  </ol>
                  <div class="carousel-inner">
                    @if(empty($campaign->add_photo))
                        <div class="carousel-item active">
                      <img class="d-block w-100" src="{{ url('storage') }}/{{ $campaign->photo }}" alt="Second slide">
                    </div>
                    @else
                        @foreach(json_decode($campaign->add_photo) as $key => $value)
                        @if($key == 0)
                            <div class="carousel-item active">
                      <img class="d-block w-100" src="{{ url('storage') }}/{{ $value }}" alt="Second slide">
                    </div>
                        @else
                            <div class="carousel-item">
                      <img class="d-block w-100" src="{{ url('storage') }}/{{ $value }}" alt="Second slide">
                    </div>
                        @endif
                        @endforeach
                    @endif

                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                    <h4>Discription</h4>
                        {{ $campaign->discription }}
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h4>Recent Comments</h4>
                    <div class="post">
                      <div class="user-block">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                        </span>
                        <span class="description">Shared publicly - 7:45 PM today</span>
                      </div>
                      
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore.
                      </p>

                      
                    </div>

                    <div class="post clearfix">
                      <div class="user-block">
                        <span class="username">
                          <a href="#">Sarah Ross</a>
                        </span>
                        <span class="description">Sent you a message - 3 days ago</span>
                      </div>
                      
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore.
                      </p>
                    </div>
                    <div class="input-group">
                    <input type="text" name="message" placeholder="Type Comment ..." class="form-control">
                    <span class="input-group-append">
                        @if(isset(Auth::User()->id))
                            @if(Auth::User()->id == $campaign->added_by)
                            <!-- can not add comment -->
                                <button type="button" class="btn btn-primary" onclick="nocomment()">Send</button>
                            @else
                            <!-- add comment -->
                                <button type="button" class="btn btn-primary" onclick="comment()">Send</button>
                            @endif

                        @else
                        <!-- redirect to login -->
                            <button type="button" class="btn btn-primary" onclick="login()">Send</button>
                        @endif
                      
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">₹ {{ json_decode($campaign->project)->needed_amount }}</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <div class="progress">
                    <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                    <span class="sr-only">40% Complete (success)</span>
                  </div>
                </div>
                  <p><code>₹ 1,89,33,400 raised</code></p>

                  <a href="#" class="btn btn-primary btn-block"><b>Donate Now</b></a>
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  14875 supporters
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
                
                
                
              </div>
              <!-- /.card-body -->
            </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
</div>

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
<script>
    
    function nocomment(){
         toastr.error('you can not add comment in your campaign');
    }

    function comment(){
        
    }

    function login(){
        toastr.error('please login to add comment');
        setTimeout(function(){
            window.location.href = "{{ url('login') }}";
          }, 2000);
    }
</script>

</body>
</html>