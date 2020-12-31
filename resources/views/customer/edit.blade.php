@extends('layouts1.main')
@section('title', 'Customer Edit')
@section('section_page', 'Customer Edit')
@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- Select2 -->
<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    
    $('.select2').select2();
    $('#building_html').html('<div class="col-md-6"><div class="form-group"><label for="password">Select Status</label>\
                            <select class="custom-select" id="edit_role" name="status" required="">\
                                <option value="" >Select Status</option>\
                                <<option value="1" {{ ($Customer_Data->status == 1) ? 'selected' : '' }} >Active</option>\
                                <option value="0" {{ ($Customer_Data->status == 0) ? 'selected' : '' }} >In-Active</option>\
                            </select>\
                            </div></div>');
    $('#building_names').on('change',function(){
        if ($('#building_names').val() == 'Other') {
            $('#building_html').html('');
            $('#building_html').append('<div class="col-md-6"><div class="form-group">\
                                <label for="exampleInputEmail1">Enter Building Name</label>\
                                <input type="text" class="form-control" name="building_name" id="exampleInputEmail1" placeholder="Enter Building name" required="">\
                            </div></div><div class="col-md-6"><div class="form-group"><label for="password">Select Status</label>\
                            <select class="custom-select" id="edit_role" name="status" required="">\
                                <option value="" >Select Status</option>\
                                <option value="1" {{ ($Customer_Data->status == 1) ? 'selected' : '' }} >Active</option>\
                                <option value="0" {{ ($Customer_Data->status == 0) ? 'selected' : '' }} >In-Active</option>\
                            </select>\
                            </div></div>');
        }else{
            $('#building_html').html('<div class="col-md-6"><div class="form-group"><label for="password">Select Status</label>\
                            <select class="custom-select" id="edit_role" name="status" required="">\
                                <option value="" >Select Status</option>\
                                <option value="1" {{ ($Customer_Data->status == 1) ? 'selected' : '' }} >Active</option>\
                                <option value="0" {{ ($Customer_Data->status == 0) ? 'selected' : '' }} >In-Active</option>\
                            </select>\
                            </div></div>');
        }
    });
    });
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
<div class="row">
    <div class="card card-info" style="min-width: 100%;">
        <form action="{{ route('customer.update',$Customer_Data->id) }}" method="POST" accept-charset="utf-8">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $Customer_Data->id }}">
            <div class="card-header">
                <h3 class="card-title">Edit Customer</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="Enter name" value="{{ $Customer_Data->name }}" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Whatsapp Number</label>
                            <input type="integer" class="form-control" name="whatsapp_no" id="exampleInputEmail1" placeholder="Enter Whatsapp Number" value="{{ $Customer_Data->whatsapp_no }}" required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Contact Number</label>
                            <input type="integer" class="form-control" name="contact_no" id="exampleInputEmail1" value="{{ $Customer_Data->contact_no }}" placeholder="Enter Contact Number(optional)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Select Area</label>
                            <select class="custom-select" id="edit_role" name="area_id" required="">
                                <option value="" >Select Area</option>
                                <?php 
                                foreach ($Area_list as $key => $value) {
                                    if ($value->id == $Customer_Data->area_id ) {
                                        echo "<option value='".$value->id."' selected>".$value->name."</option>";
                                    } else {
                                       echo "<option value='".$value->id."'>".$value->name."</option>";
                                    }
                                 } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Flat Number</label>
                            <input type="integer" class="form-control" name="flat_no" id="exampleInputEmail1" value="{{ $Customer_Data->flat_no }}" placeholder="Enter Flat Number(optional)" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter City Name</label>
                            <input type="text" class="form-control" name="city" id="exampleInputEmail1" placeholder="Enter City name" value="{{ $Customer_Data->city }}" required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter lane</label>
                            <input type="text" class="form-control" name="lane" id="exampleInputEmail1" placeholder="Enter lane(Optional)" value="{{ $Customer_Data->lane }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Select Building Name</label>
                          <select class="form-control select2" style="width: 100%;" name="select_building_name" id="building_names" required="">
                            <option value="">Select Building Name</option>
                            <option value="Other">Other</option>
                            <?php 
                                foreach ($building_list as $key => $value) {
                                    if ($Customer_Data->building_name == $value) {
                                        echo "<option value='".$value."' selected>".$value."</option>";
                                    }else{
                                        echo "<option value='".$value."'>".$value."</option>";
                                    }
                            } ?>
                          </select>
                        </div>
                    </div>
                </div>
                <div class="row" id="building_html">
                </div>        
            </div>
              <!-- /.card-body -->
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection
