@extends('layouts1.main')
@section('title', 'Discount %')
@section('section_page', 'Discount %')
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
</script>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>MRP</th>
                            <th>Sale Price</th>
                            <th>Discount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($product_master_list as $key => $value) {
                            
                            echo "<tr>";
                                echo "<td>".$value->name."</td>";
                                echo "<td>".$value->mrp."</td>";
                                echo "<td>".$value->sale."</td>";
                                echo "<td>".$value->percentage." %</td>";
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
