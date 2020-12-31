<?php

namespace App\Http\Controllers;

use App\Wishlist;
use App\Customer;
use App\ProductMaster;
use App\Brand;
use App\Tag;
use Illuminate\Http\Request;
use Auth;
use Response;
use Session;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_id = Customer::where('user_id',Auth::User()->id)->first();
        $data = Wishlist::where('customer_id',$customer_id->id)->first();
        $product_master_list = ProductMaster::with('brand')->where('status','Active')->get();
        $brand_list = Brand::where('status','Active')->get();
        $Tag_List = Tag::where('status','Active')->orderBy('name','ASC')->get();
        $cart = Session::get('cart_product');
        $cart_product_id_array = explode(',', $cart);
        if (isset($cart_product_id_array) && $cart_product_id_array[0] != '') {
            $cart_count =  count($cart_product_id_array);
          } else {
            $cart_count = 0;
          }
        // return view('wishlist.form',compact('data','product_master_list','brand_list','Tag_List'));
        return view('wishlist.form',compact('data','product_master_list','brand_list','Tag_List','cart','cart_product_id_array','cart_count'));
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
        
        $product_id_array = array();
        $product_id_array['product_id'] = $request['product_id'];
        $product_id_array['qty'] = $request['qty'];
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
        $customer_id = Customer::where('user_id',Auth::User()->id)->first();
        if($request['type'] == 'add'){
                $data = new Wishlist();
                $data->customer_id = $customer_id->id;
                $data->product_id = json_encode($product_id_array);
                $data->save();
                return Response::json(array('success' => true,'message'=>'Your wishlist has been saved.'));
        }else{
                $data = Wishlist::where('customer_id',$customer_id->id)->first();
                $data->product_id = json_encode($product_id_array);
                $data->save();
                return Response::json(array('success' => true,'message'=>'Your wishlist has been saved.'));
        }
    }

    public function view(){
        $wishlist_data = Wishlist::with('customer')->get();

        return view('wishlist.index',compact('wishlist_data'));
    }

    public function getData(Request $request){
        $datas = Wishlist::find($request['id']);
        $data = array();
        foreach (json_decode($datas->product_id)->product_id as $key => $value) {
            $product = ProductMaster::find($value);
            $data[$key]['name'] = $product->name;
            $data[$key]['qty'] = json_decode($datas->product_id)->qty[$key];
        }
        return Response::json(array('data'=>$data));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        //
    }
}
