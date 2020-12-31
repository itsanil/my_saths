@extends('layouts1.main')
@section('title', 'Add Order-Cart')
@section('section_page', 'Add Order-Cart')
@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- Select2 -->
<script src="{{ asset('public/adminlte/js/bootstrap-input-spinner.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function () {
        $('#order_disc').hide();
        //Initialize Select2 Elements
        $('#empty_cart').on('click',function(){
            var route = "{{ url('add-cart') }}";
             $.get(route, { product_id: '' }, function (data) {
                  $('.navbar-badge').html('0');
                  window.location.reload();
                    return data;
                });
        });

    var price = '';
    var available_qty = '';
    $('.select2').select2();
        $('#product_select2').on('change',function(){
            var product_id_array = $("input[name='product_id[]']").map(function(){return $(this).val();}).get();
            var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
            $('#order_amount').val('');
            price = '';
            available_qty = '';
            var product_array = $('#product_select2').val();
            var price_type = 3;
                
            var product_html = '';
            $.each(product_array, function( index, value ) {
                    if(index != 0){
                        price += ',';
                        available_qty += ',';
                    }
                    var data = (value).split(',');
                    price += data[price_type];
                    available_qty += data[4];
                    var product_price = data[3];
                    var order_product_qty = 1;
                    $.each(product_id_array, function( key, values ) {
                        if(data[0] == values){
                            order_product_qty = product_qty_array[key];
                        }
                    });
                    if(data[4] > 10){
                        var  order_product_qty_max = 10; 
                    }else{
                        var order_product_qty_max = data[4];
                    } 
                    if (index == 0) {
                        var product_header = '<b style="color:#64c145;"><u>Product Details</u> </b><br/>';
                        var qty_header = '<b style="color:#64c145;"> <u>Order Quantity</u></b><br/>';
                    } else {
                        var product_header = '';
                        var qty_header = '';
                    }
                    product_html += '<div class="row">\
                    <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="" >\
                    <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly="" >\
                    <input type="hidden" class="form-control" name="av_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly=""><input type="hidden" class="'+data[0]+'-qty"  name="available_qtys[]" id="exampleInputEmail1" value="'+data[4]+'" readonly="">\
                    <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="" >\
                        <div class="col-md-6">\
                            <div class="form-group text-center">'+product_header+'\
                            <label class="" >&nbsp;'+data[1]+' @ Rs. '+product_price+'</label>\
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group text-center">'+qty_header+'\
                            <input type="number" min="1" max="'+order_product_qty_max+'" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" required="" value="'+order_product_qty+'">\
                            </div>\
                        </div>\
                    </div>';
            });
            $('#product_html').html(product_html);
            $("input[name='product_qty[]']").inputSpinner();
            getamount();
            $('.order_qty').on('change',function(){
                getamount();
            });
        });
    });

        var product_id_array = $("input[name='product_id[]']").map(function(){return $(this).val();}).get();
        var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
        $('#order_amount').val('');
        price = '';
        available_qty = '';
        var product_array = $('#product_select2').val();
        var price_type = 3;
            
        var product_html = '';
        $.each(product_array, function( index, value ) {
                if(index != 0){
                    price += ',';
                    available_qty += ',';
                }
                var data = (value).split(',');
                price += data[price_type];
                available_qty += data[4];
                var product_price = data[3];
                var order_product_qty = 1;
                $.each(product_id_array, function( key, values ) {
                    if(data[0] == values){
                        order_product_qty = product_qty_array[key];
                    }
                });
                if(data[4] > 10){
                    var  order_product_qty_max = 10; 
                }else{
                    var order_product_qty_max = data[4];
                } 
                if (index == 0) {
                    var product_header = '<b style="color:#64c145;"><u>Product Details</u> </b><br/>';
                    var qty_header = '<b style="color:#64c145;"> <u>Order Quantity</u></b><br/>';
                } else {
                    var product_header = '';
                    var qty_header = '';
                }
                product_html += '<div class="row">\
                <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="" >\
                <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly="" >\
                <input type="hidden" class="form-control" name="av_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly=""><input type="hidden" class="'+data[0]+'-qty"  name="available_qtys[]" id="exampleInputEmail1" value="'+data[4]+'" readonly="">\
                <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="" >\
                    <div class="col-md-6">\
                        <div class="form-group text-center">'+product_header+'\
                        <label class="" >&nbsp;'+data[1]+' @ Rs. '+product_price+'</label>\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group text-center">'+qty_header+'\
                        <input type="number" min="1" max="'+order_product_qty_max+'" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" required="" value="'+order_product_qty+'">\
                        </div>\
                    </div>\
                </div>';
        });
        $('#product_html').html(product_html);
        $("input[name='product_qty[]']").inputSpinner();
            getamount();
        $('.order_qty').on('change',function(){
            getamount();
        });

        if($('#price_type').val() == 'Sale Price'){
            var price_type = 3;
        }else{
            var price_type = 2;
        }
        var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
        var product_array = $('#product_select2').val();
        var order_amount = 0;
        $.each(product_array, function(index, value ) {
            var data = (value).split(',');
            order_amount += data[3]*product_qty_array[index];
        });
        $('#order_amount').val(order_amount);


        function validateVoucher(){
            $('#order_disc').hide();
            if($('#price_type').val() == 'Sale Price'){
                    var price_type = 3;
                }else{
                    var price_type = 2;
                }
                var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
                var product_array = $('#product_select2').val();
                var order_amount = 0;
                    $.each(product_array, function(index, value ) {
                    var data = (value).split(',');
                    order_amount += data[price_type]*product_qty_array[index]; 
                });
                var Status = true;

                if(order_amount == 0){
                    Status = false;
                    toastr.error('Please Select Product.');
                }

                if($('#voucher_code').val() == ''){
                    Status = false;
                    toastr.error('Please Enter Coupon code.');
                }


                if(Status){
                    $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        url: '{{ route("validate_voucher") }}',
                        data: {
                          'voucher_code': $('#voucher_code').val(),
                          'customer_id': 'customer',
                          'order_amount': order_amount
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#order_disc').show();
                                $('#discount_amount').val(response.discount);
                                $('#voucher_id').val(response.voucher_id);
                                $('#order_amount').val(order_amount - response.discount);
                                toastr.success(response.message); 
                            }else{
                                $('#order_disc').hide();
                                $('#discount_amount').val(0);
                                $('#voucher_id').val(0);
                                $('#order_amount').val(order_amount);
                                toastr.error(response.message); 
                            }
                          
                        },
                    });
                }
        }

        function getamount(){
                if($('#price_type').val() == 'Sale Price'){
                    var price_type = 3;
                }else{
                    var price_type = 2;
                }
                var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
                var product_a_array = $("input[name='av_qty[]']").map(function(){return $(this).val();}).get();
                $("input[name='product_id[]']").map(function(k,v){
                    v = $(this).val();
                    var c_qty = 0;
                    if($(this).val().indexOf("combo") > 0){

                        var index = k;
                        var combo_product = $('#'+$(this).val()).attr('product_id');
                        var combo_qty = $('#'+$(this).val()).attr('qty');
                        $("input[name='product_id[]']").map(function(i,q){
                            q = $(this).val();
                            console.log(q);
                            if($(this).val().indexOf("combo") < 0){
                                // var id_array = (q).split(',');
                                $.each((q).split('_'), function(a, b ) {
                                    $.each(JSON.parse(combo_product), function(c, d ) {
                                        if (b == d) {
                                            var qty =product_a_array[i] - product_qty_array[k]*JSON.parse(combo_qty)[c];
                                            $('.'+q+'-qty').val(qty);
                                            $("input[name='product_qty[]']").map(function(e,f){
                                                if(e == i){
                                                    if (qty > 10) {
                                                        $(this).attr('max',10);
                                                    } else {
                                                        $(this).attr('max',qty);
                                                    }
                                                    if(qty > 0){
                                                        $(this).attr('min',1);
                                                    }else{
                                                        $(this).attr('min',0);
                                                    }
                                                }
                                            });
                                            $("input[name='available_qty[]']").map(function(m,n){
                                                if(m == i){
                                                    $(this).val(qty);
                                                    // $(this).attr('min',0);
                                                }
                                            });
                                        } 
                                    });
                                });
                                
                                $.each(JSON.parse(combo_product), function(g, h ) {
                                    // h = $(this).val();
                                    $.each((q).split('_'), function(m,n ) {
                                        if (h == n) {
                                            
                                            c_qty = ((product_a_array[i]-$('#'+q+'-qty').html())/JSON.parse(combo_qty)[g] + "").split('.')[0];
                                                $('.'+v+'-qty').val(c_qty);
                                            $("input[name='product_qty[]']").map(function(e,f){
                                                if(e == k){
                                                    
                                                $("input[name='available_qty[]']").map(function(x,y){
                                                    if(x == i){
                                                        $(this).val(c_qty);
                                                        // $(this).attr('min',0);
                                                    }
                                                });
                                                }

                                            });
                                            
                                        } 
                                    });

                                });
                            }
                        });
                    }
                    // return $(this).val();
                });
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
                           $.ajax({
                                headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: 'POST',
                                url: '{{ route("validate_voucher") }}',
                                data: {
                                  'voucher_code': $('#voucher_code').val(),
                                  'customer_id': 'customer',
                                  'order_amount': order_amount
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#order_disc').show();
                                        $('#discount_amount').val(response.discount);
                                        $('#voucher_id').val(response.voucher_id);
                                        $('#order_amount').val(order_amount - response.discount);
                                        toastr.success(response.message); 
                                    }else{
                                        $('#order_disc').hide();
                                        $('#discount_amount').val(0);
                                        $('#voucher_id').val(0);
                                        $('#order_amount').val(order_amount);
                                        // toastr.error(response.message); 
                                    }
                                  
                                },
                        });
                    }
                }
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
        @include('layouts1.include.searchbox')
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
                <input type="button" value="Empty Cart" id="empty_cart" style="float: right;" class="btn btn-success float-right">
            </div>
            <input type="hidden" name="customer_id" value="{{ $customer_id }}" readonly="">
            <input type="hidden" name="price_type" value="Sale Price" readonly="">
            <?php 
                foreach ($unique_product_list as $key => $value) {
                    if (strpos($value['id'], 'combo')) {
                        echo "<input type='hidden' id='".$value['id']."' product_id='".$value['id_array']."' qty='".$value['qty_arry']."'>";
                    }
                }
            ?>
            <div class="card-body">
                <div class="form-group"> <label>Have coupon?</label>
                    <div class="input-group"> <input type="text" class="form-control coupon" maxlength="6" id="voucher_code" name="voucher_code" placeholder="Coupon code"> <span class="input-group-append" > <input type="button" onclick="validateVoucher();" class="btn btn-primary btn-apply coupon" value="Apply"> </span> </div>
                </div>
                <input type="hidden" id="voucher_id" name="voucher_id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label>Select Product</label>
                          <select class="form-control select2" id="product_select2" data-placeholder="Select Product" multiple style="width: 100%;" required="">
                            <?php 
                                foreach ($unique_product_list as $key => $value) {
                                    if($value['available_qty'] != 0){
                                        $product_id_array = explode('_', $value['id']);
                                        $selected = '';
                                        foreach ($cart_product_id_array as $keys => $values) {
                                            if(in_array($values, $product_id_array)){
                                                // echo "<pre>"; print_r($product_id_array); echo "</pre>"; die('end of code');
                                               $selected = 'selected';
                                            }
                                            
                                        }
                                        echo "<option value='".$value['id'].','.$value['name'].','.$value['bulk_sale_price'].','.$value['sale_price'].','.$value['available_qty'].','.$value['purchase_price']."' ".$selected.">".$value['name'].'(availabe)'."</option>";
                                    }
                                }
                            ?>
                          </select>
                        </div>
                    </div>
                </div>
                <section id="product_html">
                    
                </section>
                <div class="row">
                    <div class="col-md-12" id="order_disc">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Discount</label>
                            <input type="number" min=0 step=0.001 class="form-control" name="discount_amount" id="discount_amount" placeholder="Total Discount Amt" readonly="" required="">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Total Cart Value</label>
                            <input type="number" min=0 step=0.001 class="form-control" name="order_amount" id="order_amount" placeholder="Total Cart Value" readonly="" required="">
                        </div>
                    </div>
                    
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label>Enter Order Date:</label> -->
                                <input type="hidden" id="order_date" name="order_date" class="form-control datetimepicker-input" value="<?php echo date('Y-m-d'); ?>"  data-target="#reservationdate" readonly="">
                        <!-- </div> 
                    </div> -->
                </div>
            </div>
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary" onclick="submitform();">Confirm</button>
                <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Cancel</a>
            </div>
        </form>    
    </div>
</div>

 <div class="card">
            <div class="card-header bg-warning">
              <b><label class="card-title" style="color:white;">Contact Us</label></b>
            </div>
            <div class="card-body p-0">
               <div class="row" style="padding: 25px;">
                  <div class="col-md-12">
                    <span>
                      WhatsApp or Call us: <label>9321504147</label> | 10:00 AM to 7:00 PM, <label>365</label> days.<br/>
                      <a href="{{ url('terms-and-condition') }}" target="_blank" title="">Terms and Conditions</a>,
                      <a href="{{ url('privacy-policy') }}" target="_blank" title="">Privacy Policy</a>,
                      <a href="{{ url('disclaimer') }}" target="_blank" title="">Disclaimer</a>.
                    </span>
                  </div>
                </div>
            </div>
</div>
@endsection
