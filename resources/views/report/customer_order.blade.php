@extends('layouts1.main')
@section('title', 'Order Search')
@section('section_page')
Order Search For {{ $product_name }}
@endsection
@section('css')
<style>
    textarea {
    resize: none;
}

#count_message {
  background-color: smoke;
  margin-top: -20px;
  margin-right: 5px;
}
    
</style>
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
<!-- validate -->
<script src="{{ asset('public/adminlte/plugins/jquery-validation/jquery.validate.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('public/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
  $(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    datatable('all','all');
    //Date range as a button189
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

      datatable(selectedStartDate,selectedEndDate);
      
    });


  })



  function datatable(selectedStartDate,selectedEndDate){
    brandSalesDataTable = $('#OrderSearchDataTable').DataTable({
      aLengthMenu: [
              [25, 50, 100, 200, -1],
              [25, 50, 100, 200, "All"]
          ],
          iDisplayLength: 200,
            processing: true,
            responsive: true,
            scrollY:true,
            bDestroy: true,
            order: [[ 2, "desc" ]],
            oLanguage: {
              sProcessing: "<i class='fa fa-spin fa-refresh'> </i> Loading"
            },
            // serverSide: true,
            ajax: {
              "url": "{{ route('order-search.data') }}",
              "type": "POST",
              "data": {StartDate:selectedStartDate,EndDate:selectedEndDate,name:'{{ $product_name }}'}
            },
            // alert(data);
            columns: [
            // { data: 'sr_no', name: 'Id' },
            { data: 'customer_name', name: 'Customer' },
            { data: 'customer_mobile', name: 'Mobile' },
            { data: 'order_no', name: 'Order No' },
            { data: 'order_qty', name: 'Sell Qty' },
            { data: 'sub_price', name: 'Sell Amt' },
            { data: 'order_date', name: 'Order Date'}
            ]
        });
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
            <div class="card-body">
                <div class="box-body">
                    <table id="OrderSearchDataTable" class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Order No</th>
                            <th>Sell Qty</th>
                            <th>Sell Amt</th>
                            <th>Order Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end card body-->
</div>
@endsection
