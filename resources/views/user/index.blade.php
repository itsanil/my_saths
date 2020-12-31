@extends('layouts1.main')
@section('title', 'Role')
@section('section_page', 'Role')
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
          aLengthMenu: [
              [25, 50, 100, 200, -1],
              [25, 50, 100, 200, "All"]
          ],
          iDisplayLength: 200,
        });
    });
    function Edit(id,role_id){
        // alert(role_id);
          $("#edit_id").val(id);
          $("#edit_role").val(role_id);
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
    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <!--<th>Email</th>-->
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($User as $key => $value) {
                            if ($value->roles[0]['display_name'] == 'Online') {
                                $pdfView = '<a class="btn btn-primary btn-sm" style="color:#ffff;" href="'.route('user.show',$value->id).'">
                                      <i class="fas fa-folder">
                                      </i>
                                      View Pdf
                                  </a>
                                  ';
                            } else {
                                $pdfView = '';
                            }
                            
                            echo "<tr>";
                                echo "<td>".($key+1)."</td>";
                                echo "<td>".$value->name."</td>";
                                echo "<td>".$value->mobile."</td>";
                                // echo "<td>".$value->email."</td>";
                                echo "<td>".$value->roles[0]['display_name']."</td>";
                                $com = "'";
                            $string = $com.trim($value->id).$com.','.$com.$value->roles['0']['id'].$com;
                                echo '<td>'.$pdfView.'
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
                </div>
            </div>
        </div>
    </div> <!-- end card body-->
</div>
<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                        <span id="edit_photo"></span>
                </div>

                <form class="pl-3 pr-3" action="{{ route('role.edit') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    <input class="form-control" type="hidden" id="edit_id" name="id" >
                    <div class="form-group">
                        <label for="password">Change User Type</label>
                        <select class="custom-select mb-3" id="edit_role" name="role">
                        <option value="" >Select</option>
                        <?php 
                        foreach ($Role as $key => $value) {
                             echo "<option value='".$value->id."'>".$value->name."</option>";
                         } ?>
                    </select>
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
