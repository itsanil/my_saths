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
<script src="{{ asset('public/adminlte/js/bootstrap-input-spinner.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('public/adminlte/js/order/customer/edit.js') }}"></script>
<script>
     $("input[name='product_qty[]']").inputSpinner();

     $(function () {
    //Initialize Select2 Elements
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
                product_html += '<div class="row">\
                <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="" >\
                <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly="" >\
                    <div class="col-md-5">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Product Name :</label>\
                            <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="" ><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                    </div>\
                    <div class="col-md-5">\
                        <div class="form-group text-center"><label for="exampleInputEmail1">Price :</label>\
                            <h5  >'+product_price+'</h5></div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Enter Product Qty</label>\
                            <input type="number" min="1" max="'+order_product_qty_max+'" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" required="" value="1">\
                        </div>\
                    </div>\
                </div>';
        });
        $('#product_html').html(product_html);
        $("input[name='product_qty[]']").inputSpinner();
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
                        $('#order_amount').val(order_amount);
                }
            }
            $('.order_qty').on('change',function(){
                // alert('jnj');
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
                            $('#order_amount').val(order_amount);
                    }
                }
            });
        });

            $('.order_qty').on('change',function(){
                $('#order_amount').val('');
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
                $('#order_amount').val(order_amount);
               
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

        <form action="{{ route('my-order.update',$Order_data->id) }}" id="order_form" method="POST" accept-charset="utf-8">
            <input type="hidden" name="order_id" value="{{ $Order_data->id }}">
            @csrf
            @method('POST')
            <div class="card-header">
                <h3 class="card-title">Edit Order</h3>
                 <?php 
                    foreach ($customer_list as $key => $value) {
                        if ($value->user_id == Auth::user()->id) {
                            $customer_id = $value->id;
                        } 
                } ?>
            </div>
            <div class="card-body">
                <div class="row">
                        <input type="hidden" name="customer_id" value="{{ $customer_id }}" readonly="">
                        <input type="hidden" name="price_type" id="price_type" value="{{ $Order_data->price_type }}" readonly="">
                    <div class="col-md-12">
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
                                         echo "<option value='".$valuess."' ".$selected.">".$value->name.'(availabe)'."</option>";
                                    } else {
                                         echo "<option value='".$valuess."' ".$selected.">".$value->name.'(availabe)'."</option>";
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
                                if($product_available_qty > 10){
                                    $max_order_qty = 10;
                                }else{
                                    $max_order_qty = $product_available_qty;
                                }
                                    echo '<div class="row">
                                        <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'.$id.'" readonly="" >
                                        <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'.$product_available_qty.'" readonly="" >
                                            <div class="col-md-8">
                                                <div class="form-group text-center">
                                                    <label for="exampleInputEmail1">Product Name :</label>
                                                    <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'.$product_name.'" readonly="" >
                                                    <h4 class="" >'.$product_name.'</h4>
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
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Ordered Product Qty</label>
                                                    <input type="mumber" min="1" max="'.$max_order_qty.'" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" value="'.$product_order_qty.'" required="">
                                                </div>
                                            </div>
                                        </div>';
                            }
                        }
                                
                    }
                    ?> 
                </section>
                <div class="row">
                           
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Order Amount</label>
                            <input type="number" class="form-control" name="order_amount" id="order_amount" placeholder="Order Amount" value="{{ $Order_data->order_amt }}"  required="" readonly="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Enter Order Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" id="order_date" name="order_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ $Order_data->order_date }}" required="">
                            </div>
                        </div> 
                    </div>
                </div>
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
