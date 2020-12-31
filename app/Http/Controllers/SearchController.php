<?php

namespace App\Http\Controllers;

use App\ProductMaster;
use App\Brand;
use App\Product;
use App\Stock;
use App\Promotion;
use App\ProductCombo;
use App\Tag;
use App\ManageSgp;
use Illuminate\Http\Request;
use Session;
use Response;

class SearchController extends Controller
{
    public function index(Request $request)
    {
           	$search = $request->get('term');
          	$filter_search = $request->get('filter');
          	// echo "<pre>"; print_r(); echo "</pre>"; die('end of code');
     		if ($filter_search == 'Brand') {
          		$result = Brand::where('name', 'LIKE', '%'. $search. '%')->where('status', 'Active')->groupBy('name')->pluck('name');
     		} else {
          		$result = ProductMaster::where('name', 'LIKE', '%'. $search. '%')->where('status', 'Active')->get();
        foreach ($result as $key => $value) {
        	 $cart = Session::get('cart_product');
           	$cart_product_id_array = explode(',', $cart);
           	// echo "<pre>"; print_r($cart_product_id_array); echo "</pre>"; die('end of code');
           $product_data = Product::where('name',$value->name)->orderBy('id','DESC')->first();
           if ($product_data) {
           	if (in_array($product_data->id, $cart_product_id_array)) {
             	$value->cart = true;
             } else {
             $value->cart = false;
             }
            $stock_data = Stock::where('product_id',$product_data->id)->where('available_quantity','!=',0)->first();
            if ($stock_data) {
                $value->product_id = $product_data->id;
            } else {
                $value->product_id = 0;
            }
            $value->sale_price = $product_data->sale_price;
           } else {
            $value->sale_price = '';
           }
           
           

        }
        $result_brand = Brand::where('name', 'LIKE', '%'. $search. '%')->where('status', 'Active')->get();
        foreach ($result_brand as $key => $value) {
          $value->type = 'brand';
          // echo "<pre>"; print_r($value); echo "</pre>"; die('end of code');
        }

        $result_combo = ProductCombo::where('product_combo_name', 'LIKE', '%'. $search. '%')->where('status', 'Active')->get();
        foreach ($result_combo as $key => $value) {
          $value->type = 'combo';
          $cart = Session::get('cart_product');
            $cart_product_id_array = explode(',', $cart);
            $value->name = $value->product_combo_name;
            // echo "<pre>"; print_r($cart_product_id_array); echo "</pre>"; die('end of code');
           $product_data = ProductCombo::where('product_combo_name',$value->name)->orderBy('id','DESC')->first();
           if ($product_data) {
            if (in_array($product_data->id.'-combo', $cart_product_id_array)) {
              $value->cart = true;
             } else {
             $value->cart = false;
             }
            $mrp = 0;
            $status = true;
            foreach (json_decode(json_decode($value->product_list)->id) as $keyss => $valuess) {
              $master = Product::where('id',$valuess)->first();
              $master = ProductMaster::where('name',$master->name)->first();
              if(isset($master->mrp)){
                $mrp += $master->mrp*json_decode(json_decode($value->product_list)->qty)[$keyss];
              }
              $pro_id = Product::where('name',$master->name)->orderBy('id','DESC')->pluck('id');
              $avail_qty = 0;
              foreach ($pro_id as $i => $id) {
                $stock = Stock::where('product_id',$id)->orderBy('id','DESC')->first();
                $avail_qty += $stock->available_quantity;
              }
              if($avail_qty/json_decode(json_decode($value->product_list)->qty)[$keyss] < 0){
                $status = false;
              }
            }
            if ($status) {
              $value->product_id = $value->id.'-combo';
            } else {
              $value->product_id = 0;
            }
            
            $value->sale_price = $product_data->combo_price;
           } else {
            $value->sale_price = '';
           }
        }
     		}
          return response()->json(array('product'=>$result,'brand'=>$result_brand,'result_combo'=>$result_combo));
           
    } 

    public function searchdata(Request $request){
      if($request['filter'] == 'Brand'){
        $result = Brand::where('name', 'LIKE', '%'. $request['search']. '%')->where('status', 'Active')->first();
        if ($result) {
          return Response::json(array('success' => 'brand','data'=>$result->name));
        } else {
          return Response::json(array('success' => false));
        }
      }

    }

