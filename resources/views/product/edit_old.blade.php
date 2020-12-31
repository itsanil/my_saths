@extends('layouts1.main')
@section('title', 'Product Edit')
@section('section_page', 'Product Edit')
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

    $(document).ready(function(){
        $('.select2').select2(); 
        $('#purchase_qty').keyup(function(){
            if($('#purchase_qty').val() == ''){
                $('#order_amount').val('');
            }
            if($('#purchase_qty').val() != '' && $('#purchase_price').val() !=''){
                $('#order_amount').val($('#purchase_qty').val()*$('#purchase_price').val());
            }
        }); 
        $('#purchase_price').keyup(function(){
            if($('#purchase_price').val() == ''){
                $('#order_amount').val('');
            }
            if($('#purchase_qty').val() != '' && $('#purchase_price').val() !=''){
                $('#order_amount').val($('#purchase_qty').val()*$('#purchase_price').val());
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
        <form action="{{ route('product.update',$Product_Data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $Product_Data->id }}">
            <div class="card-header">
                <h3 class="card-title">Edit Product</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Select Product</label>
                            <select class="form-control select2"  name="name" required="">
                                <option value="" >Select Product Name</option>
                                <?php 
                                foreach ($ProductMaster_list as $key => $value) {
                                    if ($value->name == $Product_Data->name ) {
                                       echo "<option value='".$value->name.'}'.$value->photo."' selected>".$value->name."</option>";
                                    } else {
                                        echo "<option value='".$value->name.'}'.$value->photo."'>".$value->name."</option>";
                                    }
                                 } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Select Product Source</label>
                            <select class="form-control select2" id="edit_role" name="product_source_id" required="">
                                <option value="" >Select Product Source</option>
                                <?php 
                                foreach ($ProductSource_list as $key => $value) {
                                    if ($Product_Data->product_source_id == $value->id) {
                                        echo "<option value='".$value->id."' selected >".$value->name.'('.$value->contact_no.')'."</option>";
                                    } else {
                                        echo "<option value='".$value->id."'>".$value->name.'('.$value->contact_no.')'."</option>";
                                    }
                                 } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Purchase Price</label>
                            <input type="number" min=0 step=0.001 class="form-control" name="purchase_price" id="purchase_price" value="{{ $Product_Data->purchase_price }}" placeholder="Enter Purchase Price" required="">
                        </div>
                    </div>
                     <div class="col-md-6">
                         <div class="form-group">
                            <label for="exampleInputEmail1">Enter Purchase Qty</label>
                            <input type="number" class="form-control" name="purchase_qty" id="purchase_qty" placeholder="Enter Purchase Qty" value="{{ $Product_Data->purchase_qty }}" required="">
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-6">
                         <div class="form-group">
                            <label for="exampleInputEmail1">Order Amount</label>
                            <input type="number" class="form-control" name="order_amount" id="order_amount" placeholder="Order Amount" value="{{ $Product_Data->order_amount }}" readonly="">
                        </div>
                    </div>
                     <div class="col-md-6">
                         <div class="form-group">
                            <label>Enter Order Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" name="order_date" value="{{ $Product_Data->order_date }}" class="form-control datetimepicker-input" data-target="#reservationdate">
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Bulk Sale Price(wholesale price)</label>
                            <input type="number" class="form-control" name="bulk_sale_price" id="exampleInputEmail1" placeholder="Enter Bulk Sale Price" value="{{ $Product_Data->bulk_sale_price }}" required="">
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Sale Price</label>
                            <input type="number" class="form-control" value="{{ $Product_Data->sale_price }}" name="sale_price" id="exampleInputEmail1" placeholder="Enter Sale Price" required="">
                        </div>
                    </div>
                </div>       
                <div class="row">
                    <div class="col-md-6">   
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Transport Expense</label>
                            <input type="number" class="form-control" name="transport_expence" id="exampleInputEmail1" placeholder="Enter Transport Expense" value="{{ $Product_Data->transport_expence }}" required="">
                        </div>
                    </div>
                    <div class="col-md-6">   
                        <div class="form-group">
                            <label for="password">Select Status</label>
                            <select class="custom-select" id="edit_role" name="status" required="">
                                <option value="" >Select Status</option>
                                <option value="1" <?php if ($Product_Data->status == 1) {
                                    echo "selected";
                                }
                                 ?>>Active</option>
                                <option value="0" <?php if ($Product_Data->status == 0) {
                                    echo "selected";
                                }
                                 ?>>In-Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /input-group -->
            </div>
              <!-- /.card-body -->
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection
