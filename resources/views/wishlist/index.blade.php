@extends('layouts1.main')
@section('title', 'Customer Wishlist')
@section('section_page', 'Customer Wishlist')
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
            "pageLength": 100,
          "responsive": true,
          "autoWidth": false,
        });
    });
    function Edit(id,name,mobile){
        $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '{{ route("get_wishlist_data") }}',
        data: {
          'id': id,
        },
        success: function(response) {
            var html = '';
            $.each(response.data, function( index, value ) {
                 html +='<tr>\
                          <td>'+value.name+'</td>\
                          <td>'+value.qty+'</td>\
                        </tr>';
            });
            $("#price-table").html(html);
            $("#head-table").html(name+'('+mobile+')');
            $(".modal").modal("show");
          // $('#Total_revenue').html(response.Total_revenue+' Rs/-');
          // $('#total_discount').html(response.total_discount+' Rs/-');
          // $('#total_sell').html(response.total_order+' Rs/-');
          // $('#total_delivery').html(response.total_delivery+' Rs/-');
        },
      });
         
           // $('#editform').attr('action', edit_url);
           
          
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
                            <th>Whatsapp No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($wishlist_data as $key => $value) {
                            echo "<tr>";
                                echo "<td>".($key+1)."</td>";
                                echo "<td>".$value->customer->name."</td>";
                                echo "<td>".$value->customer->whatsapp_no."</td>";
                                $com = "'";
                                $string = $com.trim($value->id).$com.','.$com.trim($value->customer->name).$com.','.$com.trim($value->customer->whatsapp_no).$com;
                                echo '<td>
                                <a class="btn btn-info btn-sm"  style="color:#ffff;" onclick="Edit('.$string.')">
                                      <i class="fas fa-eye">
                                      </i>
                                      view
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
<div class="modal fade" id="modal-lg" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="head-table">View Product Rate</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th>product Name</th>
                      <th>Qty</th>
                    </tr>
                  </thead>
                  <tbody id="price-table">
                    
                    
                  </tbody>
                </table>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
@endsection
