<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;
use App\ProductMaster;
use App\ManageSgp;
use App\Product;
use App\Stock;
use App\Promotion;
use App\Brand;
use Session;

class CategoryController extends Controller
{
    public $successStatus = 200;

    public function getCategoryBanner()
    {
    	// echo "<pre>"; print_r('anil'); echo "</pre>"; die('end of code');
        $tag_data = Tag::where('photo','!=','')->where('status','Active')->orderBy('name', 'ASC')->get();
        return response()->json(['success'=>'1','message'=>'tag listed successfully.','data'=>$tag_data], $this->successStatus);
    }

    public function getBrandBanner()
    {
    	$brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get()->toArray();
        return response()->json(['success'=>'1','message'=>'tag listed successfully.','data'=>$brand_list], $this->successStatus);
    }

    public function gettagproduct(){
    	$Tag_data = Tag::where('id',$_GET['id'])->first();
        if ($Tag_data) {
            $product_master_id = json_decode($Tag_data->product_master_id);
        } else {
            $product_master_id = array();
        }
        $product_list = ProductMaster::whereIn('id',$product_master_id)->orderBy('name', 'ASC')->where('status','Active')->get();
        $sgp = ManageSgp::orderBy('id','DESC')->first();
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

        $tag_data = Tag::where('photo','!=','')->where('status','Active')->orderBy('name', 'ASC')->get();
        // echo "<pre>"; print_r($product_list->toArray()); echo "</pre>"; die('end of code');
        return response()->json(['success'=>'1','message'=>'tag listed successfully.','data'=>$product_list], $this->successStatus);
        // return view('brand.product_list',compact('product_list','name','brand_list','tag_list','cart','cart_count','cart_product_id_array','promotion_list','tag_data'));
    }

     public function getBrandProductList()
    {
        $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        $brand_id = Brand::where('id',$_GET['id'])->first();
        $sgp = ManageSgp::orderBy('id','DESC')->first();
        $product_list = ProductMaster::where('brand_id',$brand_id->id)->orderBy('name', 'ASC')->where('status','Active')->get();
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
          $brand_tag =array();
          foreach ($tag_list as $key => $value) {
            $Tag_data = Tag::where('name',$value)->first();
            $product_master_id = json_decode($Tag_data->product_master_id);
            $product_lists = ProductMaster::where('brand_id',$brand_id->id)->orderBy('name', 'ASC')->whereIn('id',$product_master_id)->where('status','Active')->get();
            if($product_lists->count() > 0){
                $brand_tag[] = $value;
            }
          }
        $promotion_list = Promotion::with('brand')->where('status','Active')->orderBy('id', 'DESC')->get();
        return response()->json(['success'=>'1','message'=>'tag listed successfully.','data'=>$product_list], $this->successStatus);
        // return view('brand.product_list',compact('product_list','name','brand_list','tag_list','cart_product_id_array','cart','cart_count','promotion_list','brand_tag'));
    }
}
