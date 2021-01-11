@extends('backend.main')
@section('title', 'Change Password')
@section('section_page', 'Change Password')
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
  $(document).on("bind change paste keyup keypress","#oldpassword",function() {
// console.log('change');
var oldpassword=$('#oldpassword').val().trim();
if (oldpassword !='') {
$.ajax({
               type:'POST',
               url:my_url+'/checkUserPassword',
               data:{_token:'<?php echo csrf_token() ?>',oldpassword:oldpassword},
               dataType:"json",
               success:function(data) {
                if (data.status == true) {
                   $('#oldpassword_status').text(data.message);
                       $('#oldpassword_status').css('color','green');
                   setTimeout(function(){ 
                   $('#oldpassword_status').text('');
                   $('#oldpassword_status').css('color','green');
                     }, 5000);
                }else{
                    $('#oldpassword_status').text(data.message);
                     $('#oldpassword_status').css('color','red');
                   setTimeout(function(){ 
                   $('#oldpassword_status').text('');
                   $('#oldpassword_status').css('color','red');
                     }, 50000);
                }
               }
            });
}
  });

  $(document).on("bind change paste keyup keypress","#confirmpassword,#newpassword",function() {
    var newpassword=$('#newpassword').val().trim();
    var confirmpassword=$('#confirmpassword').val().trim();
    if (newpassword!='' && confirmpassword!='') {
    if (newpassword == confirmpassword ) {
      $('#confirmpassword_status').text('Password matched');
      $('#confirmpassword_status').css('color','green');
      setTimeout(function(){
        $('#confirmpassword_status').text('');
      }, 3000);
    }else{
      $('#confirmpassword_status').text('Password does not matched');
      $('#confirmpassword_status').css('color','red');
      setTimeout(function(){
        $('#confirmpassword_status').text('');
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
        <li class="active">Change Password</li>
    </ul>
</div>
      

 <div class="wrapper">
    <!--Main row -->
    <div class="row">
        <div class="col-lg-7">
            <section class="panel">
                <!-- END Form Elements Title -->
                <div class="panel-body">
                    <form  method="post" class="form-horizontal " role="form" id="user_update" autocomplete="off" novalidate="novalidate" action="{{ route('updatePassword') }}">
                         @csrf
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="oldpassword">Enter current password *</label>
                            <div class="col-md-8">
                                <input type="password" id="oldpassword" name="oldpassword" class="form-control" placeholder="Enter current password" required="">
                                <span class="help-block" id="oldpassword_status"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="newpassword">Enter new password *</label>
                            <div class="col-md-8">
                                <input type="password" id="newpassword" name="newpassword" class="form-control" placeholder="Enter new password" required="">
                                 <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="confirmpassword">Retype new password *</label>
                            <div class="col-md-8">
                                <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Retype new password" required="">
                                   <span  class="help-block" id="confirmpassword_status"></span>
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <div class="col-md-9 col-md-offset-4" style="margin-left: 235px;">
                                <button name="Send" class="btn btn-md btn-primary" type="submit" id="update"><i class="fa fa-angle-right"></i><span> Update</span></button>
                                <button type="reset" class="btn btn-md btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                    <!-- END Basic Form Elements Content -->
                </div>
            </section>
        </div>
    </div>
</div>


@endsection
