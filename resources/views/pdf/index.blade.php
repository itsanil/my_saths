@extends('layouts1.main')
@section('title', 'My PDF')
@section('section_page', 'My PDF')
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
        <script src="{{ asset('public/js/pages/demo.form-wizard.js') }}"></script>
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
            <a href="{{ route('online-pdf.create') }}"  class="btn btn-success float-right">
            Create new PDF
            </a>
        </div>
    </div>
    <div class="row">
      <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Whatsapp No</th>
                                        <th>Store Name</th>
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                               
                                <tbody>
                                    <?php 
                                    foreach ($pdfData as $key => $value) {
                                        echo "<tr>";
                                            echo "<td>".($key+1)."</td>";
                                            echo "<td>".$value->whatsapp_no."</td>";
                                            echo "<td>".$value->store_name."</td>";
                                            echo "<td>".$value->created_at."</td>";
                                            echo "<td>".$value->updated_at."</td>";
                                            $com = "'";
                                        $string = $com.trim($value->id).$com;
                                            echo '<td>
                                            <div class="button-list">
                                            <a class="btn btn-primary btn-sm" target="_blank" href="'.route('online-pdf.show',$value->id).'">
                                                  <i class="fas fa-folder">
                                                  </i>
                                                  View
                                            </a>
                                            <a class="btn btn-info btn-sm"  href="'.route('online-pdf.edit',$value->id).'">
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
            </div>
        </div>
    </div>
@endsection
