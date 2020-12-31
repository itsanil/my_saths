@extends('layouts1.main')
@section('title', 'Edit Purchase')
@section('section_page', 'Edit Purchase')
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

        $('#select_product').on('change',function(){
        $('#order_amount').val('');
        var product_array = $('#select_product').val();
        var product_html = '';
        $.each(product_array, function( index, value ) {
             var data = (value).split('}');
                product_html += '<input type="hidden" name="img[]" value="'+data[1]+'"><div class="row">\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Product Name :</label>\
                            <input type="text" class="form-control" name="name[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">purchase Qty</label>\
                            <input type="number" class="form-control " name="purchase_qty[]" id="purchase_qty'+index+'"  placeholder="Enter purchase Qty" required="">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Enter Net Amount</label>\
                            <input type="number" min=0 step=0.001 class="form-control" name="net_amt[]" id="net_amt'+index+'" placeholder="Enter Net Amount" required="">\
                        </div>\
                    </div>\
                    <div class="col-md-2">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Purchase Price</label>\
                            <input type="text" min=0 step=0.001 class="form-control" name="purchase_price[]" id="purchase_price'+index+'" placeholder="Purchase Price " required="" readonly>\
                        </div>\
                    </div>\
                     <div class="col-md-2">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Enter Bulk Sale Price</label>\
                            <input type="number" min=0 step=0.001 class="form-control" name="bulk_sale_price[]" id="exampleInputEmail1" placeholder="Enter Bulk Sale Price" required="">\
                        </div>\
                    </div>\
                     <div class="col-md-2">\
                        <div class="form-group">\
                            <label for="exampleInputEmail1">Enter Sale Price</label>\
                            <input type="number" min=0 step=0.001 class="form-control" name="sale_price[]" id="exampleInputEmail1" placeholder="Enter Sale Price" required="">\
                        </div>\
                    </div>\
                </div>';
                
        });
        $('#product_html').html(product_html);
        
    });
    $('#cal_order_amount').on('click',function(){
            var total_amt = 0;
            var product_array = $("input[name='net_amt[]']").map(function(){return $(this).val();}).get();
            $.each(product_array, function( index, value ) {
                $('#purchase_price'+index+'').val($('#net_amt'+index+'').val()/$('#purchase_qty'+index+'').val());
                total_amt += parseInt($('#net_amt'+index+'').val());
            });
            $('#order_amount').val(total_amt);
    });
        // $('.purchase_qty').keyup(function(){
        //     alert('djfbj');
        //     var product_qty_array = $("input[name='purchase_qty[]']").map(function(){return $(this).val();}).get();
        //     var net_amt_array = $("input[name='net_amt[]']").map(function(){return $(this).val();}).get();
        //     var purchase_price_array = $("input[name='purchase_price[]']").map(function(){return $(this).val();}).get();
        //     $.each(product_qty_array, function( index, value ) {
        //         alert(net_amt_array[index]/value);
        //             if(value != "" || net_amt_array[index] != ""){

        //             }else{
        //                 alert(net_amt_array[index]/value);
        //                 var classes = '.purchase_price'+index;
        //                $(classes).val(net_amt_array[index]/value); 
        //                $("input[name='purchase_price["+index+"]']").map(function(){return $(this).val(net_amt_array[index]/value);})
        //             }
                    
        //     });
        //     if($('#purchase_qty').val() == ''){
        //         $('#order_amount').val('');
        //     }
        //     if($('#purchase_qty').val() != '' && $('#purchase_price').val() !=''){
        //         $('#order_amount').val($('#purchase_qty').val()*$('#purchase_price').val());
        //     }
        // }); 
        // $('#purchase_price').keyup(function(){
        //     if($('#purchase_price').val() == ''){
        //         $('#order_amount').val('');
        //     }
        //     if($('#purchase_qty').val() != '' && $('#purchase_price').val() !=''){
        //         $('#order_amount').val($('#purchase_qty').val()*$('#purchase_price').val());
        //     }
        // });  
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
        <form action="{{ route('purchase.update',$Product_Data[0]->stock_order_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h3 class="card-title">Add Product</h3>
            </div>
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-6">   
                        <div class="form-group">
                            <label>Enter Invoice No:</label>
                                <input type="text" name="invoice_no" placeholder="Enter Invoice Number" class="form-control datetimepicker-input" value="{{ $Product_Data[0]->invoice_no }}" >
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Select Product Source</label>
                            <select class="form-control select2" id="edit_role" name="product_source_id"  required="">
                                <option value="" >Select Product Source</option>
                                <?php 
                                foreach ($ProductSource_list as $key => $value) {
                                    if ($Product_Data[0]->product_source_id == $value->id) {
                                        echo "<option value='".$value->id."' selected >".$value->name.'('.$value->contact_no.')'."</option>";
                                    } else {
                                        echo "<option value='".$value->id."'>".$value->name.'('.$value->contact_no.')'."</option>";
                                    }
                                 } ?>
                            </select>
                        </div>
                    </div>
                    
                   
                </div>
                <section id="product_html">
                    <?php
                    foreach($Product_Data as $keys => $values){
                        echo'
                        <input type="hidden" name="img[]" value="'.$values->img.'">
                        <input type="hidden" name="id[]" value="'.$values->id.'"><div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Name :</label>
                            <input type="text" class="form-control" name="name[]" id="exampleInputEmail1" readonly="" value="'.$values->name.'">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">purchase Qty</label>
                            <input type="number" class="form-control " name="purchase_qty[]" id="purchase_qty'.$keys.'"  placeholder="Enter purchase Qty" value="'.$values->purchase_qty.'" required="">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Net Amount</label>
                            <input type="number" min=0 step=0.001 class="form-control" name="net_amt[]" id="net_amt'.$keys.'" placeholder="Enter Net Amount" value="'.$values->order_amount.'" required="">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Purchase Price</label>
                            <input type="text" min=0 step=0.001 class="form-control" name="purchase_price[]" id="purchase_price'.$keys.'" placeholder="Purchase Price " value="'.$values->purchase_price.'" required="" readonly>
                        </div>
                    </div>
                     <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Bulk Sale Price</label>
                            <input type="number" min=0 step=0.001 class="form-control" name="bulk_sale_price[]" id="exampleInputEmail1" placeholder="Enter Bulk Sale Price" value="'.$values->bulk_sale_price.'" required="">
                        </div>
                    </div>
                     <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Sale Price</label>
                            <input type="number" min=0 step=0.001 class="form-control" name="sale_price[]" id="exampleInputEmail1" placeholder="Enter Sale Price" value="'.$values->sale_price.'" required="">
                        </div>
                    </div>
                </div>';
                    
                    }
                    ?>
                            
                </section>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Calculate Purchase And Order Amount</label>
                            <input type="button" class="form-control btn btn-success"  id="cal_order_amount" value="Calculate Amount" placeholder="Calculate Purchase And Order Amount" required="">
                        </div>
                    </div>
                    <div class="col-md-4">
                         <div class="form-group">
                            <label for="exampleInputEmail1">Order Amount</label>
                            <input type="number" class="form-control" name="order_amount" id="order_amount" placeholder="Order Amount" readonly="">
                        </div>
                    </div>
                    <div class="col-md-2">   
                        <div class="form-group">
                            <label for="exampleInputEmail1">Enter Transport Expense</label>
                            <input type="number" class="form-control" name="transport_expence" id="exampleInputEmail1" placeholder="Enter Transport Expense" value="{{ $Product_Data[0]->transport_expence }}" required="">
                        </div>
                    </div>
                    <div class="col-md-2">
                         <div class="form-group">
                            <label>Enter Order Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="date" name="order_date" value="{{ $Product_Data[0]->order_date }}" class="form-control datetimepicker-input" data-target="#reservationdate">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="status" value="{{ $Product_Data[0]->status }}">
                    
                </div>
            </div>
              <!-- /.card-body -->
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection
