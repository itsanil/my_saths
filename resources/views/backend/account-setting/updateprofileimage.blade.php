@extends('backend.main')
@section('title', 'Upload Profile Image')
@section('section_page', 'Upload Profile Image')
@section('css')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('public/adminlte/css/bootstrap.min.css') }}"> -->

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
.panel {
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
/*ul.p-info {
    list-style-type: none;
    padding: 0;
    margin-bottom: 0;
}*/
ul.p-info .desk {
    width: 60%;
    color: #65cea7;
        list-style-type: none;
}
ul.p-info .title {
    width: 40%;
        list-style-type: none;
}
ul.p-info li {
    display: inline-block;
    width: 100%;
    margin-bottom: 10px;
}
ul.li {
    list-style-type: none;
}

ul.p-info .title, ul.p-info .desk {
    float: left;
}
.panel-body{
    padding: 12px 8px !important;
}
.profile-pic img {
    border: 5px solid #F1F2F7;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    height: 150px;
    margin: 10px 0;
    width: 150px;
}
.pull-right {
    float: right!important;
}
.fileupload .btn {
    margin-left: 0;
}
input[type=file] {
    display: block;
}
.form-control {
    box-shadow: none;
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
        <li class="active">Upload Profile Image</li>
    </ul>
</div>


<div class="wrapper">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                                                        <form method="post" class="form-horizontal form-bordered" id="profile_image_update" action="https://onlinesensor.com/index.php/user/profileimage_save" autocomplete="off" enctype="multipart/form-data">
                                                  <div class="form-group">
                                <label class="col-sm-3 control-label">Upload Profile Image<span class="danger" style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <div id="image-holder" class="fileupload-new img-thumbnail" style="width:108px; height:85px;" data-original="https://onlinesensor.com/assets/upload/profile_image/your_image_here.jpg">
                                        <img id="image_upload_show1" src="https://onlinesensor.com/assets/upload/profile_image/your_image_here@2x.jpg" width="98" height="75">
                                    </div>
                                </div>
                                <div class="pull-right col-sm-9 fileupload fileupload-new" data-provides="fileupload">
                                    <div class="input-append" style="margin-left: -462px;margin-top: 91px;">
                                        <div class="uneditable-input" style="display: none;">  <i class="glyphicon glyphicon-file fileupload-exists"></i> <span class="fileupload-preview"></span> </div>
                                        <span class="btn btn-default btn-file"> <span class="fileupload-new">Select file</span>
                                            <input type="file" name="profile_imagecropper" id="profile_imagecropper" class="form-control" data-url="https://onlinesensor.com/user/tempimg_upload">
                                            <input type="hidden" name="profile_image_name" id="profile_image_name" value="" class="form-control">
                                        </span>
                                        <a href="#" class="red fileupload-exists" data-dismiss="fileupload">Remove</a>
                                        <div>File Format(*.gif, .jpg, .jpeg, *.png)</div>

                                    </div>
                                </div>
                            </div>
                            <!-- profile image upload -->
                                
                                <div class="form-group form-actions">
                                    <div class="col-md-9 col-md-offset-3">
                                        <button name="Send" type="submit" class="btn btn-sm btn-primary" id="update_profile_image" disabled="disabled"><i class="fa fa-angle-right"></i><span>Update</span></button>
                                        <a href="https://onlinesensor.com/index.php/user/view_profile" class="btn btn-sm btn-primary">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
