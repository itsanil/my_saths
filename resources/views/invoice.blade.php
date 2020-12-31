 <!DOCTYPE html>
<html lang="en">
<head>
    <title>Purchase Invoice #{{ $Order_data->id }} - {{ date("d/m/yy", strtotime($Order_data->order_date)) }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Purchase Invoice containing a list of all products ordered."/>
    <meta name="robots" content="noindex">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/images/favicon_io/favicon-16x16.png') }}">
    <link rel="stylesheet" href="{{ asset('public/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Bootstrap CDN -->
    <!-- Override some Bootstrap CDN styles - normally you should apply these through your Bootstrap variables / sass -->
    <style>

        /*body { font-family: "Roboto", serif; font-size: 0.8rem; font-weight: 400; line-height: 1.4; color: #000000; }*/
        h1, h2, h4, h5 { font-weight: 700; color: #000000; }
        h1 { font-size: 2rem; }
        h2 { font-size: 1.6rem; }
        h4 { font-size: 1.2rem; }
        h5 { font-size: 1rem; }
        .table { color: #000; }
        .table td, .table th { border-top: 1px solid black; }
        .table thead th { vertical-align: bottom; border-bottom: 2px solid #000; }

        @page {
            margin-top: 2.5cm;
            margin-bottom: 2.5cm;
        }

        @page :first {
            margin-top: 0;
            margin-bottom: 2.5cm;
        }
    </style>

</head>
<body>

<!-- <div style="background-color: #000000; height: 10px;"></div> -->

<div class="container-fluid pt-2 pt-md-4 px-md-5">

    <!-- Invoice heading -->

    <table class="table table-borderless">
        <tbody>
        <tr>
            <td class="border-0">
                <div class="row">
                    <div class="col-md text-center text-md-left mb-3 mb-md-0">
                        <img src="{{ asset('public/images/darksg.jpg') }}" alt="sgLogo" class=""
           style="width:150px;height: 150px;">
                    </div>

                    <div class="col text-center text-md-right">

                        <span class="d-md-block">
                            <h1>Billed To</h1>
                        </span>

                        <h4 class="mb-0">{{ $Order_data->customer->name }}</h4>

                       {{ $address }}<br/>

                        <h5 class="mb-0 mt-3">{{ date("jS F Y", strtotime($Order_data->order_date)) }}</h5><br/>
                        <span>Order No: {{ $Order_data->id }}</span>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Invoice items table -->

    <table class="table">
        <thead>
        <tr>
            <th>Product</th>
            <th class="text-center">Qty</th>
            <th class="text-right">Price</th>
        </tr>
        </thead>
        <tbody>
            @foreach($product['name'] as $key => $value)
                <tr>
                    <td>{{ $value }}</td>
                    <td class="text-center">{{ $product['order_qty'][$key] }}</td>
                    <td class="text-right">{{ $product['sub_price'][$key] }}</td>
                </tr>
            @endforeach
                <tr>
                                <td  colspan="2" class="text-center" >Gross Total:</td>
                                <td class="text-right">{{ ($Order_data->order_amt + $Order_data->discount_amount - $Order_data->delivery_amount) }}</td>
                            </tr>
                            @if($Order_data->discount_amount != 0)
                            <tr>
                                <td  colspan="2" class="text-center" >Discount:</td>
                                <td class="text-right">{{ ($Order_data->discount_amount) }}</td>
                            </tr>
                            @endif
                            @if($Order_data->delivery_amount != 0)
                            <tr>
                                <td  colspan="2" class="text-center" >Delivery Charges:</td>
                                <td class="text-right">{{ $Order_data->delivery_amount }}</td>
                            </tr>
                            @endif
                            <tr style="color: red;">
                                <td  colspan="2" class="text-center" ><b>YOU SAVED:</b></td>
                                <td class="text-right"><b>{{ $Order_data->save_amt }}</b></td>
                            </tr>
                            <tr style="color: green;">
                                <td  colspan="2" class="text-center" ><b>Total Payable:</b></td>
                                <td class="text-right"><b>{{ $Order_data->order_amt }}</b></td>
                            </tr>
                            <tr>
                                <td  colspan="2" class="text-center" ><b>Status:</b></td>
                                <td class="text-right" >
                                    @if($Order_data->order_status == 'pending')
                                        <b style="color: red;">Queued</b>
                                    @endif
                                    @if($Order_data->order_status == 'approved' && $Order_data->delivery_status == 0)
                                        <b style="color: red;">Pending Delivery</b>
                                    @endif
                                    @if($Order_data->order_status == 'approved' && $Order_data->delivery_status == 1 && $Order_data->payment_status == 0)
                                        <b style="color: red;">Pending Payment</b>
                                    @endif
                                    @if($Order_data->order_status == 'approved' && $Order_data->delivery_status == 1 && $Order_data->payment_status == 1)
                                        <b style="color: green;">Paid</b>
                                    @endif
                                    @if($Order_data->order_status == 'cancel')
                                        <b style="color: red;">Cancelled</b>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="2" class="text-center" ></td>
                                <td class="text-right"></td>
                            </tr>
        </tbody>
    </table>

    <!-- Thank you note -->
    <div class="card">
        <div class="card-body" style="background-color:  #343E47;">
            <h5 class="text-center pt-2" style="font-weight: 500;color: #ffff;">
                Pay Online Using <u>GPay:</u> 9920985930 or <u>UPI:</u> savita.gaggar@icici
            </h5>
        </div>
    </div>
    <h5 class="text-center pt-2" style="font-weight: 400;">
        Thank You for shopping with <b>Savita’s Grocery.</b><br/><hr style="border: 0;
    border-top: 1px solid black;
    /* color: black; */
    width: 30%;">Shop <b>Online</b> at <b><a href="https://www.sgonline.in">https://www.sgonline.in</a></b> or on <b>WhatsApp:</b><b style="color: red;"> 9321504147</b>.
    </h5>
</div>
</body>

