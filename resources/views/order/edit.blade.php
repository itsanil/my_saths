@extends('layouts1.main')
@section('title', 'Edit Customer Orders')
@section('section_page', 'Edit Customer Orders')
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
    var discount_rupee = 0;
    $(function () {
    //Initialize Select2 Elements
    
    var discount_status = false;
    $("input[name='product_qty[]']").inputSpinner();
    var product_array = $('#product_select2').val();
    var price = '';
    var available_qty = '';
    $('.select2').select2();
    $('#price_type').on('change',function(){
        var product_id_array = $("input[name='product_id[]']").map(function(){return $(this).val();}).get();
        var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
        $('#order_amount').val('');
        price = '';
        available_qty = '';
        product_array = $('#product_select2').val();
        console.log(product_array);
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
                product_html += '<div class="row">\
                <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="" >\
                    <div class="col-md-4">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Product Name :</label>\
                            <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="" ><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Purchase Price :</label>\
                            <input type="hidden" class="form-control" name="" id="exampleInputEmail1" value="'+data[5]+'" readonly="" ><h5 class="" >&nbsp;'+data[5]+'</h5>\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group text-center"><label for="exampleInputEmail1">Price :</label>\
                            <h5  >'+product_price+'</h5></div>\
                    </div>\
                    <div class="col-md-2">\
                    <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Available Qty</label>\
                            <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly=""><input type="hidden" class="form-control" name="av_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly=""><input type="hidden" class="'+data[0]+'-qty"  name="available_qtys[]" id="exampleInputEmail1" value="'+data[4]+'" readonly="">&nbsp;<h5 id="'+data[0]+'-qty" >'+data[4]+'</h5>\
                        </div>\
                        </div>\
                    <div class="col-md-2">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Enter Product Qty</label>\
                            <input type="number" min="1" max="'+order_product_qty_max+'" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" required="" value="'+order_product_qty+'">\
                        </div>\
                    </div>\
                </div>';
        });
        $('#product_html').html(product_html);
        $("input[name='product_qty[]']").inputSpinner();
        getamount();
        
    });
    $('#product_select2').on('change',function(){
        var product_id_array = $("input[name='product_id[]']").map(function(){return $(this).val();}).get();
        var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
        $('#order_amount').val('');
        price = '';
        available_qty = '';
        product_array = $('#product_select2').val();
        console.log(product_array);
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
                product_html += '<div class="row">\
                <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="" >\
                    <div class="col-md-4">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Product Name :</label>\
                            <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="" ><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Purchase Price :</label>\
                            <input type="hidden" class="form-control" name="" id="exampleInputEmail1" value="'+data[5]+'" readonly="" ><h5 class="" >&nbsp;'+data[5]+'</h5>\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group text-center"><label for="exampleInputEmail1">Price :</label>\
                            <h5  >'+product_price+'</h5></div>\
                    </div>\
                    <div class="col-md-2">\
                    <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Available Qty</label>\
                            <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly=""><input type="hidden" class="form-control" name="av_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly=""><input type="hidden" class="'+data[0]+'-qty"  name="available_qtys[]" id="exampleInputEmail1" value="'+data[4]+'" readonly="">&nbsp;<h5 id="'+data[0]+'-qty" >'+data[4]+'</h5>\
                        </div>\
                        </div>\
                    <div class="col-md-2">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Enter Product Qty</label>\
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

    getamount();
    
        $('.order_qty').on('change',function(){
                getamount();
        });

        $('#delivery_amount').keyup(function(){
            getamount();
        });
        $('#discount_amount').keyup(function(){
            getamounts();
        });

    });

    function combo(){
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
                    if($(this).val().indexOf("combo") < 0){
                        // var id_array = (q).split(',');
                        $.each((q).split('_'), function(a, b ) {
                            $.each(JSON.parse(combo_product), function(c, d ) {
                                if (b == d) {
                                    console.log(b);
                                    var qty =product_a_array[i] - product_qty_array[k]*JSON.parse(combo_qty)[c];
                                    $('#'+q+'-qty').html(qty);
                                    $('.'+q+'-qty').val(qty);
                                    $("input[name='product_qty[]']").map(function(e,f){
                                        if(e == i){
                                            $(this).attr('max',qty);
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
                                        $('#'+v+'-qty').html(c_qty);
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

    }

        function getamount(){
                $('#discount_amount').val(parseInt($('#discount_amount').val()) - parseInt(discount_rupee));
                if($('#price_type').val() == 'Sale Price'){
                    var price_type = 3;
                }else{
                    var price_type = 2;
                }
                var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
                combo();
                var product_array = $('#product_select2').val();
                var order_amount = 0;
                    $.each(product_array, function(index, value ) {
                    var data = (value).split(',');
                    order_amount += data[price_type]*product_qty_array[index]; 
                });
                if($('#customer_id').val() == ''){
                    toastr.error('Please Select Customer.');
                }
                $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ route("validate_voucher") }}',
                    data: {
                      'voucher_code': $('#voucher_code').val(),
                      'customer_id': $('#customer_id').val(),
                      'order_amount': order_amount
                    },
                    success: function(response) {
                        if (response.success) {
                            discount_rupee = response.discount;
                            discount_status = true;
                            // if()
                            $('#discount_amount').val(parseInt($('#discount_amount').val()) + parseInt(response.discount));
                            $('#voucher_id').val(response.voucher_id);
                            // getamount();
                            toastr.success(response.message); 
                        }
                        else{
                            discount_status = false;
                            discount_rupee = 0;
                            $('#voucher_id').val(0);
                            // toastr.error(response.message); 
                        }
                      
                    },
                });
                if($('#delivery_amount').val() && $('#discount_amount').val()){
                    
                    $('#order_amount').val(order_amount+parseInt($('#delivery_amount').val()) - parseInt($('#discount_amount').val()));
                }else{
                    if($('#delivery_amount').val()){
                        
                        $('#order_amount').val(order_amount+parseInt($('#delivery_amount').val()));
                    }else{
                        if($('#discount_amount').val()){
                            
                            $('#order_amount').val(order_amount - parseInt($('#discount_amount').val()));
                        }else{
                            $('#order_amount').val(order_amount);
                        }  
                    }
                }
        }

        function getamounts(){
                if($('#price_type').val() == 'Sale Price'){
                    var price_type = 3;
                }else{
                    var price_type = 2;
                }
                var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
                combo();
                var product_array = $('#product_select2').val();
                var order_amount = 0;
                    $.each(product_array, function(index, value ) {
                    var data = (value).split(',');
                    order_amount += data[price_type]*product_qty_array[index]; 
                });
                
                if($('#delivery_amount').val() && $('#discount_amount').val()){
                    
                    $('#order_amount').val(order_amount+parseInt($('#delivery_amount').val()) - parseInt($('#discount_amount').val()));
                }else{
                    if($('#delivery_amount').val()){
                        
                        $('#order_amount').val(order_amount+parseInt($('#delivery_amount').val()));
                    }else{
                        if($('#discount_amount').val()){
                            
                            $('#order_amount').val(order_amount - parseInt($('#discount_amount').val()));
                        }else{
                            $('#order_amount').val(order_amount);
                        }  
                    }
                }
        }

        function validateVoucher(){
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

                if($('#customer_id').val() == ''){
                    Status = false;
                    toastr.error('Please Select Customer.');
                }

                if(Status){
                    getamount();
                    $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ route("validate_voucher") }}',
                    data: {
                      'voucher_code': $('#voucher_code').val(),
                      'customer_id': $('#customer_id').val(),
                      'order_amount': order_amount
                    },
                    success: function(response) {
                        if (response.success) {
                            
                        }
                        else{
                            discount_status = false;
                            discount_rupee = 0;
                            $('#voucher_id').val(0);
                            toastr.error(response.message); 
                        }
                      
                    },
                });
                }
        }
</script>
<!-- <script src="{{ asset('public/adminlte/js/order/admin/edit.js') }}"></script> -->

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
        <form action="{{ route('customer-orders.update',$Order_data->id) }}" id="order_form" method="POST" accept-charset="utf-8">
            <input type="hidden" name="order_id" value="{{ $Order_data->id }}">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h3 class="card-title">Edit Customer Orders</h3>
                <a href="{{ route('customer.create') }}" style="float: right;" class="btn btn-success float-right">
                Add Customer
                </a>
            </div>
            <div class="card-body">
                @if(isset($voucher_data->voucher->voucher_code))
                    <div class="form-group"> <label>Have coupon?</label>
                        <div class="input-group"> <input type="text" class="form-control coupon" maxlength="6" id="voucher_code" name="voucher_code" placeholder="Coupon code" value="{{ $voucher_data->voucher->voucher_code }}"> <span class="input-group-append" > <input type="button" onclick="validateVoucher();" class="btn btn-primary btn-apply coupon" value="Apply"> </span> </div>
                    </div>
                @else
                    <div class="form-group"> <label>Have coupon?</label>
                        <div class="input-group"> <input type="text" class="form-control coupon" maxlength="6" id="voucher_code" name="voucher_code" placeholder="Coupon code" > <span class="input-group-append" > <input type="button" onclick="validateVoucher();" class="btn btn-primary btn-apply coupon" value="Apply"> </span> </div>
                    </div>
                @endif
                <input type="hidden" id="voucher_id" name="voucher_id" value="">
                <div class="row">
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
                    <div class="col-md-2">
                        <div class="form-group">
                          <label>Select Price Type</label>
                          <select class="form-control" id="price_type" name="price_type" style="width: 100%;" required="">
                            <option value="Sale Price" <?php if ($Order_data->price_type == 'Sale Price') { echo "selected"; } ?>>Sale Price</option>
                            <option value="Bulk Price" <?php if ($Order_data->price_type == 'Bulk Price') { echo "selected"; } ?>>Bulk Sale Price(Wholesale Price)</option>
                          </select>
                        </div>
                    </div>
                    <?php 
                        foreach ($unique_product_list as $key => $value) {
                            if (strpos($value['id'], 'combo')) {
                                echo "<input type='hidden' id='".$value['id']."' product_id='".$value['id_array']."' qty='".$value['qty_arry']."'>";
                            }
                        }
                    ?>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Select Product</label>
                          <select class="form-control select2" id="product_select2" data-placeholder="Select Product" multiple style="width: 100%;" required="">
                            <?php 
                            // echo "<pre>"; print_r($products_list); echo "</pre>"; die('end of code');
                                foreach ($unique_product_list as $key => $value) {
                                    if($value['available_qty'] != 0){
                                    $selected = '';
                                    $valuess = $value['id'].','.$value['name'].','.$value['bulk_sale_price'].','.$value['sale_price'].','.$value['available_qty'].','.$value['purchase_price'];
                                    foreach (json_decode($Order_data->order_product)->product_id as $keys => $values) {
                                         $product_id_array = explode('_', $value['id']);
                                         $order_product_id_array = explode('_', $values);
                                        $status = false;
                                         foreach ($order_product_id_array as $key => $order_product_id) {
                                            if(in_array($order_product_id, $product_id_array)){
                                                 $status = true;
                                            }
                                         }
                                    if(in_array($values, $product_id_array) || $values == $value['id'] || $status){
                                        // if($values == $value['id']){
                                            $selected = 'selected';
                                            if ($Order_data->price_type == 'Sale Price') {
                                                $valuess = $value['id'].','.$value['name'].','.$value['bulk_sale_price'].','.json_decode($Order_data->order_product)->per_price[$keys].','.$value['available_qty'].','.$value['purchase_price'];
                                            } else {
                                                $valuess = $value['id'].','.$value['name'].','.json_decode($Order_data->order_product)->per_price[$keys].','.$value['sale_price'].','.$value['available_qty'].','.$value['purchase_price'];
                                            }
                                        }
                                    }
                                    echo "<option value='".$valuess."' ".$selected.">".$value['name'].'(availabe-'.$value['available_qty'].')'."</option>";
                                    }
                            } ?>
                          </select>
                        </div>
                    </div>
                </div>
                <section id="product_html">
                     <?php 
                            // echo "<pre>"; print_r($products_list); echo "</pre>"; die('end of code');
                        foreach ($unique_product_list as $key => $value) {
                            if($value['available_qty'] != 0){
                                foreach (json_decode($Order_data->order_product)->product_id as $keys => $values) {
                                     $product_id_array = explode('_', $value['id']);
                                     $order_product_id_array = explode('_', $values);
                                     $status = false;
                                     foreach ($order_product_id_array as $key => $order_product_id) {
                                        if(in_array($order_product_id, $product_id_array)){
                                             $status = true;
                                        }
                                     }
                                    if(in_array($values, $product_id_array) || $values == $value['id'] || $status){
                                    $id = $values;
                                    $product_name = $value['name'];
                                    $product_available_qty = $value['available_qty'];
                                    $purchase_price = $value['purchase_price'];
                                    $product_order_qty = json_decode($Order_data->order_product)->order_qty[$keys];
                                    if($Order_data->price_type == 'Sale Price'){
                                        $product_price = $value['sale_price'];
                                    }else{
                                        $product_price = $value['bulk_sale_price'];
                                    }
                                    //sgp changes start
                                    $product_price = json_decode($Order_data->order_product)->per_price[$keys];
                                    //sgp changes end
                                    $max_order_qty = $product_available_qty;
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
                            <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'.$product_available_qty.'" readonly=""><input type="hidden" class="form-control" name="av_qty[]" id="exampleInputEmail1" value="'.$product_available_qty.'" readonly=""><input type="hidden" class="'.$id.'-qty"  name="available_qtys[]" id="exampleInputEmail1" value="'.$product_available_qty.'" readonly="">&nbsp;<h5 id="'.$id.'-qty" >'.$product_available_qty.'</h5>
                                                     </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Ordered Product Qty</label>
                                                        <input type="number" min="1" max="'.$max_order_qty.'" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" value="'.$product_order_qty.'" onKeyDown="return false" required="">
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Discount Amount</label>
                            <input type="number" class="form-control" name="discount_amount" id="discount_amount" value="{{ $Order_data->discount_amount }}" placeholder="Discount Amount" required="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Delivery Charges</label>
                            <input type="number" class="form-control" name="delivery_amount" id="delivery_amount" value="{{ $Order_data->delivery_amount }}" placeholder="Delivery Amount" required="">
                        </div>
                    </div>
                    <div class="col-md-3">
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
                          </select>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
              <!-- /.card-body -->
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary" >Confirm</button>
                   <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
