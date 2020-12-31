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
          aLengthMenu: [
              [25, 50, 100, 200, -1],
              [25, 50, 100, 200, "All"]
          ],
          iDisplayLength: 200,
        });
        $('.sel-area').hide();
        $('.sel-offer').hide();
        $('.combo-product').hide();
        $('.sel-product').show();
        var brand_list_count = $('#brand_list_count').val();
        while (brand_list_count > 0) {
          $('#brand'+brand_list_count).hide().prop('required',false);
          brand_list_count--;
        }
        $('#position').on('change',function(){
            if ($('#position').val() == 'Top Selling Products0') {
                $('.sel-area').hide();
                $('.sel-offer').hide();
                $('.sel-product').show();
                $('.combo-product').hide();
                var brand_list_count = $('#brand_list_count').val();
                while (brand_list_count > 0) {
                  $('#brand'+brand_list_count).hide().prop('required',false);
                  brand_list_count--;
                }
                $('#Most-Sell-Product').show();
            } else {

                if ($('#position').val() == 'Our Delivery Area}') {
                    $('.sel-area').show();
                    $('.sel-offer').hide();
                    $('.sel-product').hide();
                    $('.combo-product').hide();
                }else{
                    if ($('#position').val() == 'Combo Offer}') {
                        $('.combo-product').show();
                        $('.sel-area').hide();
                        $('.sel-offer').hide();
                        $('.sel-product').hide();
                    }else{
                        if ($('#position').val() == 'Offer}') {
                            $('.sel-area').hide();
                            $('.sel-offer').show();
                            $('.sel-product').hide();
                            $('.combo-product').hide();
                        } else{
                            $('.sel-area').hide();
                            $('.sel-offer').hide();
                            $('.sel-product').show();
                            $('.combo-product').hide();
                            $('#Most-Sell-Product').hide().prop('required',false);
                            var brand_list_count = $('#brand_list_count').val();
                            while (brand_list_count > 0) {
                              $('#brand'+brand_list_count).hide().prop('required',false);
                              brand_list_count--;
                            }
                            // var myString = $('#position').val();
                            // var lastChar = myString[myString.length -1];
                            // $('#brand'+lastChar).show();
                            $('#brand'+$('#position').val().replace ( /[^\d.]/g, '' )).show();
                        }
                    }
                }
            }
        });

    });
    function Edit(id,position,status,product_master_id){
        $("#offer").html('');
        $("#edit_product_master_id").show();
        $("#label_position").html('');
        $("#edit_product_master_id").html('');
          $("#edit_id").val(id);
          $("#edit_position").val(position);
          $("#label_position").append(position);
          $("#edit_product_master_id").append('<b>you have selected:</b><br><span>'+product_master_id+'</span>');
          $("#edit_status").val(status);
          if (position == 'Our Delivery Area') {
                    $('.sel-area').show();
                    $('.sel-product').hide();
                    $('.sel-offer').hide();
          }if (position == 'Offer') {
                    $('.sel-area').hide();
                    $('.sel-product').hide();
                    $('.sel-offer').show();
                    $("#edit_product_master_id").hide();
                    $("#offer").append('<label for="username">Change Offer Text</label><textarea  class="textarea" name="offer">'+product_master_id+'</textarea>');
                     $('.textarea').summernote();
          } else {
                    $('.sel-area').show();
                    $('.sel-offer').hide();
                    $('.sel-product').hide();
          }
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
    <input type="hidden" id="brand_list_count" value="{{ $brand_list->count() }}">
        <div class="col-12">
            <button type="button" data-toggle="modal" data-target="#addNew-modal"  class="btn btn-success float-right">
            Add Home product
            </button>
        </div>
    </div>
<div class="row">
    <div class="card-body">
        
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($home_product_list as $key => $value) {
                    echo "<tr>";
                        echo "<td>".($key+1)."</td>";
                        echo "<td>".$value->position."</td>";
                        echo "<td>".$value->status."</td>";
                        if ($value->position == 'Offer') {
                            $html = $value->product_master_id;
                        }else{
                            $product_master_id = json_decode($value->product_master_id);
                              $html = '';
                              if($value->position == 'Our Delivery Area'){
                                    $data_list = $Area_list;
                              }else{
                                    $data_list = $product_master_list;
                              }
                              foreach ($product_master_id as $keys => $v) {
                                foreach ($data_list as $keys => $values) {
                                    if($values->id == $v){
                                        $html .= $values->name.',';
                                    }
                                }
                                
                              }
                        }
                        
                        $com = "'";
                        $string = $com.trim($value->id).$com.','.$com.$value->position.$com.','.$com.$value->status.$com.','.$com.rtrim($html, ", ").$com;
                         echo '<td><a class="btn btn-info btn-sm"  href="'.route('manage-home.edit',$value->id).'">
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
<div id="addNew-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                                <b>Add Home Product</b>
                </div>
                <form class="pl-3 pr-3" action="{{ route('manage-home.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    <div class="form-group">
                        <label for="username">Select Product Section</label>
                        <select class="form-control" id="position" name="position"  required="">
                            <option value="Top Selling Products0">Top Selling Products</option>
                            <option value="Our Delivery Area}">Our Delivery Area</option>
                            <option value="Offer}">Offer</option>
                            <option value="Combo Offer}">Our Combo Product</option>
                            @foreach($brand_list as $key => $value)
                                <option value="{{ $value->name }}{{ $value->id }}" >{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group sel-product">
                        <label for="username">Select Product</label>
                        <section id="Most-Sell-Product">
                                @foreach($product_master_list as $key => $value)
                                     <div class="form-check">
                                    <input type="checkbox" name="product_master_id[]" class="form-check-input" value="{{ $value->id }}">
                                    <label class="form-check-label">{{ $value->name }}</label>
                                </div>
                                @endforeach
                                 @foreach($combo_list as $key => $value)
                                    <div class="form-check">
                                    <input type="checkbox" name="product_master_id[]" class="form-check-input" value="{{ $value->id }}-combo">
                                    <label class="form-check-label">{{ $value->product_combo_name }}</label>
                                </div>
                                @endforeach
                        </section>
                        @foreach($brand_list as $key => $value)
                            <section id="brand{{ $value->id }}">
                                    @foreach($product_master_list as $keys => $values)
                                        @if($values->brand->name == $value->name)
                                            <div class="form-check">
                                    <input type="checkbox" name="product_master_id[]" class="form-check-input" value="{{ $values->id }}">
                                    <label class="form-check-label">{{ $values->name }}</label>
                                </div>
                                        @endif
                                    @endforeach
                            </section>
                        @endforeach
                    </div>
                    <div class="form-group sel-area">
                        <label for="username">Select Area</label>
                        <section id="Most-Sell-Product">
                                @foreach($Area_list as $key => $value)
                                     <div class="form-check">
                                    <input type="checkbox" name="product_master_id[]" class="form-check-input" value="{{ $value->id }}">
                                    <label class="form-check-label">{{ $value->name }}</label>
                                </div>
                                @endforeach
                        </section>
                    </div>
                    <div class="form-group combo-product">
                        <label for="username">Select Combo Products</label>
                        <section id="Most-Sell-Product">
                                @foreach($combo_list as $key => $value)
                                    <div class="form-check">
                                    <input type="checkbox" name="product_master_id[]" class="form-check-input" value="{{ $value->id }}">
                                    <label class="form-check-label">{{ $value->product_combo_name }}</label>
                                </div>
                                @endforeach
                        </section>
                    </div>
                    <div class="form-group sel-offer">
                        <label for="username">Enter Offer Text</label>
                        <textarea  class="textarea" name="offer">
                        </textarea>
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
