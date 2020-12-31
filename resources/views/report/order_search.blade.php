@extends('layouts1.main')
@section('title', 'Order Search')
@section('section_page', 'Order Search')
@section('css')
<style>
    textarea {
    resize: none;
}

#count_message {
  background-color: smoke;
  margin-top: -20px;
  margin-right: 5px;
}
    
</style>
<!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/daterangepicker/daterangepicker.css') }}">
<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- InputMask -->
<script src="{{ asset('public/adminlte/plugins/moment/moment.min.js') }}"></script>
<!-- validate -->
<script src="{{ asset('public/adminlte/plugins/jquery-validation/jquery.validate.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('public/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
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
<script src="{{ asset('public/adminlte/js/bootstrap3-typeahead.min.js') }}"></script>
<script type="text/javascript">
      var route = "{{ url('get-search-data') }}";
      var base_url = "{{ url('/order_search') }}";

      $(document).ready(function() {
          $("#search_form").submit(function(){
            window.location.href = base_url+'?name='+$('#search').val();
          });
          $('.typeahead').hide();
          $('#search').typeahead({
            source:  function (term, process) {
            return $.get(route, { term: term,filter:$('#filter_search').val() }, function (data) {
              var html = '';
              process($.map(data.product,function(obj){
                      // console.log(obj);
                                   html += '<li>\
                              <a class="dropdown-item " href="'+base_url+'?name='+obj.name+'" role="option" ><span class="search-drop" type="product" data="'+obj.name+'">'+obj.name+'</span>';
                              html +='<div class="btn btn-primary btn-sm float-right" style="margin-left: 20px;" >\
                                            <i class="fas fa-eye">\
                                            </i></div></a>';
                             html += '\
                            </li>';
                             
                        // return (obj);
              }));
              process($.map(data.result_combo,function(obj){
                        // console.log(obj);
                        html += '<li>\
                              <a class="dropdown-item " href="'+base_url+'?name='+obj.name+'" role="option" ><span class="search-drop" type="product" data="'+obj.name+'">'+obj.name+'</span>';
                              html +='<div class="btn btn-primary btn-sm float-right" style="margin-left: 20px;" >\
                                            <i class="fas fa-eye">\
                                            </i></div></a>';
                             html += '\
                            </li>';
                        // return (obj);
                }));
                $('.typeahead').show();
                $('.typeahead').html(html);
          });
        }
    });

      });
    
    $('#search').keyup(function(){
        if ($('#search').val()== '') {
          $('.typeahead').html('');
          $('.typeahead').hide();
        }
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
      <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="box-body">
                  <div class="container-fluid">
                    <form class="form-group" id="search_form">
                      <div class="input-group">
                        <input class="form-control form-control-navbar" id="search" type="search" placeholder="Search for your products" aria-label="Search" >
                        <ul class="typeahead dropdown-menu" role="listbox" style="display: block;width: 100%;">
                          
                        </ul>
                        <div class="input-group-append">
                          <button class="btn btn-danger" style="color: #ffffff;" type="submit">search
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                <!-- <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($product_list as $key => $value) {
                            echo "<tr>";
                                echo "<td>".$value->name."</td>";
                                echo "<td>
                                        <a class='btn btn-primary btn-sm' href='".url('/order_search').'?name='.$value->name."'>
                                            <i class='fas fa-eye'>
                                            </i>
                                        </a>
                                      </td>";
                            echo "</tr>";
                        }
                     ?>
                    </tbody>
                </table> -->
                </div>
            </div>
        </div>
    </div> <!-- end card body-->
</div>
@endsection
