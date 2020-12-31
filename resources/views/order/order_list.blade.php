
@extends('layouts1.main')
@section('title', 'Order')
@section('section_page', 'Order')
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
            oLanguage: {
              sProcessing: "<i class='fa fa-spin fa-refresh'> </i> Loading"
            },
            serverSide: true,
            ajax: {
              "url": "{{ route('order.data') }}",
              "type": "POST",
              "data": {StartDate:selectedStartDate,EndDate:selectedEndDate,id:'<?php echo $_GET['id']; ?>'}
            },
            columns: [
            { data: 'id', name: 'Order Id' },
            { data: 'name', name: 'Customer Name' },
            { data: 'whatsapp_no', name: 'Whatsapp Number' },
            { data: 'order_amt', name: 'Order Amount' },
            // { data: 'delivery_status', name: 'Delivery Status' },
            // { data: 'sale_price', name: 'Payment Status' },
            // { data: 'order_date', name: 'Order Date' },
            { data: 'status', name: 'Status' },
            { data: 'action', name: 'Action', width: '15%'}
            ]
            ,ordering: false,
        });
    }
    function Delete(id){
        if (confirm('Are you sure  want to delete?')) {
            window.location = 'order-delete?id='+id;
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
        <div class="col-md-10">
            <a href="{{ route('order.create') }}"  class="btn btn-success float-right">
            Add Order
            </a>
        </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
              <div class="box-body">
                  <table id="OrderDataTable" class="table table-bordered table-hover" width="100%">
                      <thead>
                      <tr>
                          <th>Order Id</th>
                          <th>Customer Name</th>
                          <th>Whatsapp Number</th>
                          <th>Order Amount</th>
                          <th>Status</th>
                          <!-- <th>Payment Status</th> -->
                          <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
              </div>
          </div> <!-- end card body-->
        </div>
      </div>
    </div>
@endsection
