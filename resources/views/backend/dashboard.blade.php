@extends('backend.main')
@section('title', 'Dashboard')
@section('section_page', 'Dashboard')
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

@endsection
