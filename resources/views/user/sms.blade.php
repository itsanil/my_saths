@extends('layouts1.main')
@section('title', 'SMS Logs')
@section('section_page', 'SMS Logs')
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
    var text_max = 160;
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
          aLengthMenu: [
              [25, 50, 100, 200, -1],
              [25, 50, 100, 200, "All"]
          ],
          iDisplayLength: 200,
        });

         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        smsDataTable = $('#smsDataTable').DataTable({
            processing: true,
            responsive: true,
            scrollY:true,
            bDestroy: true,
            aLengthMenu: [
              [25, 50, 100, 200, -1],
              [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: 200,
            order: [[ 0, "desc" ]],
            oLanguage: {
              sProcessing: "<i class='fa fa-spin fa-refresh'> </i> Loading"
            },
            // serverSide: true,
            ajax: {
              "url": "{{ route('sms.data') }}",
              "type": "POST",
              "data": {StartDate:'all',EndDate:'all'}
            },
            columns: [
            // { data: 'sr_no', name: 'Id' },
            { data: 'id', name: 'Id' },
            { data: 'whatsapp_no', name: 'Whatsapp No' },
            { data: 'date', name: 'Date' },
            { data: 'msg', name: 'Message'}
            ]
        });
    });


    $('#user').on('change',function(){
      if ($('#user').val() == 'Excel') {
          var html = '<label for="username">Upload Excel</label><input type="file" class="form-control"  name="excel" required="">';
      } else {
          var html = '';
      }
      $('#excel_html').html(html);
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
      smsDataTable = $('#smsDataTable').DataTable({
            pageLength: 50,
            processing: true,
            responsive: true,
            scrollY:true,
            bDestroy: true,
            order: [[ 0, "desc" ]],
            oLanguage: {
              sProcessing: "<i class='fa fa-spin fa-refresh'> </i> Loading"
            },
            // serverSide: true,
            ajax: {
              "url": "{{ route('sms.data') }}",
              "type": "POST",
              "data": {StartDate:selectedStartDate,EndDate:selectedEndDate}
            },
            columns: [
            // { data: 'sr_no', name: 'Id' },
            { data: 'id', name: 'Id' },
            { data: 'whatsapp_no', name: 'Whatsapp No' },
            { data: 'date', name: 'Date' },
            { data: 'msg', name: 'Message'}
            ]
        });
    });

  })

  
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
                   <!-- <a href="" class="btn btn-success float-right" style="margin: 0px 10px;" title="">Excel SMS</a> -->
                    <button type="button" data-toggle="modal" data-target="#addNew-modal"  class="btn btn-success float-right">
                      Bulk SMS
                    </button> 
              </div>
           
        </div>
            <div class="card-body">
                <div class="box-body">
                    <table id="smsDataTable" class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Whatsapp No</th>
                            <th>Date</th>
                            <th>Message</th>
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
<div id="addNew-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                                <b>Post New Message</b>
                </div>
                <form class="pl-3 pr-3" action="{{ route('sms.store') }}" method="POST" id="sms_form" enctype="multipart/form-data">
                                @csrf
                    <div class="form-group">
                        <label for="username">Send To</label>
                        <select name="user" id="user"  class="form-control" required="">
                            <option value="all">All Customer</option>
                            <option value="test">Test</option>
                            <option value="Excel">Excel</option>
                        </select>
                    </div>
                    <div class="form-group" id="excel_html">
                                   
                    </div>
                    <textarea class="form-control" id="text" name="text" 
                     maxlength="160" placeholder="Type in your message" rows="5"></textarea>
                    <span class="pull-right label label-default" id="count_message" required=""></span>
                    <br>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button class="btn btn-info" id="sms_button" type="submit">Post New Message</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
