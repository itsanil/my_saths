@extends('layouts1.main')
@section('title', 'Distributor Report')
@section('section_page', 'Distributor Report')
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
    var text_max = 140;
        $('#count_message').html('0 / ' + text_max );

        $('#text').keyup(function() {
          var text_length = $('#text').val().length;
          var text_remaining = text_max - text_length;
          
          $('#count_message').html(text_length + ' / ' + text_max);
        });

    $(function () {
        $("#example1").DataTable({
          "responsive": true,
          "autoWidth": false,
          "pageLength": 50,
        });

         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         datatable('all','all');
         report('all','all');
    });

 $(document).on('click', '#sms_button', function() {
    // var isvalidate=$("#sms_form").valid();
    if($('#user').val() == '' || $('#text').val().length == 0){
        toastr.error('please enter all field');
      return false;
    }
    if (confirm("Click OK to post new sms?")){
        return true;
      }else{
        return false;
      }
    });
   //  $("#sms_button").click(function(){
      
   // });

        </script>

        <script>
  $(function () {
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
      report(selectedStartDate,selectedEndDate);
      
    });


  })

  function report(selectedStartDate,selectedEndDate){
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '{{ route("get_purchase_report_data") }}',
        data: {
          'selectedStartDate': selectedStartDate,
          'selectedEndDate': selectedEndDate
        },
        success: function(response) {
          $('#total_order').html(response.total_order+' Rs/-');
          $('#total_transport_amt').html(response.total_transport_amt+' Rs/-');
        },
      });
  }

  function datatable(selectedStartDate,selectedEndDate){
    DistributerDataTable = $('#DistributerDataTable').DataTable({
            pageLength: 25,
            processing: true,
            responsive: true,
            scrollY:true,
            bDestroy: true,
            order: [[ 1, "desc" ]],
            oLanguage: {
              sProcessing: "<i class='fa fa-spin fa-refresh'> </i> Loading"
            },
            // serverSide: true,
            ajax: {
              "url": "{{ route('get_distributor_data') }}",
              "type": "POST",
              "data": {StartDate:selectedStartDate,EndDate:selectedEndDate}
            },
            columns: [
            // { data: 'sr_no', name: 'Id' },
            // { data: 'id', name: 'Id' },
            { data: 'name', name: 'Name' },
            { data: 'purchase_amt', name: 'Order Amount' },
            { data: 'action', name: 'Action'}
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
    <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Total Purchase Amt</span>
                      <span class="info-box-number text-center text-muted mb-0" id="total_order">0.00 Rs/-<span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Total Transport Expence</span>
                      <span class="info-box-number text-center text-muted mb-0" id="total_transport_amt">0.00 Rs/-</span>
                    </div>
                  </div>
                </div>
                
              </div>
        </div>
    </div>
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
                    <table id="DistributerDataTable" class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <!-- <th>Id</th> -->
                            <th>Name</th>
                            <th>Order Amount</th>
                            <th>Action</th>
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
