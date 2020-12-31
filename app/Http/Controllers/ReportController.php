<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Brand;
use App\Product;
use App\ProductMaster;
use App\ProductRate;
use App\Stock;
use App\Refund;
use App\ProductSource;
use App\ProductCombo;
use Illuminate\Http\Request;
use App\Exports\StockReport;
use DataTables;
use DB;
use Response;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use Excel;


class ReportController extends Controller
{
    public function brandreport(){
    	return view('report.brand');
    }

    public function brandData(Request $request){
    	$brand_list = Brand::all();
    	$brand = array();
    	foreach ($brand_list as $key => $value) {
    		$brand['id'][] = $value->id;
    		$brand['name'][] = $value->name;
    		$brand['b2b_sells'][]  = 0;
            $brand['b2c_sells'][]  = 0;
            $brand['stock_amt'][]  = 0;
            $brand['sell_amt'][]  = 0;
            $brand['refund_amt'][]  = 0;
    	}
		 $StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        if ($StartDate == 'Invalid date' || $StartDate == 'all') {
            $order_list = Order::where('payment_status',1)->where('order_status','approved')->get();
        }else{
        	$order_list = Order::where('payment_status',1)->where('order_status','approved')->whereDate('created_at','>=',$StartDate)->whereDate('created_at','<=',$EndDate)->orderBy('id','DESC')->get();
        }
        $total_stock_amt = 0;
        $total_stock_refund_amt = 0;
        foreach ($order_list as $key => $order) {
          	foreach (json_decode($order->order_product)->product_id as $keys => $product_id) {
              	//now get the name of product
              	$product_datas = Product::where('id',$product_id)->first();
              	$product_name = $product_datas->name;
              	$product_master_data = ProductMaster::with('brand')->where('name',$product_name)->first();
                foreach ($brand['id'] as $keyss => $valuess) {
                    if($product_master_data->brand_id == $valuess){
                        if ($order->price_type == 'Sale Price') {
                            $brand['b2c_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                            $brand['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                        } else {
                            $brand['b2b_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                            $brand['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                        }
                        // echo "<pre>"; print_r($order->created_at); echo "</pre>"; die('end of code');
                        $product_data = ProductRate::where('product_id',$product_id)->orderBy('id', 'DESC')->first();
                        // $product_data = ProductRate::where('product_id',$product_id)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
                		$brand['stock_amt'][$keyss] += json_decode($order->order_product)->order_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);

                    }
                }
            
        	}
        }
        foreach ($order_list as $key => $order) {
            $stock_refund_list = Refund::where('order_id',$order->id)->first();
            if ($stock_refund_list) {
                foreach (json_decode($stock_refund_list->refund_product)->product_id as $keys => $product_id) {
                	//now get the name of product
	              	$product_datas = Product::where('id',$product_id)->first();
	              	$product_name = $product_datas->name;
	              	$product_master_data = ProductMaster::with('brand')->where('name',$product_name)->first();
	                foreach ($brand['id'] as $keyss => $valuess) {
	                    if($product_master_data->brand_id == $valuess){
	                        if ($order->price_type == 'Sale Price') {
	                            $brand['b2c_sells'][$keyss]  -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys];
	                            $brand['sell_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->sub_price[$keys];
	                        } else {
	                            $brand['b2b_sells'][$keyss]  -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys];
	                            $brand['sell_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->sub_price[$keys];
	                        }
	                        $product_data = ProductRate::where('product_id',$product_id)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
	                        // echo "<pre>"; print_r($product_data); echo "</pre>"; die('end of code');
	                		$brand['refund_amt'][$keyss] += json_decode($stock_refund_list->refund_product)->refund_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);

                		}
                	}
            	}
          
        	}
        
      	}

          	// echo "<pre>"; print_r($brand); echo "</pre>"; die('end of code');
       
        $brand_list = array();
        foreach ($brand['name'] as $key => $value) {
        	$brand_list[$key]['brand'] = $brand['name'][$key];
            $brand_list[$key]['order_amt'] = $brand['sell_amt'][$key];
        	$brand_list[$key]['id'] = $brand['id'][$key];
        	$brand_list[$key]['revenue'] = $brand['sell_amt'][$key] - $brand['stock_amt'][$key] - $brand['refund_amt'][$key];
        }
        // echo "<pre>"; print_r($brand_list); echo "</pre>"; die('end of code');
        return DataTables::of($brand_list)
        ->make(true);
    }

