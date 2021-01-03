@extends('backend.main')
@section('title', 'Change Mobile/Email')
@section('section_page', 'Change Mobile/Email')
@section('css')

<!-- DataTables -->
<!-- <link rel="stylesheet" href="{{ asset('public/adminlte/css/bootstrap.min.css') }}"> -->
<link rel="stylesheet" href="{{ asset('public/adminlte/css/bootstrap.min.css') }}">
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
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
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
      
<div class="row">
  <div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <div class="panel-body" style="background-color:#d0d0d0;">
                    <div class="col-sm-12">
                                                <div class="col-sm-2" style="padding:0;">
                            <ul class="nav nav-tabs no-border tabs-left" style="border:none;">
                                <li class="active"><a href="#change-email" data-toggle="tab">Change Email ID</a></li>
                                <li><a href="#change-mobile" data-toggle="tab">Change Mobile No.</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-10" style="background-color:#fff;min-height:320px;padding-top:15px;padding-bottom: 15px;">
                            <div class="tab-content">
                                <div id="change-email" class="tab-pane fade in active">
                                    <form action="https://onlinesensor.com/user/update_email" method="post" class="form-horizontal form-bordered" id="change-email-form" autocomplete="off" onsubmit="return false;" novalidate="novalidate">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="oldpassword">Current Email ID</label>
                                            <div class="col-sm-5">
                                                <input type="email" class="form-control" value="kiranyadav831983@gmail.com" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="newpassword">Change Email ID*</label>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter new Email ID">
                                                    <span class="input-group-btn"><button type="button" name="checkemail" class="btn btn-sm btn-info" id="checkemail" data-url="https://onlinesensor.com/user/user_email_check1"> Check Email ID</button></span>
                                                </div>
                                                <div id="email_avail_status"></div>
                                            </div>
                                        </div>
                                        <div class="form-group form-actions" style="display: none;">
                                            <div class="col-sm-12 col-sm-offset-4">
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
                                                <input type="text" class="form-control" value="7410153442" disabled="disabled">
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
 </div>

@endsection
