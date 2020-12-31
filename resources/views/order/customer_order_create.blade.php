@extends('layouts1.main')
@section('title', 'Add Order')
@section('section_page', 'Add Order')
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
    var price = '';
    var available_qty = '';
    $('.select2').select2();
    $('#price_type').on('change',function(){
        $('#order_amount').val('');
        price = '';
        available_qty = '';
        var product_array = $('#product_select2').val();
        if($('#price_type').val() == 'Sale Price'){
                 var price_type = 3;
            }else{
                var price_type = 2;
            }
        var product_html = '';
        $.each(product_array, function( index, value ) {
                if(index != 0){
                    price += ',';
                    available_qty += ',';
                }
                var data = (value).split(',');
                price += data[price_type];
                available_qty += data[4];
                if (price_type == 3) {
                    var product_price = data[3];
                } else {
                    var product_price = data[2]
                }
                product_html += '<div class="row">\
                <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="" >\
                    <div class="col-md-3">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Product Name :</label>\
                            <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="" ><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                    </div>\
                    <div class="col-md-3">\
                        <div class="form-group text-center"><label for="exampleInputEmail1">Price :</label>\
                            <h5  >'+product_price+'</h5></div>\
                    </div>\
                    <div class="col-md-3">\
                    <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Available Qty</label>\
                            <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly=""><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                        </div>\
                    <div class="col-md-3">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Enter Product Qty</label>\
                            <input type="text" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" required="">\
                        </div>\
                    </div>\
                </div>';
        });
        $('#product_html').html(product_html);
        
    });
    $('#product_select2').on('change',function(){
        
        $('#order_amount').val('');
        price = '';
        available_qty = '';
        var product_array = $('#product_select2').val();
        if($('#price_type').val() == 'Sale Price'){
                 var price_type = 3;
            }else{
                var price_type = 2;
            }
        var product_html = '';
        $.each(product_array, function( index, value ) {
                if(index != 0){
                    price += ',';
                    available_qty += ',';
                }
                var data = (value).split(',');
                price += data[price_type];
                available_qty += data[4];
                if (price_type == 3) {
                    var product_price = data[3];
                } else {
                    var product_price = data[2];
                }
                product_html += '<div class="row">\
                <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="" >\
                    <div class="col-md-3">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Product Name :</label>\
                            <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="" ><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                    </div>\
                    <div class="col-md-3">\
                        <div class="form-group text-center"><label for="exampleInputEmail1">Price :</label>\
                            <h5  >'+product_price+'</h5></div>\
                    </div>\
                    <div class="col-md-3">\
                    <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Available Qty</label>\
                            <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly=""><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                        </div>\
                    <div class="col-md-3">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Enter Product Qty</label>\
                            <input type="text" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" required="">\
                        </div>\
                    </div>\
                </div>';
        });
        $('#product_html').html(product_html);
        
    });
        $('#cal_order_amount').on('click',function(){
            var status = true;
            var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
            var available_qty_array = $("input[name='available_qty[]']").map(function(){return $(this).val();}).get();
            $.each(product_qty_array, function( index, value ) {
                    if(parseInt(value) > parseInt(available_qty_array[index])){
                        toastr.error('Order quantity can not be greater than available quantity');
                        status = false;
                        return false; 
                    }
            });
            $('#order_amount').val('');
            var price_array = (price).split(',');
            var available_qty_array = (available_qty).split(',');
            // console.log(price_array);
            var order_amount = 0;
            if($('#product_qty').val() == ''){
                $('#order_amount').val('');
            }
            if($('#product_qty').val() != ''){
                var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
                $.each(product_qty_array, function( index, value ) {
                    if(value != ''){
                       order_amount += price_array[index]*value; 
                    }else{
                        toastr.error('fill quantity corresponding to product');
                        status = false;
                        return false;
                    }
                });
                if(status == true){
                    if($('#delivery_amount').val() && $('#discount_amount').val()){
                        $('#order_amount').val(order_amount+parseInt($('#delivery_amount').val()) - parseInt($('#discount_amount').val()));
                    }else{
                        toastr.error('please fill all Amount field');
                        // status = false;
                        return false;
                    }
                    
                }
            }
        });


    });
 

    // function  get_product_html
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
             <?php 
                foreach ($customer_list as $key => $value) {
                    if ($value->user_id == Auth::user()->id) {
                        $customer_id = $value->id;
                    } 
            } ?>
            <form action="{{ route('my-order.store') }}" id="order_form" method="POST" accept-charset="utf-8">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Add Order</h3>
                <a href="{{ route('customer.create') }}" style="float: right;" class="btn btn-success float-right">
                Add Customer
                </a>
            </div>
            <input type="hidden" name="customer_id" value="{{ $customer_id }}" readonly="">
            <input type="hidden" name="order_by" value="customer" readonly="">
            <input type="hidden" name="delivery_status" value="0" readonly="">
            <input type="hidden" name="payment_status" value="0" readonly="">
            <input type="hidden" name="order_status" value="pending" readonly="">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                          <label>Select Price Type</label>
                          <select class="form-control" id="price_type" name="price_type" style="width: 100%;" required="">
                            <option value="Sale Price" selected="">Sale Price</option>
                            <option value="Bulk Price">Bulk Sale Price(Wholesale Price)</option>
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
                                     echo "<option value='".$value->id."'>".$value->name."</option>";
                            } ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                          <label>Select Product</label>
                          <select class="form-control select2" id="product_select2" data-placeholder="Select Product" multiple style="width: 100%;" required="">
                            <?php 
                                foreach ($product_list as $key => $value) {
                                    // echo "<pre>"; print_r($value); echo "</pre>"; die('end of code');
                                    $c = 0;
                                    foreach ($product_list as $keys => $values) {
                                        if ($values->name == $value->name) {
                                            $c++;
                                        }
                                        
                                    }

                                    if ($c > 1) {
                                         echo "<option value='".$value->id.','.$value->name.','.$value->bulk_sale_price.','.$value->sale_price.','.$value->available_qty.','.$value->purchase_price."'>".$value->name.'(availabe-'.$value->available_qty.' sale price-'.$value->sale_price.' bulk sale price-'.$value->bulk_sale_price.' order date-'.$value->order_date.')'."</option>";
                                    } else {
                                         echo "<option value='".$value->id.','.$value->name.','.$value->bulk_sale_price.','.$value->sale_price.','.$value->available_qty.','.$value->purchase_price."'>".$value->name.'(availabe-'.$value->available_qty.')'."</option>";
                                    }
                                    
                                    
                            } ?>
                          </select>
                        </div>
                    </div>
                </div>
                <section id="product_html">
                    
                </section>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Calculate Order Amount</label>
                            <input type="button" class="form-control btn btn-success"  id="cal_order_amount" value="Calculate Amount" placeholder="Order Amount" required="">
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="delivery_amount" id="delivery_amount" value="0" required="">
                    <input type="hidden" class="form-control" name="discount_amount" id="discount_amount" value="0" required="">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Order Amount</label>
                            <input type="number" min=0 step=0.001 class="form-control" name="order_amount" id="order_amount" placeholder="Order Amount" readonly="" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Enter Order Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" id="order_date" name="order_date" class="form-control datetimepicker-input" value="<?php echo date('Y-m-d'); ?>"  data-target="#reservationdate" required="">
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary" onclick="submitform();">Submit</button>
                <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Cancel</a>
            </div>
        </form>    
    </div>
</div>
@endsection
