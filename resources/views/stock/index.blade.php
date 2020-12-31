@extends('layouts1.main')
@section('title', 'Inventory')
@section('section_page', 'Inventory')
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
          "orderable": false,
          "order": [[ 2, "asc" ]],
          aLengthMenu: [
              [25, 50, 100, 200, -1],
              [25, 50, 100, 200, "All"]
          ],
          iDisplayLength: 200
          // "pageLength": 200,
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
        ManageEventTable = $('#ManageEventTable').DataTable( {
        processing: true,
        responsive: true,
        scrollY:true,
        bDestroy: true,
        oLanguage: {
          sProcessing: "<i class='fa fa-spin fa-refresh'> </i> Loading"
        },
        ajax: {
          "url": "{{ route('stock-report.data') }}",
          "type": "POST",
          "data": {StartDate:selectedStartDate,EndDate:selectedEndDate}
        },
        columns: [
        // { data: 'sr_no', name: 'Id' },
        { data: 'name', name: 'Product Name' },
        { data: 'purchase_quantity', name: 'Purchase Qty' },
        // { data: 'purchase_price', name: 'Purchase Price' },
        // { data: 'transport_price', name: 'Transport Price' },
        // { data: 'total_purchase_amt', name: 'Total Purchase Amt' },
        { data: 'available_quantity', name: 'Available Qty' },
        // { data: 'status', name: 'status', orderable: false, searchable: false,width: '10%'}
        ]
      });
    }

        </script>
@endsection
@section('content')
        <div class="row ">
            <div class="col-md-10">
                
            </div>
            <div class="col-md-2">
            <div class="form-group ">
                <div class="input-group">
                  <button type="button" class="btn btn-default float-right" id="daterange-btn">
                    <i class="far fa-calendar-alt"></i>Select Date 
                    <i class="fas fa-caret-down"></i>
                    <div id="reportrange">
                    <span>All</span>
                  </div>
                  </button>
                </div>
            </div>
        </div>
        </div>
<div class="row">

     <div class="box-body" style="width:100%;">
             <!--<table id="ManageEventTable" class="table table-bordered table-hover" width="100%"> -->
            <table id="example1" class="table table-bordered table-hover" width="100%">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Purchase Qty</th>
                    <th>Available Qty</th>
                </tr>
                 </thead>
               
               
                <tbody>
                     <?php 
                foreach ($stock_list as $key => $value) {
                  if ($value['available_quantity'] == 0) {
                    echo "<tr style='background-color:red;color:#ffff;'>";
                    echo "<td>".$value['name']."</td>";
                    echo "<td>".$value['purchase_quantity']."</td>";
                    echo "<td>".$value['available_quantity']."</td>";
                    echo "</tr>";
                  }else{
                    echo "<tr>";
                    echo "<td>".$value['name']."</td>";
                    echo "<td>".$value['purchase_quantity']."</td>";
                    echo "<td>".$value['available_quantity']."</td>";
                    echo "</tr>";
                  }
                }
                ?>
                </tbody>
              </table>
          </div>
</div>
@endsection
