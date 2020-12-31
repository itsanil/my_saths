@extends('layouts1.main')
@section('title', 'Tag Edit')
@section('section_page', 'Tag Edit')
@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- Select2 -->
<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
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
    <div class="card card-info" style="min-width: 100%;">
        <form action="{{ route('tag.update',$Tag_data->id) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $Tag_data->id }}">
            <div class="card-header">
                <h3 class="card-title">Edit Tag</h3>
            </div>
            <div class="card-body">
                 <div class="form-group text-center" >
                        <input type="text" class="form-control" id="edit_tag" name="name" value="{{ $Tag_data->name }}" required="" >
                    </div>

                    @if($Tag_data->photo !='')
                        <center>
                            <img src="{{ url('storage') }}/{{ $Tag_data->photo }}" alt="{{ $Tag_data->name }}">
                        </center>
                    @endif

                    <div class="form-group">
                        <label for="username">Change Photo</label>
                        <input class="form-control" type="file" name="photo" >
                    </div>

                    <div class="form-group sel-product">
                        <label for="username">Select Product:</label>
                        <section id="Most-Sell-Product">
                                @foreach($product_master_list as $key => $value)
                                <?php $selected = '';  ?>
                                
                                @foreach(json_decode($Tag_data->product_master_id) as $keys => $values)
                                <?php if($value->id == $values){
                                    $selected = 'checked';
                                } ?>
                                @endforeach
                                <div class="form-check">
                                    <input type="checkbox" name="product_master_id[]" class="form-check-input" <?php echo $selected;  ?> value="{{ $value->id }}">
                                    <label class="form-check-label">{{ $value->name }}</label>
                                </div>
                                @endforeach
                                @if(isset($combo_list))
                                    @foreach($combo_list as $key => $value)
                                    <?php $selected = '';  ?>
                                    
                                    @foreach(json_decode($Tag_data->product_master_id) as $keys => $values)
                                    <?php if($value->id.'-combo' == $values){
                                        $selected = 'checked';
                                    } ?>
                                    @endforeach
                                    <div class="form-check">
                                        <input type="checkbox" name="product_master_id[]" class="form-check-input" <?php echo $selected;  ?> value="{{ $value->id }}-combo">
                                        <label class="form-check-label">{{ $value->product_combo_name }}</label>
                                    </div>
                                    @endforeach
                                @endif
                        </section>
                    </div>

                    <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status" id="edit_status" class="form-control" required="">
                            <option value="Active" <?php if ($Tag_data->status == 'Active') {
                                echo "selected";
                            } 
                              ?>>Active</option>
                            <option value="In-Active"  <?php if ($Tag_data->status == 'In-Active') {
                                echo "selected";
                            } 
                              ?>>In-Active</option>
                        </select>
                    </div>        
            </div>
              <!-- /.card-body -->
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
