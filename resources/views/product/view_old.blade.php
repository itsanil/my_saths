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
<div class="row">
    <div class="card card-info" style="min-width: 100%;">
            <div class="card-header">
                <h3 class="card-title">Product Details</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-user mr-1"></i> Name</strong>:{{ $product_Data->name }}

                <p class="text-muted">
                  <?php 
                        if (!empty($product_Data->img)) {
                            echo "<img src='".url('storage/'.$product_Data->img)."' style='width: 300px;height: 200px;'>";
                        } 
                  ?>
                </p>

                <hr>
                <strong><i class="ion ion-ios-cart-outline mr-1"></i> Price</strong>

                <p class="text-muted">
                    <ul style="    text-transform: capitalize;">
                        <li><b>Product Sourece</b>:{{ $product_Data->ProductSource->name }}({{ $product_Data->ProductSource->contact_no }})</li>
                        <li><b>bulk sale price</b>:{{ $product_Data->bulk_sale_price }}</li>
                        <li><b>sale price</b>:{{ $product_Data->sale_price }}</li>
                        <li><b>purchase price</b>:{{ $product_Data->purchase_price }}</li>
                        <li><b>purchase qty</b>:{{ $product_Data->purchase_qty }}</li>
                        <li><b>order date</b>:{{ $product_Data->order_date }}</li>
                        <li><b>transport expence</b>:{{ $product_Data->transport_expence }}</li>
                        <li><b>order amount</b>:{{ $product_Data->order_amount }}</li>
                    </ul>
                </p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Status : </strong>
                <?php 
                    if ($product_Data->status == 1) {
                        echo '<span class="badge badge-success">Active</span>';
                    } else {
                        echo '<span class="badge badge-danger">In-Active</span>';
                    }
                ?>
              </div>
              <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{ url()->previous() }}" title="" class="btn btn-primary">Back</a>
            </div>
        </form>
    </div>
</div>

@endsection
