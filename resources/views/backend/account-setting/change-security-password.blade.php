@extends('backend.main')
@section('title', 'Change Security Password')
@section('section_page', 'Change Security Password')
@section('css')

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
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/js/jqBootstrapValidation.js') }}"></script>
<script src="{{ asset('public/adminlte/js/form-validation.js') }}"></script>

<script>
   var my_url="<?php echo url('/') ?>";
  $(document).on("bind change paste keyup keypress","#current_security_pin",function() {
// console.log('change');
var current_security_pin=$('#current_security_pin').val().trim();
if (current_security_pin !='') {
$.ajax({
               type:'POST',
               url:my_url+'/checkUserSecurityPin',
               data:{_token:'<?php echo csrf_token() ?>',current_security_pin:current_security_pin},
               dataType:"json",
               success:function(data) {
                if (data.status == true) {
                   $('#current_security_pin_status').text(data.message);
                       $('#current_security_pin_status').css('color','green');
                   setTimeout(function(){ 
                   $('#current_security_pin_status').text('');
                   $('#current_security_pin_status').css('color','green');
                     }, 5000);
                }else{
                    $('#current_security_pin_status').text(data.message);
                     $('#current_security_pin_status').css('color','red');
                   setTimeout(function(){ 
                   $('#current_security_pin_status').text('');
                   $('#current_security_pin_status').css('color','red');
                     }, 50000);
                }
               }
            });
}
  });

  $(document).on("bind change paste keyup keypress","#confirm_security_pin,#new_security_pin",function() {
    var new_security_pin=$('#new_security_pin').val().trim();
    var confirm_security_pin=$('#confirm_security_pin').val().trim();
    if (new_security_pin!='' && confirm_security_pin!='') {
    if (new_security_pin == confirm_security_pin ) {
      $('#confirm_security_pin_status').text('Security Pin matched');
      $('#confirm_security_pin_status').css('color','green');
      setTimeout(function(){
        $('#confirm_security_pin_status').text('');
      }, 3000);
    }else{
      $('#confirm_security_pin_status').text('Security Pin does not matched');
      $('#confirm_security_pin_status').css('color','red');
      setTimeout(function(){
        $('#confirm_security_pin_status').text('');
      }, 10000);

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
        <li class="active">Change Security Password</li>
    </ul>
</div>
      
<div class="wrapper">
    <!--Main row -->
    <!-- Widgets Row -->
    <div class="row">
        <div class="col-lg-9">
            <!-- Basic Form Elements Block -->
            <section class="panel">
                <div class="panel-body">
                    <!-- Basic Form Elements Title -->
                    <!-- END Form Elements Title -->
                      <form action="{{ route('updateSecurityPin') }}" method="post" class="form-horizontal form-bordered" id="changetransactionpassword" autocomplete="off"  novalidate="novalidate">
                         @csrf
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="tran_oldpassword">Current Security PIN *</label>
                            <div class="col-md-6">
                                <input type="password" id="current_security_pin" name="current_security_pin" class="form-control" placeholder="Enter Current Security PIN">
                                <span class="" id="current_security_pin_status"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="tran_newpassword">New Security PIN *</label>
                            <div class="col-md-6">
                                <input type="password" id="new_security_pin" name="new_security_pin" class="form-control" placeholder="Enter New Security PIN ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="tran_confirmpassword">Retype Security PIN *</label>
                            <div class="col-md-6">
                                <input type="password" id="confirm_security_pin" name="confirm_security_pin" class="form-control" placeholder="Retype new Security PIN">
                                  <span class="" id="confirm_security_pin_status"></span>
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <label class="col-md-3 control-label" for="tran_confirmpassword"></label>
                            <div class="col-md-6 ">
                                <button name="Send" type="submit" class="btn btn-md btn-primary" id="update_transaction_password"><i class="fa fa-angle-right"></i><span> Update</span></button>
                                <button type="reset" class="btn btn-md btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-6 link_font">
                                <a href="javascript:void(0)" id="forgot_sec_pwd"><small>Forgot Security PIN?</small></a>
                            </div>
                        </div>
                        <div class="alert alert-success" id="forgot_mess" style="display:none;">
                          
                           
                        </div>
                    </form>
                    <!-- END Basic Form Elements Content -->
                </div>
            </section>

            <!-- END Basic Form Elements Block -->
        </div>
    </div>
</div>

@endsection
