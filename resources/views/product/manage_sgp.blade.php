@extends('layouts1.main')
@section('title', 'Manage SGP')
@section('section_page', 'Manage SGP')
@section('css')
  <!-- Select2 -->
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')


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
        <form action="{{ route('sgp.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Manage SGP</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>SGP Value(%):</label>
                        <input type="number" name="value" value="<?php if(isset($sgp->value)){ echo $sgp->value; } ?>" placeholder="Enter SGP Value %" class="form-control" >
                </div>
            </div>
              <!-- /.card-body -->
            <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
