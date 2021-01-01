@extends('auth.main')
@section('title', 'Login')
@section('content')
<div class="login-box" style="margin-top: -60px;">
  <div class="login-logo">
    <a href="{{ url('/login') }}">
           <center>
             <img src="{{ asset('public/frontend/img/new-logo.png') }}" alt="sgLogo" class=""
           style="width:175px;height: 175px;">
           </center>
        </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login</p>

      <form method="POST" action="{{ route('login') }}">
                        @csrf
        <div class="input-group mb-3">
          <!-- <input type="email" class="form-control" placeholder="Email"> -->
            <input id="email" type="text" placeholder="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          
        </div>
        <div class="input-group mb-3">
          <!-- <input type="password" class="form-control" placeholder="Password"> -->
            <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
         
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <!-- <input type="checkbox" id="remember"> -->
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->
      @if (Route::has('password.request'))
      <p class="mb-1">
        <a href="{{ route('password.request') }}">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center">Register Here</a>
      </p>
      @endif
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<!-- jQuery -->
@endsection
