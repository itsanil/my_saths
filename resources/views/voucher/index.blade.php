@extends('layouts1.main')
@section('title', 'Voucher')
@section('section_page', 'Voucher')
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
        <div class="card-header">
            <a href="{{ route('voucher.create') }}"  class="btn btn-success float-right">
                Add Voucher
            </a> 
        </div>
       <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Voucher</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($voucher_list as $key => $value) {
                    
                    echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>".$value->voucher_code."</td>";
                        echo "<td>".$value->type."</td>";
                        if ($value->type == 'Flate') {
                             echo "<td>".$value->value." Rs/-</td>";
                        } else {
                             echo "<td>".$value->value."%</td>";
                        }
                        echo "<td>".$value->status."</td>";
                        echo '<td>
                        <a class="btn btn-info btn-sm"  style="color:#ffff;" href="'.route('voucher.edit',$value->id).'">
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
                                <b>Add Voucher</b>
                </div>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="pl-3 pr-3" id="editform" action="{{ url('/update-promotions') }}" method="POST" enctype="multipart/form-data">
                                @csrf
            <div class="modal-body">
                <div class="form-group">
                        <label for="username">Promo Name</label>
                        <input class="form-control" type="name" id="edit_name" name="promo_name" required="" placeholder="Enter Promo Name">
                    </div>
                    <div class="form-group">
                        <label for="username">Banner(kb size should not exceed 1 mb)</label>
                        <input class="form-control" type="file"  name="banner"  placeholder="Enter Product Name">
                    </div>
                    <div class="form-group">
                        <label for="username">Link</label>
                        <input class="form-control" type="url" id="edit_link" name="link" placeholder="Enter Link(Optional)">
                    </div>
                     <div class="form-group">
                        <label for="username">Start Date</label>
                        <input class="form-control" type="date" id="edit_start_date" name="start_date" placeholder="Enter Satrt Date" required="">
                    </div>
                    <div class="form-group">
                        <label for="username">End Date</label>
                        <input class="form-control" type="date" id="edit_end_date" name="end_date" placeholder="Enter End Date" required="">
                    </div>
                    <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status" id="edit_status" class="form-control" required="">
                            <option value="Active">Active</option>
                            <option value="In-Active">In-Active</option>
                        </select>
                    </div>
                    <input class="form-control" type="hidden" id="edit_id" name="id" >
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
