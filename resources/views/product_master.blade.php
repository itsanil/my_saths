@extends('layouts1.main')
@section('title', 'Products')
@section('section_page', 'Products')
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
            aLengthMenu: [
              [25, 50, 100, 200, -1],
              [25, 50, 100, 200, "All"]
          ],
          iDisplayLength: 200,
          "responsive": true,
          "autoWidth": false,
        });
    });
    function Edit(id,status,name,mrp,brand_id,){
        // alert(name);
        // var edit_url = 'area/'+id+'/edit';
          $("#edit_id").val(id);
          $("#edit_name").val(name);
          $("#mrp").val(mrp);
          $("#brand_id").val(brand_id);
          $("#status").val(status);
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
            Add Product
            </button>
        </div>
    </div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>MRP</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($product_list as $key => $value) {
                            
                            echo "<tr>";
                                echo "<td>".($key+1)."</td>";
                                echo "<td>".$value->name."</td>";
                                echo "<td>".$value->mrp."</td>";
                                echo "<td>".$value->status."</td>";
                                $com = "'";
                            $string = $com.trim($value->id).$com.','.$com.trim($value->status).$com.','.$com.$value->name.$com.','.$com.$value->mrp.$com.','.$com.$value->brand_id.$com;
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
            </div>
        </div>
    </div> <!-- end card body-->
</div>
<div id="addNew-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                                <b>Add Products</b>
                </div>
                <form class="pl-3 pr-3" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    <div class="form-group">
                        <label for="password">Select Brand</label>
                        <select name="brand_id" class="form-control" required="">
                            @foreach($Brand_list as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Name</label>
                        <input class="form-control" type="name" id="name" name="name" required="" placeholder="Enter Product Name">
                    </div>
                    <div class="form-group">
                        <label for="username">MRP Price:</label>
                        <input class="form-control" type="number"  name="mrp"  placeholder="Enter MRP Price(Optional)">
                    </div>
                    <div class="form-group">
                        <label for="username">Photo</label>
                        <input class="form-control" type="file" id="name" name="Photo" required="" placeholder="Enter Product Name">
                    </div>
                    <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status" class="form-control"  required="">
                            <option value="Active" selected="">Active</option>
                            <option value="In-Active">In-Active</option>
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
            <form class="pl-3 pr-3" id="editform" action="{{ url('/update-products') }}" method="POST" enctype="multipart/form-data">
                                @csrf
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                        <b>Edit Products</b>
                </div>
                    <input class="form-control" type="hidden" id="edit_id" name="id" >
                    <div class="form-group">
                        <label for="password">Select Brand</label>
                        <select name="brand_id" class="form-control"  id="brand_id" required="">
                            @foreach($Brand_list as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Name</label>
                        <input type="text" class="form-control" name="name" id="edit_name">
                    </div>
                    <div class="form-group">
                        <label for="username">MRP Price:</label>
                        <input class="form-control" type="number" id="mrp"  name="mrp"  placeholder="Enter MRP Price(Optional)">
                    </div>
                    <div class="form-group">
                        <label for="username">Photo</label>
                        <input class="form-control" type="file" id="name" name="Photo"  placeholder="Enter Product Name">
                    </div>
                    <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status" class="form-control" id="status" required="">
                            <option value="Active" selected="">Active</option>
                            <option value="In-Active">In-Active</option>
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
