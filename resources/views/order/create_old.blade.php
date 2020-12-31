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
    $('.select2').select2();
    $('#product_select2').on('change',function(){
        price = '';
        var product_array = $('#product_select2').val();
        if($('#price_type').val() == 'Sale Price'){
            var price_type = 2;
        }else{
            var price_type = 3;
        }
        var product_html = '';
        $.each(product_array, function( index, value ) {
                if(index != 0){
                    price += ',';
                }
                var data = (value).split(',');
                price += data[price_type];
                product_html += '<div class="row">\
                    <div class="col-md-6">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Product Name :</label>\
                            <input type="text" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="">\
                        </div>\
                    </div>\
                    <div class="col-md-6">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Enter Product Qty</label>\
                            <input type="text" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" required="">\
                        </div>\
                    </div>\
                </div>';
        });
        $('#product_html').html(product_html);
        
    });
        $('#cal_order_amount').on('click',function(){
            var price_array = (price).split(',');
            console.log(price_array);
            var order_amount = 0;
            if($('#product_qty').val() == ''){
                $('#order_amount').val('');
            }
            if($('#product_qty').val() != ''){
                var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
                console.log(product_qty_array);
                $.each(product_qty_array, function( index, value ) {
                    if(value != ''){
                       order_amount += price_array[index]*value; 
                       console.log(price_array[index]*value);
                    }
                });
                console.log(order_amount); 
              
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
        <form action="{{ route('order.store') }}" method="POST" accept-charset="utf-8">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Add Order</h3>
                <a href="{{ route('customer.create') }}" style="float: right;" class="btn btn-success float-right">
                Add Customer
                </a>
            </div>
            <input type="text" class="form-control order_qty"  id="exampleInputEmail1" placeholder="Enter Product Qty" required="">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Select Customer</label>
                          <select class="form-control select2" style="width: 100%;">
                            <option value="">Select Customer</option>
                            <?php 
                                foreach ($customer_list as $key => $value) {
                                     echo "<option value='".$value->id."'>".$value->name.'('.$value->whatsapp_no.')'."</option>";
                            } ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                          <label>Select Price Type</label>
                          <select class="form-control" id="price_type" style="width: 100%;">
                            <option value="Sale Price" selected="">Sale Price</option>
                            <option value="Bulk Price">Bulk Sale Price(Wholesale Price)</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                          <label>Select Product</label>
                          <select class="form-control select2" id="product_select2" data-placeholder="Select Product" multiple style="width: 100%;">
                            <?php 
                                foreach ($product_list as $key => $value) {
                                     echo "<option value='".$value->id.','.$value->name.','.$value->bulk_sale_price.','.$value->sale_price."'>".$value->name."</option>";
                            } ?>
                          </select>
                        </div>
                    </div>
                </div>
                <section id="product_html">
                    
                </section>
                 <div class="field_wrapper">
                    <div class="row">
                        <div class="col-md-1">
                          <div class="form-group" style="margin: 0px 12px;">
                            <label for="password">Add:</label>
                            <a href="javascript:void(0);" style="border: none;background-color: #f4f6f9;" class="add_button form-control" title="Add field">
                             <img src="{{ asset('public/images/add-icon.png') }}"/></a>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                          <label>Select Product</label>
                          <select class="form-control select2" id="product_select2" data-placeholder="Select Product"  style="width: 100%;">
                            <?php 
                                foreach ($product_list as $key => $value) {
                                     echo "<option value='".$value->id.','.$value->name.','.$value->bulk_sale_price.','.$value->sale_price."'>".$value->name."</option>";
                            } ?>
                          </select>
                        </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="password">Product Name - Quantity Packaging:</label>
                            <input type="text" placeholder="Ex: Papad - 400g" class="form-control" name="product_name[]" required="">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="password">Product Price:</label>
                            <input type="text" placeholder="Ex: Rs xxx/-" placeholder="like xyz Rs." class="form-control" name="product_price[]" required="">
                          </div>
                        </div>
                    </div>
                  </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Calculate Order Amount</label>
                            <input type="button" class="form-control" name="order_amount" id="cal_order_amount" value="Calculate Amount" placeholder="Order Amount" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Order Amount</label>
                            <input type="number" class="form-control" name="order_amount" id="order_amount" placeholder="Order Amount" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Enter Order Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" name="order_date" class="form-control datetimepicker-input" data-target="#reservationdate">
                            </div>
                        </div> 
                    </div>
                </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="Enter name" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Contact Number</label>
                            <input type="integer" class="form-control" name="contact_no" id="exampleInputEmail1" placeholder="Enter Contact Number(optional)">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Flat Number</label>
                            <input type="integer" class="form-control" name="flat_no" id="exampleInputEmail1" placeholder="Enter Flat Number(optional)" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter City Name</label>
                            <input type="text" class="form-control" name="city" id="exampleInputEmail1" placeholder="Enter City name" required="">
                        </div>
                        <div class="form-group">
                            <label for="password">Select Status</label>
                            <select class="custom-select" id="edit_role" name="status" required="">
                                <option value="" >Select Status</option>
                                <option value="1" >Active</option>
                                <option value="0" >In-Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Whatsapp Number</label>
                            <input type="integer" class="form-control" name="whatsapp_no" id="exampleInputEmail1" placeholder="Enter Whatsapp Number" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Building Name</label>
                            <input type="text" class="form-control" name="building_name" id="exampleInputEmail1" placeholder="Enter Building name" required="">
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter lane</label>
                            <input type="text" class="form-control" name="lane" id="exampleInputEmail1" placeholder="Enter lane(Optional)">
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
