<?php

namespace App\Http\Controllers;

use App\Area;
use App\Order;
use App\Product;
use App\ProductMaster;
use App\ProductCombo;
use Illuminate\Http\Request;
use PDF;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $area_list = Area::all();
        return view('area.index',compact('area_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request['name'];
        $count = Area::where('name',$name)->count();
        if ($count == 0) {
            $data = new Area();
            $data->name = $name;
            $data->save();
            return redirect('area')->with(['success'=> 'Save Successful!!']);
        } else {
            return redirect('area')->with(['error'=> 'Duplicate Area Entered!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $name = $request['name'];
        $count = Area::where('name',$name)->count();
        if ($count == 0) {
            $data = Area::where('id',$request['id'])->first();
            $data->name = $name;
            $data->save();
            return redirect('area')->with(['success'=> 'Update Successful!!']);
        } else {
            return redirect('area')->with(['error'=> 'Duplicate Area Entered!!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        //
    }

    public function getinvoice(){
        // echo "<pre>"; print_r($_GET['id']); echo "</pre>"; die('end of code');
        $Order_data_list = Order::all();
        $id = '';
        foreach ($Order_data_list as $key => $value) {
            if(substr($value->id.md5($value->id), 0, 7) == $_GET['id']){
                $id = $value->id;
            }
        }
        if($id == ''){
           return view('error.404'); 
        }
        $Order_data = Order::with('customer')->with('PaymentType')->with('PaymentType')->where('id',$id)->first();
        $order_product_qty = json_decode($Order_data->order_product)->order_qty;
        $order_product_id = json_decode($Order_data->order_product)->product_id;
        $price_type = $Order_data->price_type;
        $total_mrp = 0;
        foreach ($order_product_id as $key => $product_id) {
            $product_id_array = explode('_', $product_id);
            $c = count($product_id_array); 
            $product_data = Product::where('id',$product_id_array[$c-1])->first();
            $product_master_data = ProductMaster::where('name',$product_data->name)->first();
            if (strpos($product_id, 'combo')) {
                $combo_data = ProductCombo::where('id',explode('-', $product_id)[0])->first();
                $product['name'][] = $combo_data->product_combo_name;
                $product['img'][] = $product_data->photo;
                $product['order_qty'][] = $order_product_qty[$key];
                $product['price'][] = json_decode($Order_data->order_product)->per_price[$key];
                $product['sub_price'][] = json_decode($Order_data->order_product)->sub_price[$key];
                $mrp = 0;
                foreach (json_decode(json_decode($combo_data->product_list)->id) as $keyss => $valuess) {
                  $master = Product::where('id',$valuess)->first();
                  $master = ProductMaster::where('name',$master->name)->first();
                  if(isset($master->mrp)){
                    $mrp += $master->mrp*json_decode(json_decode($combo_data->product_list)->qty)[$keyss];
                  }
                }
                $total_mrp += $order_product_qty[$key]*$mrp;
            }else{
                $product['name'][] = $product_data->name;
                $product['img'][] = $product_data->img;
                $product['order_qty'][] = $order_product_qty[$key];
                if($price_type == 'Bulk Price'){
                    $product['price'][] = json_decode($Order_data->order_product)->per_price[$key];
                    $product['sub_price'][] = json_decode($Order_data->order_product)->sub_price[$key];
                    // $product['price'][] = $product_data->bulk_sale_price;
                    // $product['sub_price'][] = $order_product_qty[$key]*$product_data->bulk_sale_price;
                    if (!empty($product_master_data->mrp)) {
                        $total_mrp += $product_master_data->mrp * $order_product_qty[$key];
                    }else{
                        $total_mrp += $order_product_qty[$key]*$product_data->bulk_sale_price;
                    } 
                }else{
                    $product['price'][] = json_decode($Order_data->order_product)->per_price[$key];
                    $product['sub_price'][] = json_decode($Order_data->order_product)->sub_price[$key];
                    // $product['price'][] = $product_data->sale_price;    
                    // $product['sub_price'][] = $order_product_qty[$key]*$product_data->sale_price;  
                    if (!empty($product_master_data->mrp)) {
                        $total_mrp += $product_master_data->mrp * $order_product_qty[$key];
                    }else{
                        $total_mrp += $order_product_qty[$key]*$product_data->sale_price;  
                    }   
                } 
            }
            
                // $product['price'][] = json_decode($Order_data->order_product)->per_price[$key];
                // $product['sub_price'][] = json_decode($Order_data->order_product)->sub_price[$key];

        }
        // echo "<pre>"; print_r(compact('product')); echo "</pre>"; die('end of code');

        $Order_data->save_amt = $total_mrp - $Order_data->order_amt;
        $area = Area::where('id',$Order_data->customer->area_id)->first();
        $flat_no = '';
        $lane = '';
        if ($Order_data->customer->flat_no) {
            $flat_no = $Order_data->customer->flat_no.', ';
        }
        if ($Order_data->customer->lane) {
            $lane = $Order_data->customer->lane.', ';
        }
        $address = $flat_no.$Order_data->customer->building_name.', '.$lane.$area->name;

        $dynamic_invoice = '';
        // echo "<pre>"; print_r($Order_data->customer); echo "</pre>"; dd($Order_data->customer);
        $html='
        <style>
                        .page-break {
                            page-break-after: always;
                        }
                        .page { background-color: #c7b39b; /* background Color */ }
                            html{
                            width: 100%;
                            height: 100%;
                            padding: 0;
                            margin: 0;
                            }
                            /** Define the footer rules **/
                        footer {
                            position: fixed; 
                            bottom: 0cm; 
                            left: 0cm; 
                            right: 0cm;
                            height: 2cm;

                            /** Extra personal styles 
                            color: black;
                            text-align: center;
                            line-height: 2cm;**/
                        }
                        #section-content{
                            padding: 20px;
                        }
                        .last {
                            
                            float:right;
                            width: 350px;
                            height: 60px;
                            background-color:#009933;
                            color:#ffff;
                        }
                        .column4 {
                            float: left;
                            width: 30%;
                            padding: 0px;
                        }

                        .dot {
                            height: 250px;
                            width: 250px;
                            background-color: yellow;
                            display: inline-block;
                            border-radius: 120px;
                        }

                        .column {
                            float: left;
                            width: 33.33%;
                            padding: 10px;
                        }
                        /* Clearfix (clear floats) */
                        .row::after {
                            content: "";
                            clear: both;
                            display: table;
                        }   
                        * {
                            box-sizing: border-box;
                        } 
                        tr.borderOK{
                            border-bottom: 2px solid black;
                            font-size:11px;
                            font-weight:800;
                        }
                    </style>
                    <html>
                    <body >
                    <center>
                        <div style="font-size:30px;">
                            <center>
                            <div class="banner-content">
                                <h1 style="font-family: LeagueGothic;">Savita&apos;s Grocery</h1>
                            </div>
                            </center>
                        </div>
                        <table style="border-collapse:collapse;border:1px solid #000;width:700px;">
                            <tr style="border:1px solid #000;">
                                <td style=" text-align: left;padding: 4px;">Customer Name:&nbsp;'.$Order_data->customer->name.'</td>
                                <td style=" text-align: right;padding: 4px;">Whatsapp Number:&nbsp;'.$Order_data->customer->whatsapp_no.'</td>
                            </tr>
                            <tr>
                                <td colspan="2" style=" text-align: left;padding: 4px;">Address:&nbsp;'.$address.'</td>
                            </tr>
                        </table>
                        <table style="border-collapse:collapse;width:700px;border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;">
                            <tr>
                                <td style=" text-align: center;padding: 4px;"><b>Order Details</b></td>
                            </tr>
                        </table>
                        <table style="border-collapse:collapse;width:700px;border-left:1px solid #000;border-right:1px solid #000;">
                            <tr>
                                <td style=" text-align: left;padding: 4px;">Order No:&nbsp;<b>'.$Order_data->id.'</b></td>
                                <td style=" text-align: right;padding: 4px;">Date:&nbsp;<b>'.date("d/m/Y", strtotime($Order_data->order_date)).'</b></td>
                            </tr>
                        </table>
                        <table style="border-collapse:collapse;width:700px;">
                            <tr>
                                <td style="width:10%;border:1px solid #000; text-align: center;font-weight: bold;padding: 4px;">#</td>
                                <td style="width:60%;border:1px solid #000;text-align: center;font-weight: bold;padding: 4px;">Product name</td>
                                <td style="width:10%;border:1px solid #000;text-align: center;font-weight: bold;padding: 4px;">Qty</td>
                                <td style="width:20%;border:1px solid #000;text-align: center;font-weight: bold;padding: 4px;">Amount</td>
                            </tr>';
                            foreach ($product['name'] as $key => $value) {
                                $html .='<tr>
                                            <td style="width:10%;border:1px solid #000; text-align: center;padding: 4px;">'.($key+1).'</td>
                                            <td style="width:60%;border:1px solid #000;text-align: center;padding: 4px;">'.$value.'</td>
                                            <td style="width:10%;border:1px solid #000;text-align: center;padding: 4px;">'.$product['order_qty'][$key].'</td>
                                            <td style="width:20%;border:1px solid #000;text-align: center;padding: 4px;">'.$product['sub_price'][$key].'</td>
                                        </tr>';
                            }
                             $html .='
                            <tr>
                                <td  colspan="3" style="border:1px solid #000; text-align: right;padding: 4px;">Gross Total:</td>
                                <td style="border:1px solid #000;text-align: center;padding: 4px;">'.($Order_data->order_amt + $Order_data->discount_amount - $Order_data->delivery_amount).'</td>
                            </tr>
                            <tr>
                                <td  colspan="3" style="border:1px solid #000; text-align: right;padding: 4px;">Discount:</td>
                                <td style="border:1px solid #000;text-align: center;padding: 4px;">&nbsp;('.($Order_data->discount_amount).')</td>
                            </tr>
                            <tr>
                                <td  colspan="3" style="border:1px solid #000; text-align: right;padding: 4px;">Delivery Charges:</td>
                                <td style="border:1px solid #000;text-align: center;padding: 4px;">'.$Order_data->delivery_amount.'</td>
                            </tr>
                            <tr>
                                <td  colspan="3" style="border:1px solid #000; text-align: right;padding: 4px;"><b>Net Total:</b></td>
                                <td style="border:1px solid #000;text-align: center;padding: 4px;"><b>'.$Order_data->order_amt.'</b></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border:1px solid #000; text-align: center;padding: 4px;">Thank You for shopping at <b>Savita’s Grocery</b><br/>Now available Online at <a href="https://www.sgonline.in">https://www.sgonline.in</a> and on WhatsApp @ 9321504147.</td>
                            </tr>
                        </table>
                    </center>
            </body></html>';

            return view('invoice',compact('html','Order_data','address','product'));
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($html);
            return $pdf->stream();

    }
}
