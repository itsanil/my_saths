@extends('auth.main')
@section('title', 'Register')
@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    var route = "{{ url('get-building-name') }}";
    $('#search').typeahead({
        source:  function (term, process) {
        return $.get(route, { term: term }, function (data) {
                return process(data);
            });
        }
    });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();
  });
</script>
    
@endsection
@section('content')
<div class="register-box">
  <div class="register-logo">
    <a href="{{ url('/register') }}">
        <center>
             <img src="{{ asset('public/images/darksg.jpg') }}" alt="sgLogo" class=""
           style="width:175px;height: 175px;">
           </center>
    </a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register</p>
        <form method="POST" action="{{ route('register') }}" id="RegisterForm">
            @csrf
        <div class="input-group mb-3">
          <!-- <input type="text" class="form-control" > -->
          <input id="name" placeholder="Full name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
          
        </div>
        <div class="input-group mb-3">
          <!-- <input type="email" class="form-control" placeholder="Email"> -->
          <input id="mobile" placeholder="Whatsapp Mobile" type="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fab fa-whatsapp"></span>
            </div>
          </div>

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
          
        </div>
        <div class="input-group mb-3">
          <!-- <input type="email" class="form-control" placeholder="Email"> -->
          <input id="contact" placeholder="contact Number(Optional)"  type="contact" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" autocomplete="contact">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>

                                @error('contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
          
        </div>

        <div class="input-group mb-3">
          <input id="city" value="Mumbai" type="text" class="form-control" name="city" readonly="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-city"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <select class="custom-select" id="edit_area" name="area_id" required="">
              <option value="" >Select Area</option>
              <?php 
              foreach ($Area_list as $key => $value) {
                   echo "<option value='".$value->id."'>".$value->name."</option>";
               } ?>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map-marked-alt"></span>
            </div>
          </div>
        </div>  
        <div class="input-group mb-3">
          <input id="search" placeholder="Enter Building name" name="select_building_name" required="" type="text" class="form-control" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-building"></span>
            </div>
          </div>
        </div>
                <div class="input-group mb-3">
          <!-- <input type="email" class="form-control" placeholder="Email"> -->
                <input id="flat_no" placeholder="Enter Flat No. - Wing(optional)" type="text" class="form-control @error('flat_no') is-invalid @enderror" name="flat_no" value="{{ old('flat_no') }}"  autocomplete="flat_no">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-home"></span>
                  </div>
                </div>
              </div>
          <div class="input-group mb-3">
            <input id="lane" placeholder="Enter lane(optional)" type="text" class="form-control @error('lane') is-invalid @enderror" name="lane" value="{{ old('lane') }}"  autocomplete="lane">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-road"></span>
              </div>
            </div>
          </div>
       <!--  <div class="input-group mb-3">
          <div class="g-recaptcha" data-sitekey="6LfjJbwZAAAAACRPck-a-9rkkQ0wNNZ12KE2jquO" data-callback="onSubmit" required></div>

        </div> -->
        <div class="row">
          <div class="col-4">
            <a href="customer-login" class="btn btn-primary btn-block" id="register-btn" >Login</a>
          </div>
          <!-- /.col -->
          <div class="col-4">
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" id="register-btn">Submit</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- <a  class="text-center">Login</a> -->
    </div>
    <!-- /.form-box -->
                </div>
            </div>
        </div>
@endsection
