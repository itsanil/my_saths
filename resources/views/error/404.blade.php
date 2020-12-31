@extends('layouts1.main')

@section('title', __('Not Found'))
@section('section_page','404 Error Page')
@section('code', '404')
@section('message', __('Not Found'))
@section('js')
<script>
  var product_id = '{{ $cart }}';
  var cart_count = parseInt('{{ $cart_count }}');
</script>
  @endsection
@section('content')
<div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for. Meanwhile, you may visit our <a href="{{ url('/') }}">website home</a> to search for your product.
          </p>

<!-- 
          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </form> -->
        </div>
        <!-- /.error-content -->
      </div>
      @include('layouts1.include.searchbox')
@endsection
