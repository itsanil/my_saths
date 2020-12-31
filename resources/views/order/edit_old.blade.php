@extends('layouts1.main')
@section('title', 'Edit Order')
@section('section_page', 'Edit Order')
@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- Select2 -->
<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
@if(Auth::user()->hasRole('customer'))
<script src="{{ asset('public/adminlte/js/order/customer/edit.js') }}"></script>
@else
<script src="{{ asset('public/adminlte/js/order/admin/edit.js') }}"></script>
@endif

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

        <form action="{{ route('order.update',$Order_data->id) }}" id="order_form" method="POST" accept-charset="utf-8">
            <input type="hidden" name="order_id" value="{{ $Order_data->id }}">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h3 class="card-title">Edit Order</h3>
                @if(Auth::user()->hasRole('customer'))
                 <?php 
                    foreach ($customer_list as $key => $value) {
                        if ($value->user_id == Auth::user()->id) {
                            $customer_id = $value->id;
                        } 
                } ?>
                @else
                <a href="{{ route('customer.create') }}" style="float: right;" class="btn btn-success float-right">
                Add Customer
                </a>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    @if(Auth::user()->hasRole('customer'))
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select class="form-control select2" id="payment_type_id" name="payment_type_id"  data-placeholder="Select Product" style="width: 100%;" required="">
                                <option value=''>select</option>
                            <?php 
                                foreach ($payment_type_list as $key => $value) {
                                    if ($Order_data->payment_type_id == $value->id) {
                                        echo "<option value='".$value->id."' selected>".$value->name."</option>";
                                    } else {
                                        echo "<option value='".$value->id."'>".$value->name."</option>";
                                    }
                            } ?>
                          </select>
                        </div>
                    </div>
                        <input type="hidden" name="customer_id" value="{{ $customer_id }}" readonly="">
                        <input type="hidden" name="order_by" value="customer" readonly="">
                        <input type="hidden" name="delivery_status" value="{{ $Order_data->delivery_status }}" readonly="">
                        <input type="hidden" name="payment_status" value="{{ $Order_data->payment_status }}" readonly="">
                    @else
                    <input type="hidden" name="order_by" value="admin" readonly="">
                    <div class="col-md-4">
                    <div class="form-group">
                      <label>Select Customer</label>
                        <select class="form-control select2" style="width: 100%;" name="customer_id" id="customer_id" required="">
                            <option value="">Select Customer</option>
                            <?php 
                                foreach ($customer_list as $key => $value) {
                                    if ($value->id == $Order_data->customer_id) {
                                        echo "<option value='".$value->id."' selected>".$value->name.'('.$value->whatsapp_no.')'."</option>";
                                    } else {
                                        echo "<option value='".$value->id."'>".$value->name.'('.$value->whatsapp_no.')'."</option>";
                                    }
                                    
                                     
                            } ?>
                            </select>
                    </div>
                    </div>
                    @endif
                    <div class="col-md-2">
                        <div class="form-group">
                          <label>Select Price Type</label>
                          <select class="form-control" id="price_type" name="price_type" style="width: 100%;" required="">
                            <option value="Sale Price" <?php if ($Order_data->price_type == 'Sale Price') { echo "selected"; } ?>>Sale Price</option>
                            <option value="Bulk Price" <?php if ($Order_data->price_type == 'Bulk Price') { echo "selected"; } ?>>Bulk Sale Price(Wholesale Price)</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Select Product</label>
                          <select class="form-control select2" id="product_select2" data-placeholder="Select Product" multiple style="width: 100%;" required="">
                            <?php 
                            // echo "<pre>"; print_r($products_list); echo "</pre>"; die('end of code');
                                foreach ($products_list as $key => $value) {
                                    if($value->available_qty != 0){
                                    $selected = '';
                                    $valuess = $value->id.','.$value->name.','.$value->bulk_sale_price.','.$value->sale_price.','.$value->available_qty.','.$value->purchase_price;
                                    foreach (json_decode($Order_data->order_product)->product_id as $keys => $values) {
                                        if($values == $value->id){
                                            $selected = 'selected';
                                            if ($Order_data->price_type == 'Sale Price') {
                                                $valuess = $value->id.','.$value->name.','.$value->bulk_sale_price.','.json_decode($Order_data->order_product)->per_price[$keys].','.$value->available_qty.','.$value->purchase_price;
                                            } else {
                                                $valuess = $value->id.','.$value->name.','.json_decode($Order_data->order_product)->per_price[$keys].','.$value->sale_price.','.$value->available_qty.','.$value->purchase_price;
                                            }
                                            

                                        }
                                    }
                                    $c = 0;
                                    foreach ($products_list as $keyssss => $valuessss) {
                                        if ($valuessss->name == $value->name && $valuessss->available_qty != 0) {
                                            $c++;
                                        }
                                        
                                    }
                                    if ($c > 1) {
                                         echo "<option value='".$valuess."' ".$selected.">".$value->name.'(availabe-'.$value->available_qty.' sale price-'.$value->sale_price.' bulk sale price-'.$value->bulk_sale_price.' order date-'.$value->order_date.')'."</option>";
                                    } else {
                                         echo "<option value='".$valuess."' ".$selected.">".$value->name.'(availabe-'.$value->available_qty.')'."</option>";
                                    }
                                    }
                                     // echo "<option value='".$valuess."' ".$selected.">".$value->name.'(availabe-'.$value->available_qty.')'."</option>";
                            } ?>
                          </select>
                        </div>
                    </div>
                </div>
                <section id="product_html">
                   <?php 
                //   dd($product_list);
                    foreach (json_decode($Order_data->order_product)->product_id as $keys => $values) {
                        foreach ($products_list as $key => $value) {
                            if($values == $value->id){
                                // dd($value);
                                $id = $values;
                                $product_name = $value->name;
                                $product_available_qty = $value->available_qty;
                                $purchase_price = $value->purchase_price;
                                $product_order_qty = json_decode($Order_data->order_product)->order_qty[$keys];
                                if($Order_data->price_type == 'Sale Price'){
                                    $product_price = $value->sale_price;
                                }else{
                                    $product_price = $value->bulk_sale_price;
                                }
                                if(Auth::user()->hasRole('customer')){
                                    echo '<div class="row">
                                        <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'.$id.'" readonly="" >
                                            <div class="col-md-3">
                                                <div class="form-group text-center">
                                                    <label for="exampleInputEmail1">Product Name :</label>
                                                    <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'.$product_name.'" readonly="" >
                                                    <h4 class="" >'.$product_name.'</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group text-center">
                                                    <label for="exampleInputEmail1">Price :</label>
                                                    <input type="hidden" class="form-control" name="per_price[]" id="exampleInputEmail1" value="'.$product_price.'" readonly="" >
                                                        <h4 class="" >'.$product_price.'</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group text-center">
                                                    <label for="exampleInputEmail1">Available Qty</label>
                                                    <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'.$product_available_qty.'" readonly="">
                                                    <h4 class="" >'.$product_available_qty.'</h4>
                                                 </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Ordered Product Qty</label>
                                                    <input type="text" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" value="'.$product_order_qty.'" required="">
                                                </div>
                                            </div>
                                        </div>';
                                }else{
                                    echo '<div class="row">
                                        <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'.$id.'" readonly="" >
                                            <div class="col-md-4">
                                                <div class="form-group text-center">
                                                    <label for="exampleInputEmail1">Product Name :</label>
                                                    <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'.$product_name.'" readonly="" >
                                                    <h4 class="" >'.$product_name.'</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group text-center">
                                                    <label for="exampleInputEmail1">Purchase Price :</label>
                                                    <input type="hidden" class="form-control" id="exampleInputEmail1" value="'.$purchase_price.'" readonly="" >
                                                    <h4 class="" >'.$purchase_price.'</h4>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <div class="form-group text-center">
                                                    <label for="exampleInputEmail1">Price :</label>
                                                    <input type="hidden" class="form-control" name="per_price[]" id="exampleInputEmail1" value="'.$product_price.'" readonly="" >
                                                        <h4 class="" >'.$product_price.'</h4>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group text-center">
                                                    <label for="exampleInputEmail1">Available Qty</label>
                                                    <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'.$product_available_qty.'" readonly="">
                                                    <h4 class="" >'.$product_available_qty.'</h4>
                                                 </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Ordered Product Qty</label>
                                                    <input type="text" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" value="'.$product_order_qty.'" required="">
                                                </div>
                                            </div>
                                        </div>'; 
                                }
                                

                            }
                        }
                                        
                    }
                    ?> 
                </section>
                <div class="row">
                    @if(Auth::user()->hasRole('admin'))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Discount Amount</label>
                                <input type="number" class="form-control" name="discount_amount" id="discount_amount" value="{{ $Order_data->discount_amount }}" placeholder="Discount Amount" required="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Delivery Charges</label>
                                <input type="number" class="form-control" name="delivery_amount" id="delivery_amount" value="{{ $Order_data->delivery_amount }}" placeholder="Delivery Amount" required="">
                            </div>
                        </div>
                    @endif
                    @if(Auth::user()->hasRole('customer'))
                            <input type="hidden" class="form-control" name="discount_amount" id="discount_amount" value="{{ $Order_data->discount_amount }}" required="">
                            <input type="hidden" class="form-control" name="delivery_amount" id="delivery_amount" value="{{ $Order_data->delivery_amount }}" required="">
                    @endif
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Calculate Order Amount</label>
                            <input type="button" class="form-control btn btn-success"  id="cal_order_amount" value="Calculate Amount" placeholder="Order Amount"  required="">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Order Amount</label>
                            <input type="number" class="form-control" name="order_amount" id="order_amount" placeholder="Order Amount" value="{{ $Order_data->order_amt }}"  required="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Enter Order Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" id="order_date" name="order_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ $Order_data->order_date }}" required="">
                            </div>
                        </div> 
                    </div>
                </div>
                @if(Auth::user()->hasRole('admin'))
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Delivery Status</label>
                             <select class="form-control" id="delivery_status" name="delivery_status" data-placeholder="Select Product" style="width: 100%;" required="">
                                <option value=''>select</option>
                                <option value='1' <?php if ($Order_data->delivery_status == 1) { echo "selected"; } ?>>completed</option>
                                <option value='0' <?php if ($Order_data->delivery_status == 0) { echo "selected"; } ?>>incomplete</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select class="form-control select2" id="payment_type_id" name="payment_type_id"  data-placeholder="Select Product" style="width: 100%;" required="">
                                <option value=''>select</option>
                            <?php 
                                foreach ($payment_type_list as $key => $value) {
                                    if ($Order_data->payment_type_id == $value->id) {
                                        echo "<option value='".$value->id."' selected>".$value->name."</option>";
                                    } else {
                                        echo "<option value='".$value->id."'>".$value->name."</option>";
                                    }
                            } ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Payment Status:</label>
                            <div class="input-group date" id="payment_status"  name="" data-target-input="nearest">
                                 <select class="form-control" name="payment_status"   data-placeholder="Select Product" style="width: 100%;" required="">
                                <option value=''>select</option>
                                <option value='1' <?php if ($Order_data->payment_status == 1) { echo "selected"; } ?>>completed</option>
                                <option value='0' <?php if ($Order_data->payment_status == 0) { echo "selected"; } ?>>incomplete</option>
                          </select>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Order Status:</label>
                            <div class="input-group date"   name="" data-target-input="nearest">
                                 <select class="form-control" name="order_status"   data-placeholder="Select Product" style="width: 100%;" required="">
                                <option value=''>select</option>
                                <option value='pending' <?php if ($Order_data->order_status == 'pending') { echo "selected"; } ?>>pending</option>
                                <option value='approved' <?php if ($Order_data->order_status == 'approved') { echo "selected"; } ?>>approved</option>
                                <option value='cancel' <?php if ($Order_data->order_status == 'cancel') { echo "selected"; } ?>>cancel</option>
                          </select>
                            </div>
                        </div> 
                    </div>
                </div>
                @endif       
                    </div>
                </div>
                <!-- /input-group -->
            </div>
              <!-- /.card-body -->
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary" >Submit</button>
                   <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
