@extends('layouts1.main')
@section('title', 'Distributor Report Details')
@section('section_page', 'Distributor Report Details')
@section('css')
<!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/daterangepicker/daterangepicker.css') }}">
<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- InputMask -->
<script src="{{ asset('public/adminlte/plugins/moment/moment.min.js') }}"></script>
<!-- <script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script> -->
<!-- date-range-picker -->
<script src="{{ asset('public/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
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
          getData(selectedStartDate,selectedEndDate);
        });

        $("#example1").DataTable({
          "responsive": true,
          "autoWidth": false,
          "order": [[ 0, "desc" ]],
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
         getData('all','all');
 
    });
    function getData(selectedStartDate,selectedEndDate)
    {
        OrderDataTable = $('#OrderDataTable').DataTable({
            processing: true,
            responsive: true,
            scrollY:true,
            bDestroy: true,
            order: [[ 0, "desc" ]],
            oLanguage: {
              sProcessing: "<i class='fa fa-spin fa-refresh'> </i> Loading"
            },
            ajax: {
              "url": "{{ route('product.data') }}",
              "type": "POST",
              "data": {StartDate:selectedStartDate,EndDate:selectedEndDate,id:'{{ $id }}'}
            },
            columns: [
            // { data: 'sr_no', name: 'Id' },
            { data: 'stock_order_id', name: 'Order No' },
            { data: 'invoice_no', name: 'Invoice No' },
            { data: 'total_order_amt', name: 'Total Order Amt' },
            { data: 'transport_expence', name: 'Transport Expence' },
            // { data: 'sale_price', name: 'Sale Price' },
            { data: 'order_date', name: 'Order Date' },
            // { data: 'status', name: 'Status' },
            { data: 'action', name: 'Action',width: '15%'}
            ]
        });
    }
    function Delete(id){
        if (confirm('Are you sure  want to delete?')) {
            window.location = 'purchase-delete?id='+id;
            return true;
        } else {
            return false;
        }
    }

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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                    <div class="row">
        <div class="col-md-2">
            <div class="form-group ">
                <div class="input-group">
                  <button type="button" class="btn btn-default float-right" id="daterange-btn">
                    <i class="far fa-calendar-alt"></i> Select date
                    <i class="fas fa-caret-down"></i>
                    <div id="reportrange">
                    <span>All</span>
                  </div>
                  </button>
                </div>
            </div>
        </div>
        <div class="col-10">
            
        </div>
    </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="OrderDataTable" class="table table-bordered table-hover" width="100%">
                    <thead>
                    <tr>
                        <!-- <th>Name</th> -->
                        <th>Order No</th>
                        <th>Invoice No</th>
                        <th>Total Order Amt</th>
                        <th>Transport Expence</th>
                        <th>Order Date</th>
                        <!-- <th>Status</th> -->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
@endsection