     public function getProductList($name)
       {
        $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        $tags_name = array();
        $Tag_data = Tag::all();
        $search_array = explode(" ",strtolower($name));
        $sgp = ManageSgp::orderBy('id','DESC')->first();
        foreach ($Tag_data as $key => $value) {
          foreach ($search_array as $keys => $values) {
            if(substr_count(strtolower(str_replace("_", " ", $value->name)),strtolower($values)) > 0){
              $tags_name[] = $value->name;
            }
          }
        }
        // $releted_product_list = array();
        if(!empty($tags_name)){
          $Tag_data = Tag::where('name',$tags_name[0])->first();
        // echo "<pre>"; print_r($tags_name); echo "</pre>"; die('end of code');
        if ($Tag_data) {
            $product_master_id = json_decode($Tag_data->product_master_id);
        } else {
            $product_master_id = array();
        }
        $releted_product_list = ProductMaster::whereIn('id',$product_master_id)->orderBy('name', 'ASC')->where('status','Active')->get();
        foreach ($releted_product_list as $key => $value) {
           $product_data = Product::where('name',$value->name)->orderBy('id','DESC')->first();
           if ($product_data) {
            $stock_data = Stock::where('product_id',$product_data->id)->where('available_quantity','!=',0)->first();
            if ($stock_data) {
                $value->product_id = $product_data->id;
            } else {
                $value->product_id = 0;
            }
            if ($sgp && $value->mrp) {
              if (round($product_data->sale_price + ($value->mrp * $sgp->value/100)) > $value->mrp) {
                $value->sale_price = $value->mrp;
              } else {
                $value->sale_price = round($product_data->sale_price + ($value->mrp * $sgp->value/100));
              }
            } else {
              $value->sale_price = $product_data->sale_price;
            }
           } else {
            $value->sale_price = '';
           }
        }
        }
        
        $product_list = ProductMaster::where('name', 'LIKE', '%'. $name. '%')->orderBy('name', 'ASC')->where('status','Active')->get();
        // $Tag_list = Tag::where('status','Active')->pluck('name');
        foreach ($product_list as $key => $value) {
           $product_data = Product::where('name',$value->name)->orderBy('id','DESC')->first();
           if ($product_data) {
            $stock_data = Stock::where('product_id',$product_data->id)->where('available_quantity','!=',0)->first();
            if ($stock_data) {
                $value->product_id = $product_data->id;
            } else {
                $value->product_id = 0;
            }
            if ($sgp && $value->mrp) {
              if (round($product_data->sale_price + ($value->mrp * $sgp->value/100)) > $value->mrp) {
                $value->sale_price = $value->mrp;
              } else {
                $value->sale_price = round($product_data->sale_price + ($value->mrp * $sgp->value/100));
              }
            } else {
              $value->sale_price = $product_data->sale_price;
            }
           } else {
            $value->sale_price = '';
           }
        }
        $cart = Session::get('cart_product');
        $cart_product_id_array = explode(',', $cart);
        if (isset($cart_product_id_array) && $cart_product_id_array[0] != '') {
            $cart_count =  count($cart_product_id_array);
          } else {
            $cart_count = 0;
          }
        $promotion_list = Promotion::with('brand')->where('status','Active')->orderBy('id', 'DESC')->get();

        if($product_list->count() == 0){
          $product_list = ProductCombo::where('product_combo_name', 'LIKE', '%'. $name. '%')->orderBy('product_combo_name', 'ASC')->where('status','Active')->get();
        // $Tag_list = Tag::where('status','Active')->pluck('name');
        foreach ($product_list as $key => $value) {
          $value->name = $value->product_combo_name;
          $value->img = $value->photo;
           $product_data = ProductCombo::where('product_combo_name',$value->name)->orderBy('id','DESC')->first();
           if ($product_data) {
            $mrp = 0;
            $status = true;
            foreach (json_decode(json_decode($value->product_list)->id) as $keyss => $valuess) {
              $master = Product::where('id',$valuess)->first();
              $master = ProductMaster::where('name',$master->name)->first();
              if(isset($master->mrp)){
                $mrp += $master->mrp*json_decode(json_decode($value->product_list)->qty)[$keyss];
              }
              $pro_id = Product::where('name',$master->name)->orderBy('id','DESC')->pluck('id');
              $avail_qty = 0;
              foreach ($pro_id as $i => $id) {
                $stock = Stock::where('product_id',$id)->orderBy('id','DESC')->first();
                $avail_qty += $stock->available_quantity;
              }
              if($avail_qty/json_decode(json_decode($value->product_list)->qty)[$keyss] < 0){
                $status = false;
              }
            }
            if ($status) {
              $value->product_id = $value->id.'-combo';
            } else {
              $value->product_id = 0;
            }
            $value->mrp = $mrp;
            if ($sgp && $value->mrp) {
              if (round($product_data->combo_price + ($value->mrp * $sgp->value/100)) > $value->mrp) {
                $value->sale_price = $value->mrp;
              } else {
                $value->sale_price = round($product_data->combo_price + ($value->mrp * $sgp->value/100));
              }
            } else {
              $value->sale_price = $product_data->combo_price;
            }
           } else {
            $value->sale_price = '';
           }
        }
        }
        $tag_data = Tag::where('photo','!=','')->where('status','Active')->orderBy('name', 'ASC')->get();
        // echo "<pre>"; print_r($product_list); echo "</pre>"; die('end of code');
        return view('brand.product_list',compact('product_list','name','brand_list','tag_list','cart','cart_count','cart_product_id_array','promotion_list','tag_data','releted_product_list'));
    }

    public function error(){
        $cart = Session::get('cart_product');
        $cart_product_id_array = explode(',', $cart);
        if (isset($cart_product_id_array) && $cart_product_id_array[0] != '') {
            $cart_count =  count($cart_product_id_array);
          } else {
            $cart_count = 0;
          }
        $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        return view('error.404',compact('tag_list','brand_list','cart','cart_count','cart_product_id_array'));
    }
}
