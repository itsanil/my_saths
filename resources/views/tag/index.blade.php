@extends('layouts1.main')
@section('title', 'Manage Home')
@section('section_page', 'Manage Home')
@section('css')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.css') }}">
 <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')

<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
    $(function () {
        $('.select2').select2();
        $("#example1").DataTable({
          "responsive": true,
          "autoWidth": false,
        });
    });
    function Edit(id,name,status,product_master_id){
        $("#offer").html('');
        $("#edit_product_master_id").show();
        $("#label_name").html('');
        $("#edit_tag").html('');
          $("#edit_id").val(id);
          $("#edit_tag").val(name);
          $("#label_name").append(name);
          $("#edit_product_master_id").append('<b>you have selected:</b><br><span>'+product_master_id+'</span>');
          $("#edit_status").val(status);
          
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
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-2">
                  </div>
                  <div class="col-10">
                    <button type="button" data-toggle="modal" data-target="#addNew-modal"  class="btn btn-success float-right">
                        Add Tag
                    </button>
                  </div>
                </div>
              </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Tag</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($Tag_list as $key => $value) {

                            echo "<tr>";
                                echo "<td>".($key+1)."</td>";
                                echo "<td>".$value->name."</td>";
                                echo "<td>".$value->status."</td>";

                                    $product_master_id = json_decode($value->product_master_id);
                                        $html = '';
                                        $data_list = $product_master_list;
                                        foreach ($product_master_id as $keys => $v) {
                                            foreach ($data_list as $keys => $values) {
                                                if($values->id == $v){
                                                    $html .= $values->name.',';
                                                }
                                            }
                                        }
                                $com = "'";
                                $string = $com.trim($value->id).$com.','.$com.$value->name.$com.','.$com.$value->status.$com.','.$com.rtrim($html, ", ").$com;
                                echo '<td><a class="btn btn-info btn-sm"  href="'.route('tag.edit',$value->id).'">
                                          <i class="fas fa-pencil-alt" >Edit
                                          </i>
                                    </a></td>';
                            echo "</tr>";
                        }
                        // <button type="button" onclick="Delete('.$value->id.')" class="btn btn-danger"><i class="mdi mdi-window-close"></i> </button>
                        //         </div>
                     ?>
                    </tbody>
                </table>
            </div> <!-- end card body-->
            </div>
        </div>
    </div>
<div id="addNew-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                                <b>Add Tag</b>
                </div>
                <form class="pl-3 pr-3" action="{{ route('tag.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    <div class="form-group">
                        <label for="username">Enter Tag Name</label>
                        <input type="text"  class="form-control" name="name" required="">
                    </div>
                    <div class="form-group">
                        <label for="username">Photo</label>
                        <input class="form-control" type="file" name="photo" required="" >
                    </div>
                    <div class="form-group sel-product">
                        <label for="username">Select Product:</label>
                        <section id="Most-Sell-Product">
                                @foreach($product_master_list as $key => $value)
                                <div class="form-check">
                                    <input type="checkbox" name="product_master_id[]" class="form-check-input" value="{{ $value->id }}">
                                    <label class="form-check-label">{{ $value->name }}</label>
                                </div>
                                @endforeach
                                @if(isset($combo_list))
                                    @foreach($combo_list as $key => $value)
                                    <div class="form-check">
                                        <input type="checkbox" name="product_master_id[]" class="form-check-input" value="{{ $value->id }}-combo">
                                        <label class="form-check-label">{{ $value->product_combo_name }}</label>
                                    </div>
                                    @endforeach
                                @endif
                        </section>
                    </div>

                    <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status" class="form-control" required="">
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
@endsection
