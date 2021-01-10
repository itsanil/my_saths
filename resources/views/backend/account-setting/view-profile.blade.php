@extends('backend.main')
@section('title', 'View Profile')
@section('section_page', 'View Profile')
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
    $('#remove_profile_image').click(function(e) {
        e.preventDefault();
        $("#remove_profile_image_update").submit();
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
        <li class="active">View Profile</li>
    </ul>
</div>


   <div class="wrapper">
    <div class="row">
        <div class="col-md-7">
            <div class="row" style="display: block !important;">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="profile-pic text-center">
                                 @if(!empty($user_data->profile_image))
                                        <img id="image_upload_show1" src="{{asset($user_data->profile_image)}}" width="150" height="150">
                                        @else
                                        <img id="image_upload_show1" src="{{asset('public/adminlte/img/your_image_here@2x.jpg')}}" width="150" height="150">
                                        @endif
                                <div class="col-xs-9">
                                    <form action="{{ route('deleteProfileimage') }}" method="post" class="form-horizontal form-bordered" id="remove_profile_image_update" autocomplete="off"  novalidate="novalidate"  enctype="multipart/form-data">
                                    @csrf
                                    <i class="fa fa-fw fa-upload"></i> <a href="{{route('updateprofileimage')}}">Upload Your Photo</a><br><br>
                                    <i class="fa fa-fw fa-times"></i> 
                                     
                                    <a  href="javascript:void(0)" type="submit" id="remove_profile_image" class="text-danger">Remove Profile Image</a>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-body">
                            <ul class="p-info">
                                <li>
                                    <div class="title"> Signed Up on</div>
                                    <div class="desk">{{date('d-M-Y H:i:s',strtotime($user_data->created_at))}}</div>
                                </li>
                                <li>
                                    <div class="title">Username</div>
                                    <div class="desk">{{$user_data->username}}</div>
                                </li>
                                <li>
                                    <div class="title">Email address</div>
                                    <div class="desk">{{$user_data->email}}</div>
                                </li>
                                <li>
                                    <div class="title">You are invited by</div>
                                    <div class="desk">{{$inviter_data->firstname}}  {{$inviter_data->lastname}}</div>
                                </li>
                                <li>
                                    <div class="title">Email of your invited person</div>
                                    <div class="desk">{{$inviter_data->email}}</div>
                                </li>
                                <li>
                                    <div class="title">Promotional URL:</div>
                                    <div class="desk"><a class="btn btn-xs btn-link" href="https://onlinesensor.com/mishika">https://onlinesensor.com/mishika</a></div>
                                </li>
                                <!--                                <li>
                                                                    <div class="title">Project URL</div>
                                                                    <div class="desk"><a class="btn btn-xs btn-link" href="https://onlinesensor.com/mishika/project">https://onlinesensor.com/mishika/project</a></div>
                                                                </li>-->
                                <li>
                                    <div class="title">Name</div>
                                    <div class="desk">{{$user_data->firstname }} {{$user_data->lastname}}  </div>
                                </li>
                                <li>
                                    <div class="title">My Campaign Category</div>
                                    <div class="desk">{{$user_data->campaign}}</div>
                                </li>
                                <li>
                                    <div class="title">Sex</div>
                                    <div class="desk"> {{$user_data->gender}}</div>
                                </li>

                                <li>
                                    <div class="title">Address</div>
                                    <div class="desk">{{$user_data->address}}</div>
                                </li>
                                <li>
                                    <div class="title">City</div>
                                    <div class="desk">{{$user_data->city}}</div>
                                </li>
                                <li>
                                    <div class="title">District</div>
                                    <div class="desk">{{$user_data->district}}</div>
                                </li>
                                <li>
                                    <div class="title">State</div>
                                    <div class="desk">{{$user_data->state}}</div>
                                </li>
                                <li>
                                    <div class="title">Country</div>
                                    <div class="desk">{{$user_data->country}}</div>
                                </li>
                                <li>
                                    <div class="title">Mobile</div>
                                    <div class="desk">+91 {{$user_data->mobile}}</div>
                                </li>
                                <li>
                                    <div class="title">Postal Code</div>
                                    <div class="desk">{{$user_data->pinno}}</div>
                                </li>
                                <li>
                                    <div class="title">Skype ID</div>
                                    <div class="desk">{{$user_data->skype_id}}</div>
                                </li>
                                <li>
                                    <div class="title">PAN NO</div>
                                    <div class="desk">{{$user_data->pan_no}}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
