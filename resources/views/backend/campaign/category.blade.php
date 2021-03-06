@extends('backend.main')
@section('title', 'Campaign Create')
@section('section_page', 'Campaign Create')
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
    function Edit(id,name,status){
        // alert(name);
        // var edit_url = 'campaign-category-update?id=/'+id;
          $("#edit_title").val(name);
          $("#edit_id").val(id);
          $("#edit_status").val(status);
          // $("#editform").attr('action',edit_url);
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
            Add Campaign Category
            </button>
        </div>
    </div>
<div class="row">
    <div class="card-body">
        
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($data as $key => $value) {
                            
                            echo "<tr>";
                                echo "<td>".($key+1)."</td>";
                                echo "<td>".$value->title."</td>";
                                echo "<td>".$value->status."</td>";
                                $com = "'";
                            $string = $com.trim($value->id).$com.','.$com.trim($value->title).$com.','.$com.$value->status.$com;
                                echo '<td>
                                <a class="btn btn-info btn-sm" target="_blank"  style="color:#ffff;" href="'.url('storage/'.$value->photo).'">
                                      <i class="fas fa-eye">
                                      </i>
                                      view
                                  </a>
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
                                <b>Add Campaign Category</b>
                </div>
                <form class="pl-3 pr-3" action="{{ route('campaign-category.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    <div class="form-group">
                        <label for="username">Title</label>
                        <input class="form-control" type="name" id="title" name="title" required="" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="username">Photo</label>
                        <input class="form-control" type="file" id="name" name="photo" required="" >
                    </div>
                    <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status" class="form-control" required="">
                            <option value="Active" >Active</option>
                            <option value="In-Active" >In-Active</option>
                        </select>
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
            <form class="pl-3 pr-3" id="editform" action="{{ url('/campaign-category-update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="edit_id" name="id">
            <div class="modal-body">
                <div class="form-group">
                        <label for="username">Title</label>
                        <input class="form-control" type="name" id="edit_title" name="title" required="" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="username">Photo</label>
                    <input class="form-control" type="file" id="name" name="photo" >
                </div>
                <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status" id="edit_status" class="form-control" required="">
                            <option value="Active" >Active</option>
                            <option value="In-Active" >In-Active</option>
                        </select>
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
