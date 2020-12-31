@extends('layouts1.main')
@section('title', 'Stock-In Worth')
@section('section_page', 'Stock-In Worth')
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

    function ExportReport()
    {
      window.open('{{ url('/') }}'+"/stock-worth-report/", "_blank");
    }
</script>
@endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
        	<div class="card-header">
        		
        		<center>Total Purchase Amt Of Stock Left: <b>{{ $total_purchase_price }}</b></center>
        	</div>
            <div class="card-body">
                <button class="btn btn-primary float-right" onclick="ExportReport()" >Export</button>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Purchase Qty</th>
                            <th>Total Available Qty</th>
                            <th>Purchase Price</th>
                            <th>Total Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($stock_list as $key => $value) {
                            
                            echo "<tr>";
                                echo "<td>".$value['name']."</td>";
                                echo "<td>".$value['purchase_quantity']."</td>";
                                echo "<td>".$value['available_quantity']."</td>";
                                echo "<td>".$value['purchase_price']."</td>";
                                echo "<td>".$value['total_purchase_price']."</td>";
                            echo "</tr>";
                        }
                     ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end card body-->
</div>
@endsection
