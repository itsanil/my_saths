@extends('auth.main')
@section('title', 'Login')
@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- Select2 -->
<!-- validate -->
<script src="{{ asset('public/adminlte/plugins/jquery-validation/jquery.validate.js') }}"></script>
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
   
  });

  $(document).on('click', '#submitUserForm', function() {
    // var isvalidate=$("#userForm").valid();
    // if(isvalidate == false){
    //   return false;
    // }
    var formData = new FormData($('#userForm')[0]);
    $.ajax({
      type: 'POST',
      url: '{{ route("auth.validate") }}',
      processData: false,
      contentType: false,
      data: formData,
      beforeSend: function() {
        $('.loadingoverlay').css('display', 'block');
      },
      success: function(response) {
        if ((response.success == 1)) {
          toastr.success(response.message);
          $("#otp_number").val('');
          $("#token").val('');
          $("#token").val(response.token);
          $("#OtpModal").modal("show");
          
        } else {
          // toastr.error('The mobile has already been taken.');
          // var alrtList = '<ui>';
          $.each(response.message.building_name, function( index, value ) {
            toastr.error(value);
          });
          $.each(response.message.contact_no, function( index, value ) {
            toastr.error(value);
          });
          $.each(response.message.name, function( index, value ) {
            toastr.error(value);
          });
          $.each(response.message.mobile, function( index, value ) {
            toastr.error(value);
          });
          $.each(response.message.area_id, function( index, value ) {
            toastr.error('area field is required');
          });
          // alrtList += '</ui>';
          // toastr.error(alrtList);
        }
      },
      complete: function() {
        $('.loadingoverlay').css('display', 'none');
      },
    });
  });

  $(document).on('click', '#submitOtpForm', function() {
    var formData = new FormData($('#otpForm')[0]);
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      url: '{{ route("auth.register") }}',
      data: {
        '_token': $('input[name=_token]').val()
        ,'otp_number': $('#otp_number').val()
        ,'token': $('#token').val()
        ,'name' : $("#name").val()
        ,'contact_no' : $("#contact_no").val()
        ,'city' : $("#city").val()
        ,'area_id' : $("#area_id").val()
        ,'building_name' : $("#search").val()
        ,'mobile' : $("#mobile").val()
        ,'lane' : $("#lane").val()
        ,'flat_no' : $("#flat_no").val()
      },
      beforeSend: function() {
        $('.loadingoverlay').css('display', 'block');
      },
      success: function(response) {
        if ((response.success == 1)) {
          $("#OtpModal").modal("hide");
          toastr.success(response.message);
          setTimeout(function(){
            window.location.href = 'home';
          }, 2000);
          
        } else {
         toastr.error(response.message);
        }
      },
      complete: function() {
        $('.loadingoverlay').css('display', 'none');
      },
    });
  });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();
  });
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
$(function () {
  $('.register-card-body').show();
  $('.Register-card-body').hide();
                  $('.otp-card-body').hide();
    $("#register-btn").on("click",function(e){
        $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          url: "{{ route('login.whatsapp') }}",
          type: 'POST',
          data: {whatsapp_no:$('#whatsapp').val()},
          success: function (response) {
            if (response.success == 'not valid') {
                  $('.register-card-body').hide();
                  $('.Register-card-body').show();
                  $('.register-logo').css('margin-top','173px');
                  $('#mobile').val($('#whatsapp').val());
                toastr.error(response.message);
            } else {
                if (response.success) {
                  $('.register-card-body').hide();
                  $('#whatsapp_otp_no').val($('#whatsapp').val());
                  $('.otp-card-body').show();
                  toastr.success(response.message);
                }else{

                  toastr.error(response.message);
                }
            }
          }
        });
    });

     $("#otp-btn").on("click",function(e){
        $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          url: "{{ route('login.otp') }}",
          type: 'POST',
          data: {otp_no:$('#otp').val(),whatsapp_otp_no:$('#whatsapp_otp_no').val()},
          success: function (response) {
                if (response.success) {
                  toastr.success(response.message);
                  window.location.href = 'home';
                }else{
                  toastr.error(response.message);
                }
          }
        });
    });
 });
</script>
    
@endsection
@section('content')
<div class="register-box">
  <div class="register-logo" style="">
    <a href="{{ url('/customer-login') }}" >
        <center>
             <img src="{{ asset('public/images/darksg.jpg') }}" alt="sgLogo" class=""
           style="width:175px;height: 175px;">
       </center>
    </a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Login</p>
        <div class="input-group mb-3">
          <!-- <input type="email" class="form-control" placeholder="Email"> -->
          <input  placeholder="Enter Whatsapp Number" type="text" class="form-control" name="whatsapp_no" id="whatsapp"  required >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
       
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="button" class="form-control btn btn-primary btn-block" id="register-btn">Send OTP</button>
          </div>
          <!-- /.col -->
        </div>
    </div>
    <div class="card-body otp-card-body">
      <p class="login-box-msg">Login</p>
        <div class="input-group mb-3">
          <!-- <input type="email" class="form-control" placeholder="Email"> -->
          <input  placeholder="Enter OTP " type="text" class="form-control" name="otp_no" id="otp"  required >
          <input  placeholder="Enter OTP " type="hidden" class="form-control" name="whatsapp_otp_no" id="whatsapp_otp_no"  required >
        </div>
       
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="button" class="form-control btn btn-primary btn-block" id="otp-btn">Submit</button>
          </div>
          <!-- /.col -->
        </div>
    </div>

    <div class="card-body Register-card-body">
      <p class="login-box-msg">Register</p>
        <!-- <form method="POST" action="{{ route('register') }}" id="RegisterForm"> -->
           <form id="userForm" class="FormValidate" method="POST" role="form" onsubmit="return false">
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
          <input id="mobile" placeholder="Whatsapp Mobile" type="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" maxlength="10" required autocomplete="mobile">
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
          <input id="contact_no" placeholder="contact Number(Optional)"  type="contact" class="form-control @error('contact') is-invalid @enderror" name="contact_no" maxlength="10" value="{{ old('contact') }}" autocomplete="contact">
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
          <select class="custom-select" id="area_id" name="area_id" required="">
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
          <input id="search" placeholder="Enter Building name" name="building_name" required="" type="text" class="form-control" >
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
            <!-- <a href="customer-login" class="btn btn-primary btn-block" id="register-btn" >Login</a> -->
          </div>
          <!-- /.col -->
          <div class="col-4">
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" id="submitUserForm">Submit</button>
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

        <div class="modal fade" id="OtpModal" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
          <div class="text-center mt-2 mb-4">
                                <b>Please enter OTP to verify your whatsapp number</b>
          </div>
          <form id="otpForm" method="POST" role="form" onsubmit="return false">
            {{ csrf_field() }}
            <div class="form-group">
              <input type="text" class="form-control OnlyNumber" name="otp_number" id="otp_number" placeholder="4 digit OTP" maxlength="4">
              <input type="hidden" class="form-control" name="token" id="token">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="submitOtpForm">Submit</button>
        </div>
      </div>
    </div>
  </div>
@endsection