    public function productreport(){
    	return view('report.product');
    }

    public function productData(Request $request){
    	$product_master_list = ProductMaster::all();
    	$product_array = array();
    	foreach ($product_master_list as $key => $value) {
    		$product_array['id'][] = $value->id;
    		$product_array['name'][] = $value->name;
    		$product_array['b2b_sells'][]  = 0;
            $product_array['b2c_sells'][]  = 0;
            $product_array['stock_amt'][]  = 0;
            $product_array['sell_amt'][]  = 0;
            $product_array['refund_amt'][]  = 0;
    	}
		 $StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        if ($StartDate == 'Invalid date' || $StartDate == 'all') {
            $order_list = Order::where('payment_status',1)->where('order_status','approved')->get();
        }else{
        	$order_list = Order::where('payment_status',1)->where('order_status','approved')->whereDate('created_at','>=',$StartDate)->whereDate('created_at','<=',$EndDate)->orderBy('id','DESC')->get();
        }
        $total_stock_amt = 0;
        $total_stock_refund_amt = 0;
        foreach ($order_list as $key => $order) {
          	foreach (json_decode($order->order_product)->product_id as $keys => $product_id) {
              	//now get the name of product
              	$product_datas = Product::where('id',$product_id)->first();
              	$product_name = $product_datas->name;
                foreach ($product_array['name'] as $keyss => $valuess) {
                    if($product_name == $valuess){
                        if ($order->price_type == 'Sale Price') {
                            $product_array['b2c_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                            $product_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                        } else {
                            $product_array['b2b_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                            $product_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                        }
                        if (count(explode('combo',$product_id)) > 1) {
                          $product_data->purchase_price = 0;
                          $combo_data = ProductCombo::where('id',explode('-', $product_id)[0])->first();
                          foreach (json_decode(json_decode($combo_data->product_list)->id) as $keysss => $valuesss) {
                            $p_data = ProductRate::where('product_id',$valuesss)->orderBy('id', 'DESC')->first();
                            // $p_data = ProductRate::where('product_id',$valuesss)->where('created_at', '>=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
                            $product_data->purchase_price += $p_data->purchase_price * json_decode(json_decode($combo_data->product_list)->qty)[$keysss];
                          }
                          $product_data->transport_expence = 0;
                        } else {
                            // $product_data = ProductRate::where('product_id',$product_id)->where('created_at', '>=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
                            $product_data = ProductRate::where('product_id',$product_id)->orderBy('id', 'DESC')->first();
                        }
                       
                		$product_array['stock_amt'][$keyss] += json_decode($order->order_product)->order_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);

                    }
                }
            
        	}
        }
        foreach ($order_list as $key => $order) {
            $stock_refund_list = Refund::where('order_id',$order->id)->first();
            if ($stock_refund_list) {
                foreach (json_decode($stock_refund_list->refund_product)->product_id as $keys => $product_id) {
                	//now get the name of product
	              	$product_datas = Product::where('id',$product_id)->first();
	              	$product_name = $product_datas->name;
	                foreach ($product_array['name'] as $keyss => $valuess) {
                    	if($product_name == $valuess){
	                        if ($order->price_type == 'Sale Price') {
	                            $product_array['b2c_sells'][$keyss]  -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys];
	                            $product_array['sell_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->sub_price[$keys];
	                        } else {
	                            $product_array['b2b_sells'][$keyss]  -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys];
	                            $product_array['sell_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->sub_price[$keys];
	                        }
	                        // $product_data = ProductRate::where('product_id',$product_id)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
                            $product_data = ProductRate::where('product_id',$product_id)->orderBy('id', 'DESC')->first();
	                		$product_array['refund_amt'][$keyss] += json_decode($stock_refund_list->refund_product)->refund_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);

                		}
                	}
            	}
          
        	}
        
      	}

          	// echo "<pre>"; print_r($brand); echo "</pre>"; die('end of code');
       
        $product = array();
        foreach ($product_array['name'] as $key => $value) {
            if($product_array['sell_amt'][$key] != 0){
            	$product[$key]['name'] = $product_array['name'][$key];
                $product[$key]['order_amt'] = $product_array['sell_amt'][$key];
            	$product[$key]['id'] = $product_array['id'][$key];
            	$product[$key]['revenue'] = $product_array['sell_amt'][$key] - $product_array['stock_amt'][$key] - $product_array['refund_amt'][$key];
            }
        }
        return DataTables::of($product)
        ->make(true);
    }

    public function customerreport(){
    	return view('report.customer');
    }

    public function customerData(Request $request){
    	$customer_list = Customer::all();
    	$customer_array = array();
    	foreach ($customer_list as $key => $value) {
    		$customer_array['id'][] = $value->id;
    		$customer_array['name'][] = $value->name;
    		$customer_array['b2b_sells'][]  = 0;
            $customer_array['b2c_sells'][]  = 0;
            $customer_array['stock_amt'][]  = 0;
            $customer_array['sell_amt'][]  = 0;
            $customer_array['refund_amt'][]  = 0;
            $customer_array['discount_amt'][]  = 0;
            $customer_array['delivery_amt'][]  = 0;
    	}
		 $StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        if ($StartDate == 'Invalid date' || $StartDate == 'all') {
            $order_list = Order::where('payment_status',1)->where('order_status','approved')->get();
        }else{
        	$order_list = Order::where('payment_status',1)->where('order_status','approved')->whereDate('created_at','>=',$StartDate)->whereDate('created_at','<=',$EndDate)->orderBy('id','DESC')->get();
        }
        $total_stock_amt = 0;
        $total_stock_refund_amt = 0;
        foreach ($order_list as $key => $order) {
        	foreach ($customer_array['id'] as $keyss => $valuess) {
                if($order->customer_id == $valuess){
                	foreach (json_decode($order->order_product)->product_id as $keys => $product_id) {
                		if ($order->price_type == 'Sale Price') {
                            $customer_array['b2c_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                            $customer_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                        } else {
                            $customer_array['b2b_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                            $customer_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                        }
                        $product_data = ProductRate::where('product_id',$product_id)->orderBy('id', 'DESC')->first();
                        // $product_data = ProductRate::where('product_id',$product_id)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
                		$customer_array['stock_amt'][$keyss] += json_decode($order->order_product)->order_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                	}
                	// $customer_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                	$customer_array['discount_amt'][$keyss] += $order->discount_amount;
                	// $customer_array['sell_amt'][$keyss] += $order->order_amt;
                	$customer_array['delivery_amt'][$keyss] += $order->delivery_amount;
                }
            }
        }
        foreach ($order_list as $key => $order) {
            $stock_refund_list = Refund::where('order_id',$order->id)->first();
            if ($stock_refund_list) {
            	foreach ($customer_array['id'] as $keyss => $valuess) {
	                if($order->customer_id == $valuess){
	                	foreach (json_decode($stock_refund_list->refund_product)->product_id as $keys => $product_id) {
	                		if ($order->price_type == 'Sale Price') {
	                            $customer_array['b2c_sells'][$keyss]  -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys];
	                            $customer_array['sell_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->sub_price[$keys];
	                        } else {
	                            $customer_array['b2b_sells'][$keyss]  -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys];
	                            $customer_array['sell_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->sub_price[$keys];
	                        }
	                        $product_data = ProductRate::where('product_id',$product_id)->orderBy('id', 'DESC')->first();
                            // $product_data = ProductRate::where('product_id',$product_id)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
	                		$customer_array['refund_amt'][$keyss] += json_decode($stock_refund_list->refund_product)->refund_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
	                	}
	                }
	            }
          
        	}
        
      	}

        $product = array();
        foreach ($customer_array['name'] as $key => $value) {
        	if($customer_array['sell_amt'][$key] != 0){
	        	$product[$key]['name'] = $customer_array['name'][$key];
	        	$product[$key]['id'] = $customer_array['id'][$key];
	        	$product[$key]['order_amt'] = $customer_array['sell_amt'][$key] + $customer_array['delivery_amt'][$key] - $customer_array['discount_amt'][$key];
	        	$product[$key]['revenue'] = $customer_array['sell_amt'][$key] + $customer_array['delivery_amt'][$key] - $customer_array['stock_amt'][$key] - $customer_array['refund_amt'][$key] - $customer_array['discount_amt'][$key];
        	}
        }
        return DataTables::of($product)
        ->make(true);
    }

    public function buildingreport(){
    	return view('report.building');
    }

    public function buildingData(Request $request){
    	$building_list = Customer::groupBy('building_name')->pluck('building_name');
    	$building_array = array();
    	foreach ($building_list as $key => $value) {
    		$building_array['name'][] = $value;
    		$building_array['b2b_sells'][]  = 0;
            $building_array['b2c_sells'][]  = 0;
            $building_array['stock_amt'][]  = 0;
            $building_array['sell_amt'][]  = 0;
            $building_array['refund_amt'][]  = 0;
            $building_array['discount_amt'][]  = 0;
            $building_array['delivery_amt'][]  = 0;
    	}
		$StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        if ($StartDate == 'Invalid date' || $StartDate == 'all') {
            $order_list = Order::with('customer')->where('payment_status',1)->where('order_status','approved')->get();
        }else{
        	$order_list = Order::with('customer')->where('payment_status',1)->where('order_status','approved')->whereDate('created_at','>=',$StartDate)->whereDate('created_at','<=',$EndDate)->orderBy('id','DESC')->get();
        }
        $total_stock_amt = 0;
        $total_stock_refund_amt = 0;
        foreach ($order_list as $key => $order) {
        	foreach ($building_array['name'] as $keyss => $valuess) {
                if($order->customer->building_name == $valuess){
                	foreach (json_decode($order->order_product)->product_id as $keys => $product_id) {
                		if ($order->price_type == 'Sale Price') {
                            $building_array['b2c_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                            $building_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                        } else {
                            $building_array['b2b_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                            $building_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                        }
                        $product_data = ProductRate::where('product_id',$product_id)->orderBy('id', 'DESC')->first();
                        // $product_data = ProductRate::where('product_id',$product_id)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
                		$building_array['stock_amt'][$keyss] += json_decode($order->order_product)->order_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                	}
                	// $building_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                	$building_array['discount_amt'][$keyss] += $order->discount_amount;
                	// $building_array['sell_amt'][$keyss] += $order->order_amt;
                	$building_array['delivery_amt'][$keyss] += $order->delivery_amount;
                }
            }
        }
        foreach ($order_list as $key => $order) {
            $stock_refund_list = Refund::where('order_id',$order->id)->first();
            if ($stock_refund_list) {
            	foreach ($building_array['name'] as $keyss => $valuess) {
	                if($order->customer->building_name == $valuess){
	                	foreach (json_decode($stock_refund_list->refund_product)->product_id as $keys => $product_id) {
	                		if ($order->price_type == 'Sale Price') {
	                            $building_array['b2c_sells'][$keyss]  -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys];
	                            $building_array['sell_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->sub_price[$keys];
	                        } else {
	                            $building_array['b2b_sells'][$keyss]  -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys];
	                            $building_array['sell_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->sub_price[$keys];
	                        }
	                        $product_data = ProductRate::where('product_id',$product_id)->orderBy('id', 'DESC')->first();
                            // $product_data = ProductRate::where('product_id',$product_id)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
	                		$building_array['stock_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
	                	}
	                }
	            }
          
        	}
        
      	}

        $product = array();
        foreach ($building_array['name'] as $key => $value) {
        	if($building_array['sell_amt'][$key] != 0){
	        	$product[$key]['name'] = $building_array['name'][$key];
	        	$product[$key]['order_amt'] = $building_array['sell_amt'][$key] + $building_array['delivery_amt'][$key] - $building_array['discount_amt'][$key];
	        	$product[$key]['revenue'] =$building_array['sell_amt'][$key] + $building_array['delivery_amt'][$key] - $building_array['discount_amt'][$key]  - $building_array['stock_amt'][$key];
        	}
        }
        return DataTables::of($product)
        ->make(true);
    }

    public function getreportData(Request $request){
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
        $StartDate = $request['selectedStartDate'];
        $EndDate = $request['selectedEndDate'];
        if ($StartDate == 'Invalid date' || $StartDate == 'all') {
            $order_list = Order::with('customer')->where('payment_status',1)->where('order_status','approved')->get();
        }else{
            $order_list = Order::with('customer')->where('payment_status',1)->where('order_status','approved')->whereDate('created_at','>=',$StartDate)->whereDate('created_at','<=',$EndDate)->orderBy('id','DESC')->get();
        }
        $total_order = 0;
        $total_discount = 0;
        $total_delivery = 0;
        $Total_revenue = 0;
        $total_stock_amt = 0;
        foreach ($order_list as $key => $order) {
            $total_order += $order->order_amt;
            $total_discount += $order->discount_amount;
            $total_delivery += $order->delivery_amount;

            foreach (json_decode($order->order_product)->product_id as $keys => $value) {
                if(strpos('combo', $value)){
                    $combo_data = ProductCombo::where('id',explode('-', $value)[0])->first();
                      foreach (json_decode(json_decode($combo_data->product_list)->id) as $keysss => $valuesss) {
                        $p_data = ProductRate::where('product_id',$valuesss)->first();
                        // $p_data = ProductRate::where('product_id',$valuesss)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
                        $product_data->purchase_price += $p_data->purchase_price * json_decode(json_decode($combo_data->product_list)->qty)[$keysss];
                      }
                      $product_data->transport_expence = 0;
                  }else{
                        $product_data = ProductRate::where('product_id',$value)->orderBy('id', 'DESC')->first();
                        // $product_data = ProductRate::where('product_id',$value)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();

                  }
                  if(!isset($product_data->purchase_price)){
                    // echo "<pre>"; print_r($order->created_at['date']); echo "</pre>"; die('end of code');
                    foreach ($order->created_at as $a => $b) {
                        if($a == 'date'){
                            $product_data = ProductRate::where('product_id',$value)->orderBy('id', 'DESC')->first();
                        }
                    }
                  }
                $total_stock_amt += json_decode($order->order_product)->order_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                
              }
        }
        foreach ($order_list as $key => $order) {
            $stock_refund_list = Refund::where('order_id',$order->id)->first();
            if ($stock_refund_list) {
                $total_order -= $stock_refund_list->refund_amount_amt;
                foreach (json_decode($stock_refund_list->refund_product)->product_id as $keys => $value) {
                    $product_data = ProductRate::where('product_id',$value)->orderBy('id', 'DESC')->first();
                    // $product_data = ProductRate::where('product_id',$value)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
                    $total_stock_amt -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                    
                }
            }
        }
        $Total_revenue = $total_order + $total_delivery - $total_discount - $total_stock_amt;
        $Total_revenue = number_format((float)$Total_revenue, 2, '.', '');
        $total_stock_amt = number_format((float)$total_stock_amt, 2, '.', '');
        return Response::json(compact('total_stock_amt','Total_revenue','total_order','total_discount','total_delivery'));
    }

    public function getPurchasereportData(Request $request){
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
        $StartDate = $request['selectedStartDate'];
        $EndDate = $request['selectedEndDate'];
        if ($StartDate == 'Invalid date' || $StartDate == 'all') {
            $purchase_data = Product::get()->unique('stock_order_id');
        }else{
            $purchase_data = Product::whereDate('created_at','>=',$StartDate)->whereDate('created_at','<=',$EndDate)->get()->unique('stock_order_id');
        }
        $total_order = 0;
        $total_transport_amt = 0;
        foreach ($purchase_data as $key => $order) {
            $total_order += $order->total_order_amt;
            $total_transport_amt += $order->transport_expence;
        }
        $total_order = number_format((float)$total_order, 2, '.', '');
        $total_transport_amt = number_format((float)$total_transport_amt, 2, '.', '');
        return Response::json(compact('total_order','total_transport_amt'));
    }

    public function productPricereport(){
        $product_list = Product::get()->unique('name');
        foreach ($product_list as $key => $value) {
            $product_master = ProductMaster::where('name',$value->name)->first();
            $value->mrp = $product_master->mrp; 
        }
         // echo "<pre>"; print_r($product_list); echo "</pre>"; die('end of code');
       
       return view('report.product_price',compact('product_list')); 
    }

    public function ProductPriceData(Request $request){
        $order_list = Product::where('name',$request['name'])->orderBy('id','DESC')->get();
        return Response::json(array('data'=>$order_list));
    }

    public function distributerReport(){
        $distributer_list = ProductSource::all();
        foreach ($distributer_list as $key => $value) {
            $amt = 0;
            $purchase_data = Product::where('product_source_id',$value->id)->get()->unique('stock_order_id');
            foreach ($purchase_data as $keys => $values) {
                $amt += $values->total_order_amt;
            }
            // echo "<pre>"; print_r($purchase_data); echo "</pre>"; die('end of code');
            $value->purchase_amt = $amt; 
        }
         // echo "<pre>"; print_r($product_list); echo "</pre>"; die('end of code');
       
       return view('report.distributer_report',compact('distributer_list')); 

    }

    public function distributerData(Request $request){
        $building_list = Customer::groupBy('building_name')->pluck('building_name');
        $building_array = array();
        foreach ($building_list as $key => $value) {
            $building_array['name'][] = $value;
            $building_array['b2b_sells'][]  = 0;
            $building_array['b2c_sells'][]  = 0;
            $building_array['stock_amt'][]  = 0;
            $building_array['sell_amt'][]  = 0;
            $building_array['refund_amt'][]  = 0;
            $building_array['discount_amt'][]  = 0;
            $building_array['delivery_amt'][]  = 0;
        }
        $StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        if ($StartDate == 'Invalid date' || $StartDate == 'all') {
            $order_list = Order::with('customer')->where('payment_status',1)->where('order_status','approved')->get();
        }else{
            $order_list = Order::with('customer')->where('payment_status',1)->where('order_status','approved')->whereDate('created_at','>=',$StartDate)->whereDate('created_at','<=',$EndDate)->orderBy('id','DESC')->get();
        }
        $total_stock_amt = 0;
        $total_stock_refund_amt = 0;
        foreach ($order_list as $key => $order) {
            foreach ($building_array['name'] as $keyss => $valuess) {
                if($order->customer->building_name == $valuess){
                    foreach (json_decode($order->order_product)->product_id as $keys => $product_id) {
                        if ($order->price_type == 'Sale Price') {
                            $building_array['b2c_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                            $building_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                        } else {
                            $building_array['b2b_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                            $building_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                        }
                        $product_data = ProductRate::where('product_id',$product_id)->orderBy('id', 'DESC')->first();
                        // $product_data = ProductRate::where('product_id',$product_id)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
                        $building_array['stock_amt'][$keyss] += json_decode($order->order_product)->order_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                    }
                    // $building_array['sell_amt'][$keyss] += json_decode($order->order_product)->sub_price[$keys];
                    $building_array['discount_amt'][$keyss] += $order->discount_amount;
                    // $building_array['sell_amt'][$keyss] += $order->order_amt;
                    $building_array['delivery_amt'][$keyss] += $order->delivery_amount;
                }
            }
        }
        foreach ($order_list as $key => $order) {
            $stock_refund_list = Refund::where('order_id',$order->id)->first();
            if ($stock_refund_list) {
                foreach ($building_array['name'] as $keyss => $valuess) {
                    if($order->customer->building_name == $valuess){
                        foreach (json_decode($stock_refund_list->refund_product)->product_id as $keys => $product_id) {
                            if ($order->price_type == 'Sale Price') {
                                $building_array['b2c_sells'][$keyss]  -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys];
                                $building_array['sell_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->sub_price[$keys];
                            } else {
                                $building_array['b2b_sells'][$keyss]  -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys];
                                $building_array['sell_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->sub_price[$keys];
                            }
                            $product_data = ProductRate::where('product_id',$product_id)->orderBy('id', 'DESC')->first();
                            // $product_data = ProductRate::where('product_id',$product_id)->where('created_at', '<=', Carbon::parse($order->created_at)->toDateTimeString())->orderBy('id', 'DESC')->first();
                            $building_array['stock_amt'][$keyss] -= json_decode($stock_refund_list->refund_product)->refund_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                        }
                    }
                }
          
            }
        
        }

        $product = array();
        foreach ($building_array['name'] as $key => $value) {
            if($building_array['sell_amt'][$key] != 0){
                $product[$key]['name'] = $building_array['name'][$key];
                $product[$key]['order_amt'] = $building_array['sell_amt'][$key] + $building_array['delivery_amt'][$key] - $building_array['discount_amt'][$key];
                $product[$key]['revenue'] =$building_array['sell_amt'][$key] + $building_array['delivery_amt'][$key] - $building_array['discount_amt'][$key]  - $building_array['stock_amt'][$key];
            }
        }
        $distributer_list = ProductSource::all();
        foreach ($distributer_list as $key => $value) {
            $amt = 0;
            if ($StartDate == 'Invalid date' || $StartDate == 'all') {
                $purchase_data = Product::where('product_source_id',$value->id)->get()->unique('stock_order_id');
            }else{
                $purchase_data = Product::where('product_source_id',$value->id)->whereDate('created_at','>=',$StartDate)->whereDate('created_at','<=',$EndDate)->get()->unique('stock_order_id');
            }
            
            foreach ($purchase_data as $keys => $values) {
                $amt += $values->total_order_amt;
            }
            // echo "<pre>"; print_r($purchase_data); echo "</pre>"; die('end of code');
            $value->purchase_amt = $amt; 
        }
        return DataTables::of($distributer_list)
        ->addColumn('action', function ($distributer_list) {
                return '<a class="btn btn-primary btn-sm"  href="'.url('distributor-report').'/'.$distributer_list->id.'">
                                  <i class="fas fa-eye">
                                  </i>
                            </a>
                            ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getDistributerData($id){
        return view('report.distributer_detail',compact('id')); 
    }

    public function discountReport(){
        $product_master_list = ProductMaster::where('status','Active')->get();
        foreach ($product_master_list as $key => $value) {
            $data = Product::where('name',$value->name)->orderBy('id','DESC')->first();
            if ($data) {
                $value->sale = $data->sale_price;
                if ($value->mrp) {
                    $value->percentage = number_format((float)($value->mrp - $data->sale_price)*100/$value->mrp, 2, '.', '');
                } else {
                    $value->percentage = null;
                }
            } else {
                $value->sale = null;
                $value->percentage = null;
            }
        }
        return view('report.discount_report',compact('product_master_list'));
        // echo "<pre>"; print_r($product_master_list); echo "</pre>"; die('end of code');
    }

    public function stockInWorth(){
        $new_stock_list = Stock::with('product')->get();
        $ProductMaster = ProductMaster::where('status','Active')->get();
        $stock_list = array();
         $c = 0;
         $total_purchase_price = 0;
        foreach ($ProductMaster as $keys => $values) {
            $purchase_qty = 0;
            $available_qty = 0;
            foreach ($new_stock_list as $key => $value) {
                if ($value->product->name == $values->name) {
                    $purchase_qty += $value->purchase_quantity;
                    $available_qty += $value->available_quantity;
                } 
            }
            if($available_qty != 0){
               $data = Product::where('name',$values->name)->orderBy('id','DESC')->first();
               $stock_list[$c]['name'] =$values->name;
               $stock_list[$c]['purchase_quantity'] =$purchase_qty;
               $stock_list[$c]['available_quantity'] =$available_qty;
               $stock_list[$c]['purchase_price'] =$data->purchase_price;
               $stock_list[$c]['total_purchase_price'] =$available_qty * $data->purchase_price;
               $total_purchase_price += $available_qty * $data->purchase_price;
               $c++;
            }
        }
        return view('report.stockInWorth',compact('stock_list','total_purchase_price'));
    }

    public function orderSearch(){
        if (empty($_GET)) {
            $product_list = ProductMaster::where('status','Active')->orderBy('name','ASC')->get();
            return view('report.order_search',compact('product_list'));
        } else {
            $product_list = ProductMaster::where('status','Active')->where('name',$_GET['name'])->orderBy('name','ASC')->first();
            $combo_list = ProductCombo::where('status','Active')->where('product_combo_name',$_GET['name'])->first();
            if ($product_list || $combo_list) {
                $product_name = $_GET['name'];
                return view('report.customer_order',compact('product_name'));
            } else {
                return redirect('order_search')->with(array('error'=>'No Product Found!!!'));
                $product_list = ProductMaster::where('status','Active')->orderBy('name','ASC')->get();
                return view('report.order_search',compact('product_list'));
            }
        }
        
        
    }

    public function orderSearchData(Request $request){
        $StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        $order_data = array();
        if ($StartDate == 'Invalid date' || $StartDate == 'all') {
            $order_list = Order::where('payment_status',1)->where('order_status','approved')->get();
        }else{
            $order_list = Order::where('payment_status',1)->where('order_status','approved')->whereDate('created_at','>=',$StartDate)->whereDate('created_at','<=',$EndDate)->orderBy('id','DESC')->get();
        }
        $a = 0;
        foreach ($order_list as $key => $value) {
            $product_id = json_decode($value->order_product)->product_id;
            foreach ($product_id as $k => $p_id) {
                if (count(explode('combo',$p_id)) > 1) {
                    $product_data = ProductCombo::findorfail(explode('-', $p_id)[0]);
                    $product_data->name = $product_data->product_combo_name;
                    // echo "<pre>"; print_r($product_data); echo "</pre>"; die('end of code');
                } else {
                    $product_data = Product::findorfail($p_id);
                }
                $Customer_data = Customer::findorfail($value->customer_id);
                if(($product_data->name == $request['name']) && !empty($Customer_data)){
                    $order_data[$a]['customer_name'] = $Customer_data->name;
                    $order_data[$a]['customer_mobile'] = $Customer_data->whatsapp_no;
                    $order_data[$a]['order_no'] = $value->id;
                    $order_data[$a]['order_qty'] = json_decode($value->order_product)->order_qty[$k];
                    $order_data[$a]['per_price'] = json_decode($value->order_product)->per_price[$k];
                    $order_data[$a]['sub_price'] = json_decode($value->order_product)->sub_price[$k];
                    $order_data[$a]['order_date'] = $value->order_date;
                    $a++;
                }
            }

        }
        return DataTables::of($order_data)
        ->make(true);
    }

    public function stockworthReport(){
        return Excel::download(new StockReport(), 'stock-report.xlsx');
    }
}
