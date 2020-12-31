@extends('layouts1.main')
@section('title', 'Order Details')
@section('section_page', 'Order Details')
@section('css')

@endsection
@section('js')

@endsection
@section('content')
                 
<section class="content">
  <div class="container-fluid">
    <div class="row">
              <div class="invoice p-3 mb-3" style="width: 100%;">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <!-- <i class="fas fa-globe"></i> AdminLTE, Inc. -->
                    <small class="float-right">Order Date: {{ $Order_data->order_date }}</small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                  To
                  <address>
                    <strong>{{ $Order_data->customer->name }}</strong><br>
                    Whatsapp No: {{ $Order_data->customer->whatsapp_no }}<br>
                    city: {{ $Order_data->customer->city }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-6 invoice-col" style="text-align: right;">
                  <!-- <b>Invoice #007612</b><br>
                  <br>
                  <b>Order ID:</b> 4F3S8J<br> -->
                  <br><br>
                   <?php 

                    if ($Order_data->order_status == 'approved') {
                      echo '<b>Order Status :</b> <span class="badge badge-success">approved</span><br>';
                    } else {
                        echo '<b>Order Status :</b> <span class="badge badge-danger">'.$Order_data->order_status.'</span><br>';
                    }
                    if ($Order_data->delivery_status == 1) {
                      echo '<b>Delivery :</b> <span class="badge badge-success">Complete</span><br>';
                    } else {
                        echo '<b>Delivery :</b> <span class="badge badge-danger">In-Complete</span><br>';
                    }
                    if ($Order_data->payment_status == 1) {
                      echo '<b>Payment:</b> <span class="badge badge-success">Complete</span><br>';
                    } else {
                        echo '<b>Payment :</b> <span class="badge badge-danger">In-Complete</span><br>';
                    }

                  ?>
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
                    </tr>
                    </thead>
                    <tbody>
                      <?php 
                      foreach ($product['name'] as $key => $value) {
                        echo '<tr>
                                <td>'.($key + 1).'</td>
                                <td>'.$value.'</td>
                                <td>'.$product['price'][$key].'</td>
                                <td>'.$product['order_qty'][$key].'</td>
                                <td>'.$product['sub_price'][$key].'</td>
                              </tr>';
                      }
                       ?>
                      
                      
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

                <!-- /.col -->
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <td><label>Payment Methods:&nbsp;</label>{{ $Order_data->PaymentType->name }}</td>
                          <td><label>Discount:&nbsp;</label>{{ $Order_data->discount_amount }} Rs/-</td>
                          <td><label>Delivery Charge:&nbsp;</label>{{ $Order_data->delivery_amount }} Rs/-</td>
                          <td><label>Subtotal:&nbsp;</label>{{ $Order_data->order_amt }} Rs/-</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="card-footer">
                <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Back</a>
             </div>
              <!-- this row will not appear when printing -->
            </div>
        <!-- /.nav-tabs-custom -->
  </div><!-- /.container-fluid -->
</section>
@endsection