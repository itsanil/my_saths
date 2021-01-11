@extends('backend.main')
@section('title', 'Change Mobile/Email')
@section('section_page', 'Change Mobile/Email')
@section('css')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.css') }}">
 <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  /*margin: 8px 0;*/
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}
h4 {
    color: #000;
    font-size: 13px;
    font-weight: bold;
}
input[type=checkbox], input[type=radio] {
    box-sizing: border-box;
    padding: 0;
}
.form-horizontal .form-group {
    border-bottom: 1px solid #f1f1f1;
    margin-left: -15px;
    margin-right: -15px;
    padding: 0 0 16px;
    margin-bottom: 10px;
    display: flex;
}
.form-horizontal .control-label {
    font-weight: bold;
    text-align: right;
}
@media (min-width: 1200px)
.col-lg-8 {
    width: 66.66666667%;
}

.form-control-static {
    margin-bottom: 0;
}
p {
    margin: 0 0 10px;
}
.panel{
    background-color: #fefffe !important;border: 4px solid #191f80 !important;margin-bottom: 20px;
}
.panel-body{
    padding: 12px 8px !important;
}
/*div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}*/
</style>
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- DataTables -->

<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    
    $(document).on("click bind change paste keyup keypress","#check_email_address,#checkemail_button",function() {
    var check_email_address=$('#check_email_address').val().trim();
     $('#submit_request_button').css('display','none');
     $('#update_email').attr("disabled");
    console.log('change ',check_email_address);
    if (check_email_address !='') {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var result=regex.test(check_email_address);
        if (result==true) {
             $('#check_email_address_status').css('color','green');
              $('#check_email_address_status').text('Thise Number is available');
                   setTimeout(function(){ 
                   $('#check_email_address_status').text('');
                     }, 5000);
             $('#submit_request_button').css('display','block');     
             $('#update_email').removeAttr("disabled");
        }else{
              $('#check_email_address_status').text('Thise Number is Not available');
              $('#check_email_address_status').css('color','red');
               setTimeout(function(){ 
               $('#check_email_address_status').text('');
               
                 }, 5000);
               $('#submit_request_button').css('display','none');
               $('#update_email').attr("disabled");
        }


    }
    });


    $(function () {
        $("#example1").DataTable({
          "responsive": true,
          "autoWidth": false,
        });
    });
    function Edit(id,name,status){
        // alert(name);
        // var edit_url = 'campaign-category-update?id=/'+id;
          $("#edit_title").val(name);
          $("#edit_id").val(id);
          $("#edit_status").val(status);
          // $("#editform").attr('action',edit_url);
           // $('#editform').attr('action', edit_url);
          $("#edit-modal").modal("show");
    }

        </script>
@endsection
@section('content')
		@if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                <ul>
                        <li>{{ session()->get('success') }}</li>
                </ul>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger">
                <ul>
                        <li>{{ session()->get('error') }}</li>
                </ul>
            </div>
        @endif


         <div class="page-heading">
    <h3>Account Setting</h3>
    <ul class="breadcrumb">
        <li>
            <a href="{{ url('/dashboard') }}">Dashboard</a>
        </li>
        <li class="active">/ Profile /</li>
        <li class="active">Change Mobile/Email</li>
    </ul>
</div>
      

  <div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                        <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#change-email" role="tab" aria-controls="vert-tabs-home" aria-selected="false">Change Email ID</a>
                  <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#change-mobile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Change Mobile No.</a>
                </div>
              </div>
                <div class="panel-body" style="background-color:#d0d0d0;">
                    <div class="col-sm-12">
                       
                        <div class="col-sm-10" style="background-color:#fff;min-height:320px;padding-top:15px;padding-bottom: 15px;">

                            <div class="tab-content">

                                <div id="change-email" class="tab-pane fade in active show">
                            <form action="{{ route('updateMobileEmail') }}" method="post" class="form-horizontal form-bordered" id="changetransactionpassword" autocomplete="off"  novalidate="novalidate">
                            @csrf
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="oldpassword">Current Email ID</label>
                                            <div class="col-sm-5">
                                                <input type="email" class="form-control" value="{{$data->email}}" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="newpassword">Change Email ID*</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input type="email" id="check_email_address" name="email" class="form-control" placeholder="Enter new Email ID">
                                                    <span class="input-group-btn"><button type="button" name="checkemail" class="btn btn-sm btn-info" id="checkemail_button" > Check Email ID</button></span>
                                                </div>
                                                <div id="check_email_address_status"></div>
                                            </div>
                                        </div>
                                        <div class="form-group form-actions"  id='submit_request_button' style="display: none;">
                                            <div class="col-sm-12 col-sm-offset-4"  style="margin-left: 339px;">
                                                <button name="Send" type="submit" class="btn btn-sm btn-primary" id="update_email" disabled="disabled"><i class="fa fa-angle-right"></i> Submit Request</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="change-mobile" class="tab-pane fade">
                                    <form action="https://onlinesensor.com/user/change-mobile-no" method="post" class="form-horizontal form-bordered" id="change-mobile-no-form" autocomplete="off" onsubmit="return false;" novalidate="novalidate">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Current Mobile No.</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" value="{{$data->mobile}}" disabled="disabled">
                        <small>Please raise a ticket to change your mobile number.</small>
                                                                                            </div>
                                        </div>
                                        <div class="form-group" style="display: none;">
                                            <label class="col-sm-4 control-label">Enter OTP</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input type="password" name="old-mobile-verification-code" id="old-mobile-verification-code" class="form-control" placeholder="Enter OTP">
                                                    <span class="input-group-btn"><button type="button" class="btn btn-sm btn-info" id="verify-is-same-user" data-url="https://onlinesensor.com/user/verify-is-same-user">Continue</button></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: none;">
                                            <label class="col-sm-4 control-label" for="mobile">New Mobile No.*</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Enter a new Mobile No.">
                                                    <span class="input-group-btn"><button type="button" class="btn btn-sm btn-info" id="verify-new-mobile-no" data-url="https://onlinesensor.com/user/verify-new-mobile-no" data-resend="Resend OTP">Send OTP</button></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: none;">
                                            <label class="col-sm-4 control-label">Enter OTP</label>
                                            <div class="col-sm-5">
                                                <input type="password" name="verification_code" id="verification_code" class="form-control" placeholder="Enter OTP">
                                            </div>
                                        </div>
                                        <div class="form-group form-actions" style="display: none;">
                                            <div class="col-sm-12 col-sm-offset-4">
                                                <button name="Send" type="submit" class="btn btn-sm btn-primary " id="update_mobile" disabled="disabled"><i class="fa fa-angle-right"></i> Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

 </div>


@endsection
