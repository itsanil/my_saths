@extends('layouts1.main')
@section('title', 'Edit Combo')
@section('section_page', 'Edit Combo')
@section('css')
  <!-- Select2 -->
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- Select2 -->

<script src="{{ asset('public/adminlte/js/bootstrap-input-spinner.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#status').val("{{ $combo_data->status }}");
        amtcalcute();
        $("input[name='product_qty[]']").inputSpinner();
        $('.product_qty').on('change',function(){
                var status = true;
                var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
                $("input[name='product_id[]']").map(function(index,value){
                    $("input[name='product_qty[]']").map(function(key,values){
                        if(index == key){
                            var data = $(this).attr('data')+'_'+$(this).val();
                            value = $(this).attr('data')+'_'+$(this).val();
                        }
                    });
                    $(this).val(value);
                });
                amtcalcute();
    });

        $('#form_add').on('submit',function(){
            var p = 0;
            $(':checkbox:checked').map(function() {
                var split = this.value.split('_');
                p += parseInt(split[1])*$(this).attr('data');
            });
            if (p == 0) {
                toastr.error('please select atleast one product!!');
                return false;
            }
        });

        $('.form-check-input').on('click',function(){
            amtcalcute();
        });

        function amtcalcute(){
            var p = 0;
            var html = '';
            $(':checkbox:checked').map(function() {
                var split = this.value.split('_');
                p += parseInt(split[1])*$(this).attr('data');
                html += '<input type="hidden" name="id[]" value="'+split[0]+'" ><input type="hidden" name="qty[]" value="'+split[1]+'" >';
            });
            $('#actual_price').html(' '+p);
            $('#html').html(html);
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
        @endif.
<div class="row">
    <div class="card card-info" style="min-width: 100%;">
            <form class="pl-3 pr-3" action="{{ route('products-combo.update',$combo_data->id) }}" id="form_add" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                    <div class="form-group">
                        <label for="username">Enter Combo Name</label>
                        <input type="text"  class="form-control" name="product_combo_name" value="{{ $combo_data->product_combo_name }}" required="">
                    </div>
                    <div class="form-group">
                        <label for="username">Photo</label>
                        <input class="form-control" type="file" name="photo">
                    </div>
                    <div class="form-group sel-product">
                        <label for="username">Select Product:</label>
                        <section id="Most-Sell-Product">
                                @foreach($product_master_list as $key => $value)

                                <?php 
                                $check = '';
                                $val = 1;
                                    foreach ($product_name as $keys => $values) {
                                        if ($values == $value->name) {
                                            $check = 'checked';
                                            $val = $qty[$keys];
                                        }
                                    }
                                 ?>
                                <div class="form-check">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="checkbox" name="product_id[]" class="form-check-input" data="{{ $value->sale_price }}" value="{{ $value->id }}_1" {{ $check }} >
                                            <label class="form-check-label">{{ $value->name }}</label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-check-label">
                                                <input type="number" class="form-control product_qty" min="1" name="product_qty[]" data="{{ $value->id }}" value="{{ $val }}" >
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                        </section>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="username">Actual Price :<span id="actual_price"> 0</span></label>
                        </div>
                        <div class="col-md-6">
                            <input type="number" value="{{ $combo_data->combo_price }}" class="form-control product_qty" name="price" placeholder="enter sale price" required="">
                        </div>
                    </div>
                    <section id="html">
                        
                    </section>
                    <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status" class="form-control" id="status" required="">
                            <option value="Active" selected="">Active</option>
                            <option value="In-Active">In-Active</option>
                        </select>
                    </div>
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Confirm</button>
                <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Cancel</a>
            </div>
        </form>    
    </div>
</div>
@endsection
