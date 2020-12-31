<?php

namespace App\Http\Controllers;

use App\ProductCombo;
use App\ProductMaster;
use App\Product;
use App\Tag;
use App\Stock;
use App\Brand;
use App\Promotion;
use App\ManageSgp;
use App\HomeProduct;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Session;

class ProductComboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $combo_list = ProductCombo::all();
        $product_master_list = ProductMaster::with('brand')->where('status','Active')->get();
        $product_master_list = Product::with('ProductSource')->where('status',1)->orderBy('id','DESC')->get()->unique('name');
       return view('product_combo.index',compact('combo_list','product_master_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_master_list = Product::with('ProductSource')->where('status',1)->orderBy('id','DESC')->get()->unique('name');
        return view('product_combo.create',compact('product_master_list'));
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
            'product_combo_name' => ['required', 'string', 'max:255', 'unique:product_combos'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $product_photo_url = '';
        if($request->file('photo')){
            $product_photo= $request->file('photo');
            $photo_name = time().round(1000,9999).'.'.$product_photo->getClientOriginalExtension();
            $product_photo->move(storage_path('app/combo/'), $photo_name);
            $product_photo_url = 'app/combo/'.$photo_name;
        }
        $list = array();
        $list['id'] = json_encode($request['id']);
        $list['qty'] = json_encode($request['qty']);
        $product = new ProductCombo();
        $product->product_combo_name = $request['product_combo_name'];
        $product->product_list = json_encode($list);
        $product->combo_price = $request['price'];
        $product->status = $request['status'];
        $product->photo = $product_photo_url;
        $product->save();
        return redirect('products-combo')->with(['success'=> 'Product Added!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCombo  $productCombo
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCombo $productCombo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCombo  $productCombo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $combo_data = ProductCombo::findOrFail($id);
        $id = json_decode(json_decode($combo_data->product_list)->id);
        foreach ($id as $key => $value) {
          $data = Product::findOrFail($id);
          $product_name[] = $data[0]->name;
        }
        $qty = json_decode(json_decode($combo_data->product_list)->qty);
        $product_master_list = Product::with('ProductSource')->where('status',1)->orderBy('id','DESC')->get()->unique('name');
        return view('product_combo.edit',compact('product_master_list','combo_data','id','qty','product_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCombo  $productCombo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCombo $productCombo,$id)
    {
        $data = ProductCombo::all();
        foreach ($data as $key => $value) {
            if($value->product_combo_name == $request['product_combo_name']){
                if ($value->id != $id) {
                    return redirect('products-combo')->with(['error'=> 'Duplicate Record!!']);
                }
            }
        }
        $data = ProductCombo::findOrFail($id);
        if ($data) {
            $data = ProductCombo::where('id',$id)->first();
            if($request->file('photo')){
                $product_photo= $request->file('photo');
                $photo_name = time().round(1000,9999).'.'.$product_photo->getClientOriginalExtension();
                $product_photo->move(storage_path('app/combo/'), $photo_name);
                $tag_photo_url = 'app/combo/'.$photo_name;
                $data->photo = $tag_photo_url;
            }
            $list = array();
            $list['id'] = json_encode($request['id']);
            $list['qty'] = json_encode($request['qty']);    
            $data->product_combo_name = $request['product_combo_name'];
            $data->product_list = json_encode($list);
            $data->combo_price = $request['price'];
            $data->status = $request['status'];
            $data->save();
            return redirect('products-combo')->with(['success'=> 'Product Updated']);
        } else {
            return redirect('products-combo')->with(['error'=> 'something is wrong!']);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCombo  $productCombo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCombo $productCombo)
    {
        //
    }

    public function combo(){
        $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        $data = HomeProduct::where('position','Combo Offer')->orderBy('id','ASC')->first();
        if ($data) {
            $product_master_id = json_decode($data->product_master_id);
        } else {
            $product_master_id = array();
        }
        $product_list = ProductCombo::orderBy('product_combo_name', 'ASC')->where('status','Active')->get();
        // echo "<pre>"; print_r($product_master_id); echo "</pre>"; die('end of code');
        $sgp = ManageSgp::orderBy('id','DESC')->first();
        foreach ($product_list as $key => $value) {
                // $data['product_type'][] = 'combo';
                $value->name = $value->product_combo_name;
                $mrp = 0;
                $status = true;
                foreach (json_decode(json_decode($value->product_list)->id) as $keyss => $valuess) {
                  $master = Product::where('id',$valuess)->first();
                  $master = ProductMaster::where('name',$master->name)->first();
                  if(isset($master->mrp)){
                    $mrp += $master->mrp*json_decode(json_decode($value->product_list)->qty)[$keyss];
                  }
                //   dd($mrp);
                  $stock_data = Stock::where('product_id',$valuess)->where('available_quantity','>=',json_decode(json_decode($value->product_list)->qty)[$keyss])->first();
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
                if ($sgp) {
                  if (round($value->combo_price + ($mrp * $sgp->value/100)) > $mrp) {
                    $value->sale_price = $mrp;
                  } else {
                    $value->sale_price = round($value->combo_price + ($mrp * $sgp->value/100));
                  }
                } else {
                  $value->sale_price = $value->combo_price;
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
        $name = 'Combo Offer';
        $tag_data = Tag::where('photo','!=','')->where('status','Active')->orderBy('name', 'ASC')->get();
        // echo "<pre>"; print_r($product_list); echo "</pre>"; die('end of code');
        return view('brand.product_list',compact('product_list','name','brand_list','tag_list','cart','cart_count','cart_product_id_array','promotion_list','tag_data','name'));
    }
}
