@extends('layouts1.main')
@section('title', 'Return Stock Log')
@section('section_page', 'Return Stock Log')
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

<div class="row">
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Order No</th>
                    <th>Product</th>
                    <th>Purchase Qty</th>
                    <th>Return Qty</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($stock_logs as $key => $value) {
                    echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>".$value->product->stock_order_id."</td>";
                        echo "<td>".$value->product->name."</td>";
                        echo "<td>".$value->purchase_qtys."</td>";
                        echo "<td>".$value->return_qty."</td>";
                        echo "<td>".$value->return_date."</td>";
                    echo "</tr>";
                }
                // <button type="button" onclick="Delete('.$value->id.')" class="btn btn-danger"><i class="mdi mdi-window-close"></i> </button>
                //         </div>
             ?>
            </tbody>
        </table>
    </div> <!-- end card body-->
</div>

@endsection
