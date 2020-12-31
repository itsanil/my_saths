@extends('layouts1.main')
@section('title', 'Area')
@section('section_page', 'Area')
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
    });
    function Edit(id,name){
        // alert(name);
        // var edit_url = 'area/'+id+'/edit';
          $("#edit_id").val(id);
          $("#edit_name").val(name);
           // $('#editform').attr('action', edit_url);
          $("#edit-modal").modal("show");
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
            Add Area
            </button>
        </div>
    </div>
<div class="row">
    <div class="card-body">
        
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($area_list as $key => $value) {
                    
                    echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>".$value->name."</td>";
                        $com = "'";
                    $string = $com.trim($value->id).$com.','.$com.$value->name.$com;
                        echo '<td>
                        <a class="btn btn-info btn-sm"  style="color:#ffff;" onclick="Edit('.$string.')">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                    </td>';
                    echo "</tr>";
                }
                // <button type="button" onclick="Delete('.$value->id.')" class="btn btn-danger"><i class="mdi mdi-window-close"></i> </button>
                //         </div>
             ?>
            </tbody>
        </table>
    </div> <!-- end card body-->
</div>
<div id="addNew-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                                <b>Add Area</b>
                </div>
                <form class="pl-3 pr-3" action="{{ route('area.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    <div class="form-group">
                        <label for="username">Name</label>
                        <input class="form-control" type="name" id="name" name="name" required="" placeholder="Enter Area Name">
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
            <form class="pl-3 pr-3" id="editform" action="{{ url('/update-area') }}" method="POST" enctype="multipart/form-data">
                                @csrf
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                        <span id="edit_photo"></span>
                </div>

                
                    <input class="form-control" type="hidden" id="edit_id" name="id" >
                    <div class="form-group">
                        <label for="password">Area Name</label>
                        <input type="text" class="form-control" name="name" id="edit_name">
                    </div>

            </div>
            <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
