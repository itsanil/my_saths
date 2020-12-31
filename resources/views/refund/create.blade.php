@extends('layouts1.main')
@section('title', 'Add Refund')
@section('section_page', 'Add Refund')
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
    $('#customer_id').on('change',function(){
        $('#select_order').append('');
        $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          url: "{{ route('refund.order') }}",
          type: 'POST',
          data: {customer_id:$('#customer_id').val()},
          success: function (response) {
            if (response.success) {
                var order_html = '';
                $.each(response.data, function( index, value ) {
                    order_html += '<option value="'+value.id+'">order-id:'+value.id+'|order_amt:'+value.order_amt+'|order_date:'+value.order_date+'</option>';;
                });
                $('#select_order').append(order_html);
            } else {
               var order_html = '<option value="">no order found</option>';
                $('#select_order').append(order_html);
            }
          }
        });
    });

     $('#select_order').on('change',function(){
        $('#select_product').append('');
        $.ajax({
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          url: "{{ route('refund.product') }}",
          type: 'POST',
          data: {order_id:$('#select_order').val()},
          success: function (response) {
            if (response.success) {
                var order_html = '';
                $.each(response.data.name, function( index, value ) {
                    order_html += '<option value="'+response.data.product_id[index]+','+response.data.name[index]+','+response.data.order_qty[index]+','+response.data.per_price[index]+','+response.data.sub_price[index]+'">'+value+'(order Qty-'+response.data.order_qty[index]+')</option>';
                });
                $('#select_product').append(order_html);
                $('#order_amount').val(response.data.order_amount);
            } else {
               var order_html = '<option value="">no order found</option>';
                $('#select_product').append(order_html);
            }
          }
        });
    });

        $('#select_product').on('change',function(){
            $('#product_html').html('');
            var product_html = '';
        var product_array = $('#select_product').val();
        $.each(product_array, function( index, value ) {
                var data = (value).split(',');
                product_html += '<div class="row">\
                 <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="" >\
                    <div class="col-md-4">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Product Name :</label>\
                            <input type="text" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Order Qty</label>\
                            <input type="text" class="form-control" name="order_qty[]" id="exampleInputEmail1" value="'+data[2]+'" readonly="">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Per Qty Price</label>\
                            <input type="text" class="form-control" name="per_price[]" value="'+data[3]+'" readonly="">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Sub Price</label>\
                            <input type="text" class="form-control" name="sub_price[]" value="'+data[4]+'" readonly="">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Refund Qty</label>\
                            <input type="number" min="1" max="'+data[2]+'" class="form-control" placeholder="Enter Refund Qty" value="'+data[2]+'"  name="refund_qty[]"  required="">\
                        </div>\
                    </div>\
                </div>';
        });
        $('#product_html').html(product_html);
        
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
        
            <form action="{{ route('refund.store') }}" id="order_form" method="POST" accept-charset="utf-8">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Select Customer</label>
                          <select class="form-control select2" style="width: 100%;" name="customer_id" id="customer_id" required="">
                            <option value="">Select Customer</option>
                            <?php 
                                foreach ($customer_list as $key => $value) {
                                     echo "<option value='".$value->id."'>".$value->name.'('.$value->whatsapp_no.'-'.$value->building_name.')'."</option>";
                            } ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Select Order</label>
                          <select class="form-control select2" id="select_order" name="order_id" style="width: 100%;" required="">
                            <option value="" >First select customer</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Select Product</label>
                          <select class="form-control select2" id="select_product" name="product" data-placeholder="Select Product" multiple style="width: 100%;" required="">
                            <option value="" >First select order</option>
                          </select>
                        </div>
                    </div>
                </div>
                <section id="product_html">
                    
                </section>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Order Amount</label>
                            <input type="number" class="form-control" name="order_amount" id="order_amount" placeholder="Order Amount" readonly="" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">refund Amount</label>
                            <input type="number" class="form-control" min="0" name="refund_amount" id="refund_amount" placeholder="refund Amount" required="">
                        </div>
                    </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Enter Refund Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" id="refund_date" name="refund_date" class="form-control datetimepicker-input" value="<?php echo date('Y-m-d'); ?>"  data-target="#reservationdate" required="">
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary" onclick="submitform();">Submit</button>
            </div>
        </form>    
    </div>
</div>
@endsection
