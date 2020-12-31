@extends('layouts1.main')
@if(Auth::user()->hasRole('customer'))
@section('title', 'My Order')
@section('section_page', 'My Order')
@else
@section('title', 'Order-List')
@section('section_page', 'Order-List')
@endif
@section('css')


<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')

@endsection
@section('content')
  
    @if($order_list->count() == 0)
       <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="card-title">
                              No Order Created
                            </h3>
                          </div>
                        </div>
                      </div>
    @endif
        @foreach ($order_list as $key => $order)
            <div class="card card-primary card-outline collapsed-card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3 class="card-title">
                                @if($order->price_type == 'Sale Price')
                                    <b>B2C Sells</b>
                                @else
                                    <b>B2B Sells</b>
                                @endif
                            </h3>
                        </div>
                        <div class="col">
                            <h3 class="card-title">
                              <b>Order Id:</b><br/>{{ $order->id }}
                            </h3>
                        </div>
                        <div class="col">
                            <h3 class="card-title">
                              <b>Order Date:</b><br/>{{ $order->order_date }}
                            </h3>
                        </div>
                        <div class="col">
                            <h3 class="card-title">
                              <b>Order Amount:</b><br/>{{ $order->order_amt }}
                            </h3>
                        </div>
                        <div class="col">
                            <h3 class="card-title">
                                <b>Order Status:</b><br/>
                                    @if($order->delivery_status == 1 &&  $order->payment_status == 1)
                                        <span class="badge badge-success">Complete</span>
                                    @elseif($order->delivery_status == 1 &&  $order->payment_status == 0)
                                        <span class="badge badge-danger">Payment Pending</span>
                                    @elseif($order->delivery_status == 0 &&  $order->payment_status == 1)
                                        <span class="badge badge-danger">Delivery Pending</span>
                                    @elseif ($order->order_status == 'cancel' )
                                        <span class="badge badge-danger">cancel</span>
                                    @elseif ($order->order_status == 'approved' )
                                        <span class="badge badge-success">approved</span>
                                    @else
                                        <span class="badge badge-danger">Pending</span>
                                    @endif
                            </h3>
                        </div>
                        <div class="col" style="text-align: right;" >
                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                              </button>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="card-body" style="display: none;">
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
                      foreach ($product_list[$key] as $keys => $product) {
                        // echo "<pre>"; print_r($product); echo "</pre>"; die('end of code');
                            echo '<tr>
                                <td>'.($keys + 1).'</td>
                                <td>'.$product['name'].'</td>
                                <td>'.$product['per_price'].'</td>
                                <td>'.$product['order_qty'].'</td>
                                <td>'.$product['sub_price'].'</td>
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
                <div class="col-6">
                  <p class="lead">Payment Methods:
                    <b>{{ $order->PaymentType->name }}</b>
                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <div class="table-responsive">
                    <table class="table">
                      <tbody><tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>{{ $order->order_amt }} Rs/-</td>
                      </tr>
                    </tbody></table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
                </div>
            </div>
        @endforeach
        @if(Auth::user()->hasRole('customer'))
        
        @else
              <div class="card-footer">
                <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Back</a>
              </div>
        @endif
        
@endsection
