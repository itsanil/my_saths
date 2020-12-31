<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Product;
use App\Order;
use App\ProductRate;
use App\ProductCombo;
use App\ProductMaster;
use App\Refund;
use Illuminate\Http\Request;
use DataTables;
use Carbon;
use Response;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $new_stock_list = Stock::with('product')->get();
        $ProductMaster = ProductMaster::where('status','Active')->get();
        $stock_list = array();
         $c = 0;
        foreach ($ProductMaster as $keys => $values) {
            $purchase_qty = 0;
            $available_qty = 0;
            foreach ($new_stock_list as $key => $value) {
                if ($value->product->name == $values->name) {
                    $purchase_qty += $value->purchase_quantity;
                    $available_qty += $value->available_quantity;
                } 
            }
            if($purchase_qty != 0){
               
               $stock_list[$c]['name'] =$values->name;
               $stock_list[$c]['purchase_quantity'] =$purchase_qty;
               $stock_list[$c]['available_quantity'] =$available_qty;
               $c++;
            }
        }
        return view('stock.index',compact('stock_list'));
    }


    public function data(Request $request){
        $StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        if ($StartDate == 'all') {
            $stock_list = Stock::with('product')->get();
        } else {
            // $StartDate =  Carbon::createFromFormat('Y-m-d', $StartDate)->toDateTimeString();
            // $EndDate =  Carbon::createFromFormat('Y-m-d', $EndDate)->toDateTimeString();
            $stock_list = Stock::with('product')->whereBetween('created_at',[$StartDate,$EndDate])->get();
        }
        $new_stock_list = Stock::with('product')->get();
        $ProductMaster = ProductMaster::all();
        $stock_list = array();
        foreach ($ProductMaster as $keys => $values) {
            $purchase_qty = 0;
            $available_qty = 0;
            foreach ($new_stock_list as $key => $value) {
                if ($value->product->name == $values->name) {
                    $purchase_qty += $value->purchase_quantity;
                    $available_qty += $value->available_quantity;
                } 
            }
           $stock_list[$keys]['name'] =$values->name;
           $stock_list[$keys]['purchase_quantity'] =$purchase_qty;
           $stock_list[$keys]['available_quantity'] =$available_qty;
        }
        // echo "<pre>"; print_r($stock_list); echo "</pre>"; die('end of code');
        return DataTables::of($stock_list)
        // ->addColumn('sr_no', function ($stock_list) {
        //     return $stock_list->id;
        // })
        ->addColumn('name', function ($stock_list) {
            // echo "<pre>"; print_r($stock_list); echo "</pre>"; die('end of code');
            return $stock_list['name'] ;
        })
        ->addColumn('purchase_quantity', function ($stock_list) {
            // echo "<pre>"; print_r($stock_list); echo "</pre>"; die('end of code');
            return $stock_list['purchase_quantity'] ;
        })
        ->addColumn('available_quantity', function ($stock_list) {
            // echo "<pre>"; print_r($stock_list); echo "</pre>"; die('end of code');
            return $stock_list['available_quantity'] ;
        })
        // ->addColumn('purchase_price', function ($stock_list) {
        //     return $stock_list->product->purchase_price;
        // })
        // ->addColumn('transport_price', function ($stock_list) {
        //     return $stock_list->product->transport_expence;
        // })
        // ->addColumn('total_purchase_amt', function ($stock_list) {
        //     return $stock_list->product->order_amount ;
        // })
        // ->addColumn('status', function ($stock_list) {
        //     if ($stock_list->available_quantity == 0) {
        //         return '<td><span class="badge badge-danger">Not Available</span></td>';
        //     } else {
        //         return '<td><span class="badge badge-success">Available</span></td>';
        //     }
        // })
        // ->rawColumns(['status'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function report(){

        $order_list = Order::where('payment_status',1)->get();
        $product_list = Product::all();
        $product  = array();
        foreach ($product_list as $key => $value) {
            $product['name'][]  = $value->name;
            $product['id'][]  = $value->id;
            $product['b2b_sells'][]  = 0;
            $product['b2c_sells'][]  = 0;
        }
            $total_order = $order_list->count();
            $total_stock_amt = 0;
            $total_stock_refund_amt = 0;
            $total_discount = 0;
        $total_delivery = 0;
            foreach ($order_list as $key => $order) {
                $total_discount += $order->discount_amount;
                $total_delivery += $order->delivery_amount;
              foreach (json_decode($order->order_product)->product_id as $keys => $value) {
                foreach ($product['id'] as $keyss => $valuess) {
                    if($value == $valuess){
                        if ($order->price_type == 'Sale Price') {
                            $product['b2c_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                        } else {
                            $product['b2b_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                        }
                    }
                }
                if (count(explode('combo',$value)) > 1) {
                  $product_data->purchase_price = 0;
                  $combo_data = ProductCombo::where('id',explode('-', $value)[0])->first();
                  foreach (json_decode(json_decode($combo_data->product_list)->id) as $keysss => $valuesss) {
                    $p_data = ProductRate::where('product_id',$valuesss)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                    $product_data->purchase_price += $p_data->purchase_price * json_decode(json_decode($combo_data->product_list)->qty)[$keysss];
                  }
                  $product_data->transport_expence = 0;
                } else {
                  if (count(explode('_',$value)) > 1) {
                    $value = max(explode('_',$value)); 

                  }
                  $product_data = ProductRate::where('product_id',$value)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                  
                }
                if (!isset($product_data->purchase_price)) {
                  $product_data = Product::where('id',$value)->first();
                } 
                $total_stock_amt += json_decode($order->order_product)->order_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                
              }
            }
            foreach ($order_list as $key => $order) {
                $stock_refund_list = Refund::where('order_id',$order->id)->first();
                if ($stock_refund_list) {
                    foreach (json_decode($stock_refund_list->refund_product)->product_id as $keys => $value) {
                        foreach ($product['id'] as $keyss => $valuess) {
                            if($value == $valuess){
                                if ($order->price_type == 'Sale Price') {
                                    $product['b2c_sells'][$keyss]  -= json_decode($order->order_product)->order_qty[$keys];
                                } else {
                                    $product['b2b_sells'][$keyss]  -= json_decode($order->order_product)->order_qty[$keys];
                                }
                            }
                        }
                        $product_data = ProductRate::where('product_id',$value)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                        $total_stock_refund_amt += json_decode($stock_refund_list->refund_product)->refund_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                        
                    }
                }
              
            }
            //B2C Sales
            $B2C_order_list = Order::where('price_type','Sale Price')->where('payment_status',1)->get();
            $total_b2c_order = $B2C_order_list->count();
            $b2c_sells = 0;
            foreach ($B2C_order_list as $key => $value) {
                $B2C_refund_list = Refund::where('order_id',$value->id)->first();
                if ($B2C_refund_list) {
                   $b2c_sells += $value->order_amt - $B2C_refund_list->refund_amount;
                }else{
                    $b2c_sells += $value->order_amt;
                }
            }
            //B2B Sales
            $B2B_order_list = Order::where('price_type','Bulk Price')->where('payment_status',1)->get();
            $total_b2b_order = $B2B_order_list->count();
            $b2b_sells = 0;
            foreach ($B2B_order_list as $key => $value) {
                $B2b_refund_list = Refund::where('order_id',$value->id)->first();
                if ($B2b_refund_list) {
                    $b2b_sells += $value->order_amt - $B2C_refund_list->refund_amount;
                }else{
                    $b2b_sells += $value->order_amt;
                }
            }
            if ($total_stock_refund_amt > $total_stock_amt) {
                $total_stock_amt = $total_stock_refund_amt - $total_stock_amt;
            }else{
                $total_stock_amt = $total_stock_amt - $total_stock_refund_amt;
            }
            $total_stock_amt = number_format((float)$total_stock_amt, 2, '.', '');
            $Total_revenue = $b2c_sells + $b2b_sells + $total_delivery  - $total_stock_amt - $total_discount;
            $Total_revenue = number_format((float)$Total_revenue, 2, '.', '');
        return view('revenue',compact('total_stock_amt','b2c_sells','b2b_sells','Total_revenue','total_order','total_b2c_order','total_b2b_order','product'));
    }

    public function getDashboardData(Request $request){
        $StartDate = $request['selectedStartDate'];
        $EndDate = $request['selectedEndDate'];
        $product_list = Product::all();
        $product  = array();
        foreach ($product_list as $key => $value) {
            $product['name'][]  = $value->name;
            $product['id'][]  = $value->id;
            $product['b2b_sells'][]  = 0;
            $product['b2c_sells'][]  = 0;
        }
        // echo "<pre>"; print_r($StartDate); echo "</pre>"; die('end of code');
        if ($StartDate == 'Invalid date') {
            $order_list = Order::where('payment_status',1)->get();
            $total_order = $order_list->count();
            $total_stock_amt = 0;
            $total_stock_refund_amt = 0;
            $total_discount = 0;
            $total_delivery = 0;
            foreach ($order_list as $key => $order) {
                $total_discount += $order->discount_amount;
                $total_delivery += $order->delivery_amount;
              foreach (json_decode($order->order_product)->product_id as $keys => $value) {
                foreach ($product['id'] as $keyss => $valuess) {
                    if($value == $valuess){
                        if ($order->price_type == 'Sale Price') {
                            $product['b2c_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                        } else {
                            $product['b2b_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                        }
                    }
                }
                if (count(explode('combo',$value)) > 1) {
                  $product_data->purchase_price = 0;
                  $combo_data = ProductCombo::where('id',explode('-', $value)[0])->first();
                  foreach (json_decode(json_decode($combo_data->product_list)->id) as $keysss => $valuesss) {
                    $p_data = ProductRate::where('product_id',$valuesss)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                    $product_data->purchase_price += $p_data->purchase_price * json_decode(json_decode($combo_data->product_list)->qty)[$keysss];
                  }
                  $product_data->transport_expence = 0;
                } else {
                  if (count(explode('_',$value)) > 1) {
                    $value = max(explode('_',$value)); 

                  }
                  $product_data = ProductRate::where('product_id',$value)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                  
                }
                if (!isset($product_data->purchase_price)) {
                  $product_data = Product::where('id',$value)->first();
                } 
                $total_stock_amt += json_decode($order->order_product)->order_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                
              }
            }
            foreach ($order_list as $key => $order) {
                $stock_refund_list = Refund::where('order_id',$order->id)->first();
                if ($stock_refund_list) {
                    foreach (json_decode($stock_refund_list->refund_product)->product_id as $keys => $value) {
                        foreach ($product['id'] as $keyss => $valuess) {
                            if($value == $valuess){
                                if ($order->price_type == 'Sale Price') {
                                    $product['b2c_sells'][$keyss]  -= json_decode($order->order_product)->order_qty[$keys];
                                } else {
                                    $product['b2b_sells'][$keyss]  -= json_decode($order->order_product)->order_qty[$keys];
                                }
                            }
                        }
                        $product_data = ProductRate::where('product_id',$value)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                        $total_stock_refund_amt += json_decode($stock_refund_list->refund_product)->refund_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                        
                    }
                }
              
            }
            //B2C Sales
            $B2C_order_list = Order::where('price_type','Sale Price')->where('payment_status',1)->get();
            $total_b2c_order = $B2C_order_list->count();
            $b2c_sells = 0;
            foreach ($B2C_order_list as $key => $value) {
                $B2C_refund_list = Refund::where('order_id',$value->id)->first();
                if ($B2C_refund_list) {
                   $b2c_sells += $value->order_amt - $B2C_refund_list->refund_amount;
                }else{
                    $b2c_sells += $value->order_amt;
                }
            }
            //B2B Sales
            $B2B_order_list = Order::where('price_type','Bulk Price')->where('payment_status',1)->get();
            $total_b2b_order = $B2B_order_list->count();
            $b2b_sells = 0;
            foreach ($B2B_order_list as $key => $value) {
                $B2b_refund_list = Refund::where('order_id',$value->id)->first();
                if ($B2b_refund_list) {
                    $b2b_sells += $value->order_amt - $B2C_refund_list->refund_amount;
                }else{
                    $b2b_sells += $value->order_amt;
                }
            }
            if ($total_stock_refund_amt > $total_stock_amt) {
                $total_stock_amt = $total_stock_refund_amt - $total_stock_amt;
            }else{
                $total_stock_amt = $total_stock_amt - $total_stock_refund_amt;
            }
            $total_stock_amt = number_format((float)$total_stock_amt, 2, '.', '');
            $Total_revenue = $b2c_sells + $b2b_sells + $total_delivery  - $total_stock_amt - $total_discount;
            $Total_revenue = number_format((float)$Total_revenue, 2, '.', '');
            return Response::json(compact('total_stock_amt','b2c_sells','b2b_sells','Total_revenue','total_order','total_b2c_order','total_b2b_order','product'));
        } else {
            $order_list = Order::where('payment_status',1)->whereBetween('order_date',[$StartDate,$EndDate])->get();
            $total_order = $order_list->count();
            $total_stock_amt = 0;
            $total_stock_refund_amt = 0;
            $total_discount = 0;
            $total_delivery = 0;
            foreach ($order_list as $key => $order) {
                $total_discount += $order->discount_amount;
                $total_delivery += $order->delivery_amount;
              foreach (json_decode($order->order_product)->product_id as $keys => $value) {
                foreach ($product['id'] as $keyss => $valuess) {
                    if($value == $valuess){
                        if ($order->price_type == 'Sale Price') {
                            $product['b2c_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                        } else {
                            $product['b2b_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                        }
                    }
                }
                if (count(explode('combo',$value)) > 1) {
                  $product_data->purchase_price = 0;
                  $combo_data = ProductCombo::where('id',explode('-', $value)[0])->first();
                  foreach (json_decode(json_decode($combo_data->product_list)->id) as $keysss => $valuesss) {
                    $p_data = ProductRate::where('product_id',$valuesss)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                    $product_data->purchase_price += $p_data->purchase_price * json_decode(json_decode($combo_data->product_list)->qty)[$keysss];
                  }
                  $product_data->transport_expence = 0;
                } else {
                  if (count(explode('_',$value)) > 1) {
                    $value = max(explode('_',$value)); 

                  }
                  $product_data = ProductRate::where('product_id',$value)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                  
                }
                if (!isset($product_data->purchase_price)) {
                  $product_data = Product::where('id',$value)->first();
                } 
                $total_stock_amt += json_decode($order->order_product)->order_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                
              }
            }
            foreach ($order_list as $key => $order) {
                $stock_refund_list = Refund::where('order_id',$order->id)->first();
                if ($stock_refund_list) {
                    foreach (json_decode($stock_refund_list->refund_product)->product_id as $keys => $value) {
                        foreach ($product['id'] as $keyss => $valuess) {
                            if($value == $valuess){
                                if ($order->price_type == 'Sale Price') {
                                    $product['b2c_sells'][$keyss]  -= json_decode($order->order_product)->order_qty[$keys];
                                } else {
                                    $product['b2b_sells'][$keyss]  -= json_decode($order->order_product)->order_qty[$keys];
                                }
                            }
                        }
                        $product_data = ProductRate::where('product_id',$value)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                        $total_stock_refund_amt += json_decode($stock_refund_list->refund_product)->refund_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                        
                    }
                }
              
            }
            //B2C Sales
            $B2C_order_list = Order::where('price_type','Sale Price')->whereBetween('order_date',[$StartDate,$EndDate])->where('payment_status',1)->get();
            $total_b2c_order = $B2C_order_list->count();
            $b2c_sells = 0;
            foreach ($B2C_order_list as $key => $value) {
                $B2C_refund_list = Refund::where('order_id',$value->id)->first();
                if ($B2C_refund_list) {
                   $b2c_sells += $value->order_amt - $B2C_refund_list->refund_amount;
                }else{
                    $b2c_sells += $value->order_amt;
                }
            }
            //B2B Sales
            $B2B_order_list = Order::where('price_type','Bulk Price')->whereBetween('order_date',[$StartDate,$EndDate])->where('payment_status',1)->get();
            $total_b2b_order = $B2B_order_list->count();
            $b2b_sells = 0;
            foreach ($B2B_order_list as $key => $value) {
                $B2b_refund_list = Refund::where('order_id',$value->id)->first();
                if ($B2b_refund_list) {
                    $b2b_sells += $value->order_amt - $B2C_refund_list->refund_amount;
                }else{
                    $b2b_sells += $value->order_amt;
                }
            }
            if ($total_stock_refund_amt > $total_stock_amt) {
                $total_stock_amt = $total_stock_refund_amt - $total_stock_amt;
            }else{
                $total_stock_amt = $total_stock_amt - $total_stock_refund_amt;
            }
            $total_stock_amt = number_format((float)$total_stock_amt, 2, '.', '');
            $Total_revenue = $b2c_sells + $b2b_sells + $total_delivery  - $total_stock_amt - $total_discount;
            $Total_revenue = number_format((float)$Total_revenue, 2, '.', '');
            return Response::json(compact('total_stock_amt','b2c_sells','b2b_sells','Total_revenue','total_order','total_b2c_order','total_b2b_order','product'));
        }
    }


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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
