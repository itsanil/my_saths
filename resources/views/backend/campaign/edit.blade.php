@extends('backend.main')
@section('title', 'Campaign-Edit')
@section('section_page', 'Campaign-Edit')
@section('css')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.css') }}">
 <!-- Select2 -->
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')

<script src="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote();
    $('#category_id').val('{{ $campaign->category_id  }}');
  })
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
                <form class="pl-3 pr-3" action="{{ route('campaigns.update',$campaign->id) }}" method="POST" enctype="multipart/form-data">
                  @method('PUT')
                  @csrf
                    <div class="form-group">
                        <label for="username">Select Category</label>
                        <select name="category_id" id="category_id" class="form-control" readonly required="">
                          @foreach($data as $key => $value)
                            <option value="{{ $value->id }}" selected="">{{ $value->title }}</option>
                          @endforeach
                        </select>
                    </div>
                    @if($campaign->photo !='')
                        <center>
                            <img src="{{ url('storage') }}/{{ $campaign->photo }}" alt="">
                        </center>
                    @endif
                    <div class="form-group">
                        <label for="username">Photo</label>
                        <input class="form-control" type="file" name="photo"  >
                    </div>
                    <div class="form-group sel-product">
                        <label for="username">Description:</label>
                        <textarea  class="textarea" name="description" required="">{{ $campaign->discription  }}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status" id="edit_status" class="form-control" required="">
                            <option value="Active" <?php if($campaign->status == 'Active'){ echo "selected"; } ?>>Active</option>
                            <option value="In-Active" <?php if($campaign->status == 'In-Active'){ echo "selected"; } ?>>In-Active</option>
                        </select>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div> <!-- end card body-->
            </div>
        </div>
    </div>
@endsection
