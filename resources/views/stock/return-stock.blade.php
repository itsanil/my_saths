@extends('layouts1.main')
@section('title', 'Return Stock')
@section('section_page', 'Return Stock')
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

    $('#return_qty').keyup(function(){
        $('#return_amt').val($('#return_qty').val() * $('#purchase_prices').val());
    });

    function Edit(id,name,order_no,purchase_quantity,available_quantity,purchase_price){
            $('#return_qty').val('');
            $('#return_amt').val('');
          $("#edit_id").val(id);
          $("#purchase_prices").val(purchase_price);
          $("#product_name").html('Name: '+name);
          $("#purchase_qty").html('Purchase Quantity: '+purchase_quantity);
          $("#available_qty").html('Available Quantity: '+available_quantity);
          $("#purchase_price").html('Purchase Price: '+purchase_price);
          $("#order_no").html('Order No:'+order_no);
          $("#return_qty").attr("max",available_quantity);
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
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Order No</th>
                    <th>Product</th>
                    <th>Purchase Qty</th>
                    <th>Available Qty</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($stock_datas as $key => $value) {
                    echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>".$value->stock_order_id."</td>";
                        echo "<td>".$value->name."</td>";
                        echo "<td>".$value->purchase_quantity."</td>";
                        echo "<td>".$value->available_quantity."</td>";
                        echo "<td>".$value->order_date."</td>";
                        $com = "'";
                    $string = $com.trim($value->product_id).$com.','.$com.$value->name.$com.','.$com.$value->stock_order_id.$com.','.$com.$value->purchase_quantity.$com.','.$com.$value->available_quantity.$com.','.$com.$value->purchase_price.$com;
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
<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="pl-3 pr-3" id="editform" action="{{ url('/update-return-stock') }}" method="POST" enctype="multipart/form-data">
                                @csrf
            <div class="modal-body">
                    <input class="form-control" type="hidden" id="edit_id" name="id" >
                    <input class="form-control" type="hidden" id="purchase_prices" name="purchase_prices" >
                    <div class="form-group">
                        <label for="username" id="order_no"></label>
                    </div>
                    <div class="form-group">
                        <label for="username" id="product_name"></label>
                    </div>
                    <div class="form-group">
                        <label for="username" id="purchase_qty"></label>
                    </div>
                    <div class="form-group">
                        <label for="username" id="available_qty"></label>
                    </div>
                    <div class="form-group">
                        <label for="username" id="purchase_price"></label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Return Qty</label>
                        <input type="number" min=1 class="form-control" name="return_qty" id="return_qty" placeholder="Return Qty" required="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Return Amt</label>
                        <input type="number" min=1 step="0.01" class="form-control" name="return_amt" id="return_amt" placeholder="Return Amt" readonly="">
                    </div>
                     <div class="form-group">
                        <label>Return Date:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="date" id="return_date" name="return_date" class="form-control datetimepicker-input" value="<?php echo date('Y-m-d'); ?>"  data-target="#reservationdate" required="">
                        </div>
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
