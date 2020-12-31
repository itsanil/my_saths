@extends('layouts1.main')
@section('title', 'Customer Details')
@section('section_page', 'Customer Details')
@section('css')


<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- DataTables -->

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
            <div class="card-header">
                <h3 class="card-title">Customer Details</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-user mr-1"></i> Name</strong>:{{ $Customer_Data->name }}

                <p class="text-muted">
                  
                </p>

                <hr>

                <strong><i class="fas fa-phone mr-1"></i> Contact Details</strong>

                <p class="text-muted">
                    <ul>
                        <li><b>Whatsapp Number</b>&nbsp;:&nbsp;&nbsp;&nbsp;<a href='tel:+91{{ $Customer_Data->whatsapp_no }}' >{{ $Customer_Data->whatsapp_no }}</a></li>
                        <?php 
                        if (!empty($Customer_Data->contact_no)) {
                            echo "<li><b>Contact Number</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<a href='tel:+91".$Customer_Data->contact_no."' >".$Customer_Data->contact_no."</a></li>";
                        } 
                         ?>
                    </ul>
                  
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">
                    <ul>
                        <?php 
                        if (!empty($Customer_Data->flat_no)) {
                            echo "<li><b>flat Number</b>:".$Customer_Data->flat_no."</li>";
                        } 
                         ?>
                        <li><b>Building Name</b>:{{ $Customer_Data->building_name }}</li>
                        <li><b>Area Name</b>:{{ $Customer_Data->areas->name }}</li>
                        <?php 
                        if (!empty($Customer_Data->lane)) {
                            echo "<li><b>Lane</b>:".$Customer_Data->lane."</li>";
                        } 
                         ?>
                        <li><b>City</b>:{{ $Customer_Data->city }}</li>
                        
                    </ul>
                </p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Status : </strong>
                <?php 
                    if ($Customer_Data->status == 1) {
                        echo '<span class="badge badge-success">Active</span>';
                    } else {
                        echo '<span class="badge badge-danger">In-Active</span>';
                    }
                ?>
              </div>
              <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Back</a>
                <a href="{{ url('/customer/order-list/') }}/{{ $Customer_Data->id }}" title="" class="btn btn-primary">Order List</a>
            </div>
        </form>
    </div>
</div>

@endsection
