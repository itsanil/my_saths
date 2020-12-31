@extends('layouts1.main')
@section('title', 'Purchase Order Details')
@section('section_page', 'Purchase Order Details')
@section('css')


<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- DataTables -->

@endsection
@section('content')
      <!-- Default box -->
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
              <div class="row">
                <div class="col-12 col-sm-2">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Order No</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $product_Data[0]->stock_order_id }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-2">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Invoice No</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $product_Data[0]->invoice_no }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-2">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Order Date</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $product_Data[0]->order_date }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-2">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Total amount spent</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $product_Data[0]->total_order_amt }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-2">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Transport Expence</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $product_Data[0]->transport_expence }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-2">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Product Source</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $product_Data[0]->ProductSource->name }}(<a href="tel:91{{ $product_Data[0]->ProductSource->contact_no }}">{{ $product_Data[0]->ProductSource->contact_no }}.</a>)<span>
                    </span></span></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  
                  @foreach($product_Data as $key => $value)
                    <div class="post clearfix">
                      <div class="row">
                        <div class="col-md-4">
                          <!-- <div class="user-block"> -->
                            <img src="{{ url('storage/') }}/{{ $value->img }}" style='width: 300px;height: 200px;'>
                            <!-- <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image"> -->
                            <!-- <span class="username">
                              <a href="#">{{ $value->name }}</a>
                            </span> -->
                          <!-- </div> -->
                        </div>
                        <div class="col-md-8">
                          <h4>{{ $value->name }}</h4>
                          <ul style="    text-transform: capitalize;">
                            <li><b>Purchase Qty</b>:{{ $value->purchase_qty }}</li>
                            <li><b>Net Amount</b>:{{ $value->order_amount }}</li>
                            <li><b>purchase price</b>:{{ $value->purchase_price }}</li>
                            <li><b>bulk sale price</b>:{{ $value->bulk_sale_price }}</li>
                            <li><b>sale price</b>:{{ $value->sale_price }}</li>
                        </ul>
                        </div>
                        
                      </div>
                      
                      <!-- /.user-block -->
                      
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

  @endsection