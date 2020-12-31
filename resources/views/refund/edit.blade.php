@extends('layouts1.main')
@section('title', 'Edit Refund')
@section('section_page', 'Edit Refund')
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
    // $('#select_product').append('');
    //     $.ajax({
    //       headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //       url: "{{ route('refund.product') }}",
    //       type: 'POST',
    //       data: {order_id:$('#select_order').val()},
    //       success: function (response) {
    //         if (response.success) {
    //             var order_html = '';
    //             $.each(response.data.name, function( index, value ) {
    //                 order_html += '<option value="'+response.data.product_id[index]+','+response.data.name[index]+','+response.data.order_qty[index]+','+response.data.per_price[index]+','+response.data.sub_price[index]+'">'+value+'(order Qty-'+response.data.order_qty[index]+')</option>';
    //             });
    //             $('#select_product').append(order_html);
    //             $('#order_amount').val(response.data.order_amount);
    //         } else {
    //            var order_html = '<option value="">no order found</option>';
    //             $('#select_product').append(order_html);
    //         }
    //       }
    //     });

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
        
            <form action="{{ route('refund.update',$refund_data->id) }}" id="order_form" method="POST" accept-charset="utf-8">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Select Customer</label>
                          <select class="form-control select2" style="width: 100%;" name="customer_id" id="customer_id" required="">
                            <option value="">Select Customer</option>
                            <?php 
                            // echo "<pre>"; print_r($refund_data->customer_id); echo "</pre>"; die('end of code');
                                foreach ($customer_list as $key => $value) {
                                    if ($refund_data->customer_id == $value->id) {
                                        echo "<option value='".$value->id."' selected>".$value->name.'('.$value->whatsapp_no.'-'.$value->building_name.')'."</option>";
                                    } else {
                                        echo "<option value='".$value->id."'>".$value->name.'('.$value->whatsapp_no.'-'.$value->building_name.')'."</option>";
                                    }
                            } ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Select Order</label>
                          <select class="form-control select2" id="select_order" name="order_id" style="width: 100%;" required="">
                            <option value="" >First select customer</option>
                            <option value="{{ $refund_data->order_id }}" selected="">order-id:{{ $refund_data->order_id }}|order_amt:{{ $refund_data->order->order_amt }}|order_date:{{ $refund_data->order->order_date }}</option>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Select Product</label>
                          <select class="form-control select2" id="select_product" name="product" data-placeholder="Select Product" multiple style="width: 100%;" required="">
                            <?php 
                                foreach (json_decode($refund_data->refund_product)->product_id as $key => $values) {
                                    $id = $values;
                                    echo '<option value="'.$id.','.json_decode($refund_data->refund_product)->product_name[$key].','.json_decode($refund_data->refund_product)->order_qty[$key].','.json_decode($refund_data->refund_product)->per_price[$key].','.json_decode($refund_data->refund_product)->sub_price[$key].'" selected>'.json_decode($refund_data->refund_product)->product_name[$key].'(order Qty-'.json_decode($refund_data->refund_product)->order_qty[$key].')</option>';
                                }
                            ?>
                          </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="refund_id" value="{{ $refund_data->id }}">
                <section id="product_html">
                   <?php 
                    foreach (json_decode($refund_data->refund_product)->product_id as $key => $values) {
                                $id = $values;
                                // echo "<pre>"; print_r(json_decode($refund_data->refund_product)->product_name); echo "</pre>"; die('end of code');   
                                echo '<div class="row">
                                        <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'.$id.'" readonly="" >
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Product Name :</label>
                                                    <input type="text" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'.json_decode($refund_data->refund_product)->product_name[$key].'" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Order Qty</label>
                                                    <input type="text" class="form-control" name="order_qty[]" id="exampleInputEmail1" value="'.json_decode($refund_data->refund_product)->order_qty[$key].'" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Per Qty Price</label>
                                                    <input type="text" class="form-control" name="per_price[]" value="'.json_decode($refund_data->refund_product)->per_price[$key].'" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Sub Price</label>
                                                    <input type="text" class="form-control" name="sub_price[]" value="'.json_decode($refund_data->refund_product)->sub_price[$key].'" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Refund Qty</label>
                                                    <input type="number" min="1" max="'.json_decode($refund_data->refund_product)->order_qty[$key].'" class="form-control" placeholder="Enter Refund Qty" value="'.json_decode($refund_data->refund_product)->refund_qty[$key].'"  name="refund_qty[]"  required="">
                                                </div>
                                            </div>
                                        </div>';

                            }
                                        
                    ?> 
                </section>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Order Amount</label>
                            <input type="number" class="form-control" name="order_amount" id="order_amount" placeholder="Order Amount" readonly="" value="{{ $refund_data->order->order_amt }}" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">refund Amount</label>
                            <input type="number" class="form-control" min="0" name="refund_amount" id="refund_amount" placeholder="refund Amount" value="{{ $refund_data->refund_amount }}" required="">
                        </div>
                    </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Enter Refund Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" id="refund_date" name="refund_date" class="form-control datetimepicker-input" value="{{ $refund_data->refund_date }}"  data-target="#reservationdate" required="">
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
