@extends('layouts1.main')
@section('title', 'Refund Details')
@section('section_page', 'Refund Details')
@section('css')

@endsection
@section('js')

@endsection
@section('content')
                 
<section class="content">
  <div class="container-fluid">
              <!-- title row -->
              <div class="row">
                  <h4>
                    <!-- <i class="fas fa-globe"></i> AdminLTE, Inc. -->
                    <small class="float-right">Refund Date: {{ $refund_data->refund_date }}</small>
                  </h4>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-12 invoice-col">
                  To
                  <address>
                    <strong>{{ $refund_data->customer->name }}</strong><br>
                    Whatsapp No: {{ $refund_data->customer->whatsapp_no }}<br>
                    city: {{ $refund_data->customer->city }}
                  </address>
                </div>
                <!-- /.col -->
              </div>  
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Serial #</th>
                      <th>Product</th>
                      <th>Price Per Qty</th>
                      <th>Qty</th>
                      <th>Subtotal</th>
                      <th>Refund Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php 
                        foreach (json_decode($refund_data->refund_product)->product_id as $key => $values) {
                        echo '<tr>
                                <td>'.($key + 1).'</td>
                                <td>'.json_decode($refund_data->refund_product)->product_name[$key].'</td>
                                <td>'.json_decode($refund_data->refund_product)->per_price[$key].'</td>
                                <td>'.json_decode($refund_data->refund_product)->order_qty[$key].'</td>
                                <td>'.json_decode($refund_data->refund_product)->sub_price[$key].'</td>
                                <td>'.json_decode($refund_data->refund_product)->refund_qty[$key].'</td>
                              </tr>';
                      }
                       ?>
                      
                      
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <!-- /.col -->
                <div class="col-12">
                  <div class="table-responsive">
                    <table class="table">
                      <tbody><tr>
                        <th style="width:50%">Refund Subtotal:</th>
                        <td>{{ $refund_data->refund_amount }} Rs/-</td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="card-footer">
                <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Back</a>
             </div>
              <!-- this row will not appear when printing -->
            
        <!-- /.nav-tabs-custom -->
    </div>
  </div><!-- /.container-fluid -->
</section>
@endsection