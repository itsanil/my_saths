<?php

namespace App\Http\Controllers;

use App\Brand;
use App\ProductMaster;
use App\Product;
use App\HomeProduct;
use App\Stock;
use App\Tag;
use App\Promotion;
use App\ManageSgp;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Auth;
use Session;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Brand_list = Brand::all();
        return view('brand.index',compact('Brand_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:brands'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
       
        $product = new Brand();
        $product->name = $request['name'];
        $product->status = $request['status'];
        $product->save();
        return redirect('brand')->with(['success'=> 'Brand Added!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function getProductList($name)
    {
        $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        $brand_id = Brand::where('name',$name)->first();
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
        return view('brand.product_list',compact('product_list','name','brand_list','tag_list','cart_product_id_array','cart','cart_count','promotion_list','brand_tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $data = Brand::all();
        foreach ($data as $key => $value) {
            if($value->name == $request['name']){
                if ($value->id != $request['id']) {
                    return redirect('brand')->with(['error'=> 'Duplicate Record!!']);
                }
            }
        }
        
        $id = $request['id'];
        $count = Brand::where('id',$id)->count();
        if ($count > 0) {
            $brand = Brand::where('id',$id)->first();
            $update_product = HomeProduct::where('position',$brand->name)->update([
                   'position' => $request['name']
                ]);
            $brand->name = $request['name'];
            $brand->status = $request['status'];
            $brand->save();
            return redirect('brand')->with(['success'=> 'Brand Updated']);
        } else {
            return redirect('brand')->with(['error'=> 'something is wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
