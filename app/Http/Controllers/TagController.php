<?php

namespace App\Http\Controllers;

use App\Tag;
use App\ProductMaster;
use App\Product;
use App\Stock;
use App\Brand;
use App\Promotion;
use App\ManageSgp;
use App\ProductCombo;
use Illuminate\Http\Request;
use Validator;
use Redirect;
use Response;
use Session;
use Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response


     */

    // public function __construct()
    // {
    //     $session_data = array();
    // }


    public function index()
    {
        $Tag_list = Tag::all();
        $product_master_list = ProductMaster::with('brand')->get();
        $combo_list = ProductCombo::all();
        return view('tag.index',compact('Tag_list','product_master_list','combo_list'));
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
    public function data(Request $request)
    {
        $brand_list = Brand::all();
        $brand_id = Brand::where('name',$request['brand'])->first();
        if ($request['tag'] == 'all') {
           $product_list = ProductMaster::where('brand_id',$brand_id->id)->orderBy('name', 'ASC')->where('status','Active')->get();
        } else {
            $Tag_data = Tag::where('name',$request['tag'])->first();
            $product_master_id = json_decode($Tag_data->product_master_id);
            $product_list = ProductMaster::where('brand_id',$brand_id->id)->orderBy('name', 'ASC')->whereIn('id',$product_master_id)->where('status','Active')->get();
        }
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
        if ($product_list->count() > 0) {
            return Response::json(array('success' => true,'data'=>$product_list));
        } else {
            return Response::json(array('success' => false));
        }
        
        
    }

    public function cart(Request $request)
    {
        $product_id = $request['product_id'];
        $task = $request['task'];
        // $user_id = Auth::User()->id;
        // $cart = Session::get('cart_'.Auth::User()->id);
        $cart_product_id_array = explode(',', $product_id);
        $html = '';
        foreach (array_unique(array_filter($cart_product_id_array)) as $key => $value) {
           $html .= $value.',';
        }
        Session::put('cart_product', rtrim($html,','));
        return response()->json(array('product'=>rtrim($html,','),'count'=>count(array_unique(array_filter($cart_product_id_array)))));
    }


    
    public function getProductList($name)
    {
        $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        $Tag_data = Tag::where('name',$name)->first();
        if ($Tag_data) {
            $product_master_id = json_decode($Tag_data->product_master_id);
        } else {
            $product_master_id = array();
        }
        $combo_id_array = array();
        foreach ($product_master_id as $key => $i) {
          if(strpos($i, '-combo')){
            array_push($combo_id_array,explode('-',$i)[0]);
          }
        }
        $combo_product_list = ProductCombo::whereIn('id',$combo_id_array)->orderBy('product_combo_name', 'ASC')->where('status','Active')->get();
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
        foreach ($combo_product_list as $key => $value) {
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

        $tag_data = Tag::where('photo','!=','')->where('status','Active')->orderBy('name', 'ASC')->get();
        return view('brand.product_list',compact('product_list','name','brand_list','tag_list','cart','cart_count','cart_product_id_array','promotion_list','tag_data','combo_product_list'));
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:tags'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
        if($request->file('photo')){
            $product_photo= $request->file('photo');
            $photo_name = time().round(1000,9999).'.'.$product_photo->getClientOriginalExtension();
            $product_photo->move(storage_path('app/tag/'), $photo_name);
            $tag_photo_url = 'app/tag/'.$photo_name;
        }
        $Tag = new Tag();
        $Tag->name = $request['name'];
        $Tag->product_master_id = json_encode($request['product_master_id']);
        $Tag->status = $request['status'];
        $Tag->photo = $tag_photo_url;
        $Tag->save();
        return redirect('tag')->with(['success'=> 'Tags Added!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        
        $Tag_data = Tag::where('id',$id)->first();
        $product_master_list = ProductMaster::with('brand')->get();
        $combo_list = ProductCombo::all();
        return view('tag.edit',compact('Tag_data','product_master_list','combo_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $data = Tag::all();
        foreach ($data as $key => $value) {
            if($value->name == $request['name']){
                if ($value->id != $request['id']) {
                    return redirect('tag')->with(['error'=> 'Duplicate Record!!']);
                }
            }
        }
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
        $id = $request['id'];
        $count = Tag::where('id',$id)->count();

        if ($count > 0) {
            $data = Tag::where('id',$id)->first();
            if($request->file('photo')){
                $product_photo= $request->file('photo');
                $photo_name = time().round(1000,9999).'.'.$product_photo->getClientOriginalExtension();
                $product_photo->move(storage_path('app/tag/'), $photo_name);
                $tag_photo_url = 'app/tag/'.$photo_name;
                $data->photo = $tag_photo_url;
            }
            if ($request['product_master_id']) {
                $data->name = $request['name'];
                $data->product_master_id = json_encode($request['product_master_id']);
                $data->status = $request['status'];
                $data->save();
            }else{
                $data->name = $request['name'];
                $data->status = $request['status'];
                $data->save();
            }
            return redirect('tag')->with(['success'=> 'Tag Updated']);
        } else {
            return redirect('brand')->with(['error'=> 'something is wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
