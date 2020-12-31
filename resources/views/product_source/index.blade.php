@extends('layouts1.main')
@section('title', 'Distributer')
@section('section_page', 'Distributer')
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
    ProductSourceDatatable = $('#ProductSourceDatatable').DataTable({
        processing: true,
        responsive: true,
        scrollY:true,
        bDestroy: true,
        oLanguage: {
          sProcessing: "<i class='fa fa-spin fa-refresh'> </i> Loading"
        },
        ajax: {
          "url": "{{ route('Product-source.data') }}",
          "type": "POST",
        },
        columns: [
        // { data: 'sr_no', name: 'Id' },
        { data: 'name', name: 'Name' },
        { data: 'contact_no', name: 'Contact No' },
        { data: 'action', name: 'Action',width: '30%'}
        ]
      });
    });
    
    function Edit(id,name,contact_no,description){
        // alert(name);
        // var edit_url = 'area/'+id+'/edit';
          $("#edit_id").val(id);
          $("#edit_name").val(name);
          $("#edit_contact_no").val(contact_no);
          $("#edit_description").val(description);
          $("#edit-modal").modal("show");
    }

    function Delete(id){
        if (confirm('Are you sure  want to delete?')) {
            window.location = 'distributer-delete?id='+id;
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
            <button type="button" data-toggle="modal" data-target="#addNew-modal"  class="btn btn-success float-right">
            Add Source
            </button>
        </div>
    </div>
    <div class="row">
    <div class="card-body">
        
        <div class="box-body" style="width:100%;">
            <table id="ProductSourceDatatable" class="table table-bordered table-hover" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact No</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div> <!-- end card body-->
</div>
<div id="addNew-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                                <b>Add Source</b>
                </div>
                <form class="pl-3 pr-3" action="{{ route('distributer.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    <div class="form-group">
                        <label for="username">Name</label>
                        <input class="form-control" type="name" id="name" name="name" required="" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="username">Contact No</label>
                        <input class="form-control" maxlength="10" type="number" id="name" name="contact_no" required="" placeholder="Enter Contact No">
                    </div>
                    <div class="form-group">
                        <label for="username">Source Description</label>
                        <textarea name="description" class="form-control" placeholder="Enter Source Description(Optional)"></textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                        <span id="edit_photo"></span>
                </div>

                <form class="pl-3 pr-3" id="editform" action="{{ url('/update-distributer') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    <input class="form-control" type="hidden" id="edit_id" name="id" >
                    <div class="form-group">
                        <label for="username">Name</label>
                        <input class="form-control" type="name" id="edit_name" name="name" required="" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="username">Contact No</label>
                        <input class="form-control" maxlength="10" type="number" id="edit_contact_no" name="contact_no" required="" placeholder="Enter Contact No">
                    </div>
                    <div class="form-group">
                        <label for="username">Source Description</label>
                        <textarea name="description" class="form-control" id="edit_description" placeholder="Enter Source Description(Optional)"></textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
