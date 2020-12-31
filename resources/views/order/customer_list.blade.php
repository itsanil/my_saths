@extends('layouts1.main')
@section('title', 'Customer')
@section('section_page', 'Customer')
@section('css')

<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- DataTables -->
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
    $(function () {
        $("#example1").DataTable({
          "responsive": true,
          "autoWidth": false,
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        CustomerDataTable = $('#CustomerDataTable').DataTable({
            processing: true,
            responsive: true,
            scrollY:true,
            bDestroy: true,
            oLanguage: {
              sProcessing: "<i class='fa fa-spin fa-refresh'> </i> Loading"
            },
            serverSide: true,
            ajax: {
              "url": "{{ route('customer.Customerdata') }}",
              "type": "POST",
            },
            columns: [
            // { data: 'sr_no', name: 'Id' },
            { data: 'name', name: 'Name' },
            { data: 'whatsapp_no', name: 'Whatsapp Number' },
            { data: 'action', name: 'Action',width: '30%'}
            ]
            ,ordering: false,
        });
    });
    function Delete(id){
        if (confirm('Are you sure  want to delete?')) {
            window.location = 'customer-delete?id='+id;
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
            <a href="{{ route('order.create') }}"  class="btn btn-success float-right">
            Add Order
            </a>
        </div>
    </div>
<div class="row">
    <div class="card-body">
        
        <div class="box-body" style="width:100%;">
            <table id="CustomerDataTable" class="table table-bordered table-hover" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Whatsapp Number</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div> <!-- end card body-->
</div>
@endsection
