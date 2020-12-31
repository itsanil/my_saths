@extends('layouts.main')
@section('title', 'Home')
@section('css')
<!-- BEGIN PAGE VENDOR CSS-->
    <!-- END PAGE VENDOR CSS-->
    
    <!-- BEGIN PAGE LEVEL CSS-->
    <!-- END PAGE LEVEL CSS-->
@endsection
@section('content')
<div class="container-fluid">
    <div class="card-header">Welcome To Dashboard</div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            You are logged in as admin!
        </div>
</div>
@endsection
