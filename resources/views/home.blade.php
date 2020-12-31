@extends('layouts1.main')
@section('title', 'Home')
@section('section_page', 'Dashboard')
@section('css')
<!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/daterangepicker/daterangepicker.css') }}">
@endsection
@section('js')
<!-- InputMask -->
<script src="{{ asset('public/adminlte/plugins/moment/moment.min.js') }}"></script>
<!-- <script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script> -->
<!-- date-range-picker -->
<script src="{{ asset('public/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
  $(function () {
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'All'         :['all',moment()],
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        if (start == 'all' || start.format('MMMM D, YYYY') == 'Invalid date') {
          $('#reportrange span').html('all');
        } else {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      }
    )

    $('#daterange-btn').on('apply.daterangepicker', function(ev, picker) {
      if (picker.startDate == 'all') {
        selectedStartDate = 'all';
        selectedEndDate = picker.endDate.format('YYYY-MM-DD');
      } else {
        selectedStartDate = picker.startDate.format('YYYY-MM-DD');
        selectedEndDate = picker.endDate.format('YYYY-MM-DD');
      }
      // alert(selectedStartDate);
      // alert(selectedEndDate);
      getRevenueData(selectedStartDate,selectedEndDate);
    });

  })

  function getRevenueData(selectedStartDate,selectedEndDate){
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '{{ route("get_dashboard_data") }}',
        data: {
          'selectedStartDate': selectedStartDate,
          'selectedEndDate': selectedEndDate
        },
        success: function(response) {
          $('#Total_revenue').html(response.Total_revenue);
          $('#b2b_sells').html(response.b2b_sells);
          $('#b2c_sells').html(response.b2c_sells);
          $('#total_b2b_order').html(response.total_b2b_order);
          $('#total_b2c_order').html(response.total_b2c_order);
          $('#total_order').html(response.total_order);
          $('#total_stock_amt').html(response.total_stock_amt);
          var product_html = '';
          $.each(response.product.name, function( index, value ) {
            product_html = '\
                              <tr>\
                              <td>'+value+'</td>\
                              <td>'+response.product['b2b_sells'][index]+'</td>\
                              <td>'+response.product['b2c_sells'][index]+'</td>\
                              </tr>\
                       ';
          });
          $('#product_html').html(product_html);
        },
      });
    }
</script>
@endsection
@section('content')
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
          @if(Auth::user()->hasRole('admin'))
          <div class="info-box">
                <div class="form-group">
                <div class="input-group">
                  <button type="button" class="btn btn-default float-right" id="daterange-btn">
                    <i class="far fa-calendar-alt"></i> Select Date
                    <i class="fas fa-caret-down"></i>
                    <div id="reportrange">
                    <span>All</span>
                  </div>
                  </button>

                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h5 ><span id="total_stock_amt">{{ $total_stock_amt }}</span> Rs/-</h5>

                  <p>stock cost</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Total Order: <span id="total_order">{{ $total_order }}</span></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h5 id=""><span id="b2c_sells">{{ $b2c_sells }}</span> Rs/-</h5>

                  <p>B2C Sales</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Total B2C Order: <span id="total_b2c_order">{{ $total_b2c_order }}</a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h5><span id="b2b_sells">{{ $b2b_sells }}</span> Rs/-</h5>

                  <p>B2B Sales</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Total B2B Order: <span id="total_b2b_order">{{ $total_b2b_order }}</span></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h5><span id="Total_revenue">{{ $Total_revenue }}</span> Rs/-</h5>

                  <p>Total revenue</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                    <tr>
                      <th>Item</th>
                      <th>B2B Sell Qty</th>
                      <th>B2C Sell Qty</th>
                    </tr>
                    </thead>
                    <tbody id="product_html">
                      <?php 

                        
                      foreach ($product['name'] as $key => $value) {
                       echo '
                              <tr>
                              <td>'.$value.'</td>
                              <td>'.$product['b2b_sells'][$key].'</td>
                              <td>'.$product['b2c_sells'][$key].'</td>
                              </tr>
                       ';
                      }
                       ?>
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
          </div>
          @endif
        </div>
@endsection
