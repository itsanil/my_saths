@extends('layouts1.main')
@section('title', 'Wishlist')
@section('section_page', 'Wishlist')
@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- Select2 -->
<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function () {
    //Initialize Select2 Elements
    $('#wishlist_btn').on('click',function(){
        var status = true;
        var product_id_array = $("input[name='product_master_id[]']:checked").map(function(){return $(this).val();}).get();
        var product_qty_array = $("input[name='quanitty[]']").map(function(){
            if($(this).val() != ''){
                return $(this).val();
            }
            }).get();
        if (product_id_array.length != product_qty_array.length) {
            status = false;
            toastr.error('Please enter your desired quantity.');
        }
        if (product_id_array.length == 0) {
            status = false;
            toastr.error('Please select minimum 1 product in your wishlist.');
        }
        if(status){
            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'POST',
              url: '{{ route("wishlist.store") }}',
              data: {
                'product_id' : product_id_array
                ,'qty' : product_qty_array
                ,'type' : $('#process').val()
              },
              beforeSend: function() {
                $('.loadingoverlay').css('display', 'block');
              },
              success: function(response) {
                if ((response.success == 1)) {
                  $("#OtpModal").modal("hide");
                  toastr.success(response.message);
                  setTimeout(function(){
                    window.location.href = 'wishlist';
                  }, 2000);
                  
                } else {
                 toastr.error(response.message);
                }
              },
              complete: function() {
                $('.loadingoverlay').css('display', 'none');
              },
            });
        }
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
        @include('layouts1.include.searchbox')
        <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <div id="accordion">
                  <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                  @foreach($Tag_List as $keys => $values)
                    <div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $keys }}" class="collapsed" aria-expanded="false">
                          {{ str_replace("_", " ", $values->name) }}
                        </a>
                      </h4>
                    </div>
                        @if($keys == 0)
                            <div id="collapse{{ $keys }}" class="panel-collapse collapse show" style="">
                        @else
                            <div id="collapse{{ $keys }}" class="panel-collapse in collapse" style="">
                        @endif
                      <div class="card-body">
                                <?php $c = 0; ?>
                                @foreach(json_decode($values->product_master_id) as $keyss => $valuess)
                                   
                                    @foreach($product_master_list as $key => $value)
                                        @if($value->id == $valuess)
                                          @if($c%2 == 0)
                                            <div class="row">
                                          @endif
                                            <?php $selected = '';  ?>
                                            <?php $qty = '';  ?>
                                            @if(!empty($data))
                                                 @foreach(json_decode($data->product_id)->product_id as $i => $v)
                                                    @if($v == $valuess)
                                                        <?php $selected = 'checked';  ?>
                                                        <?php $qty = json_decode($data->product_id)->qty[$i];  ?>
                                                    @endif
                                                 @endforeach
                                            @endif
                                            

                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col">
                                                           <div class="form-check">
                                                                <input type="checkbox" name="product_master_id[]" class="form-check-input" <?php echo $selected;  ?> value="{{ $value->id }}">
                                                                <label class="form-check-label">{{ $value->name }}</label>
                                                            </div> 
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="quanitty[]" class="form-check-input" placeholder="quanitty" value="{{ $qty }}">
                                                            </div>  
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($c%2 == 1)
                                                </div>
                                                @endif
                                         <?php $c++; ?>  
                                        @endif
                                    @endforeach
                                     
                                @endforeach
                                @if($c%2 == 1)
                                                </div>
                                                @endif
                        </div>
                    </div>
                  </div>
                @endforeach
                </div>
              </div>
              <!-- /.card-body -->
            </div>
<div class="row">

    <div class="card card-info" style="min-width: 100%;">
        <form action="{{ url('tag.update') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            @if(empty($data))
                <input type="hidden" id="process" value="add">
            @else
                <input type="hidden" id="process" value="update">
            @endif
              <!-- /.card-body -->
            <div class="card-footer">
                  <button type="button" class="btn btn-primary" id="wishlist_btn">Update</button>
                  <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
