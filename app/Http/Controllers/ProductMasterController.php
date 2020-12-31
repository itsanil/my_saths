<?php

namespace App\Http\Controllers;

use App\ProductMaster;
use App\Product;
use App\Brand;
use Illuminate\Http\Request;
use Redirect;
use Storage;
use Illuminate\Support\Facades\Validator;

class ProductMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_list = ProductMaster::all();
        $Brand_list = Brand::all();
        return view('product_master',compact('product_list','Brand_list'));
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
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:product_masters'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $product_photo_url = '';
        if($request->file('Photo')){
            $product_photo= $request->file('Photo');
            $photo_name = time().round(1000,9999).'.'.$product_photo->getClientOriginalExtension();
            $product_photo->move(storage_path('app/product/'), $photo_name);
            $product_photo_url = 'app/product/'.$photo_name;
        }
        // echo "<pre>"; print_r($request->file('img')); echo "</pre>"; die('end of code');
        $product = new ProductMaster();
        $product->name = $request['name'];
        $product->brand_id = $request['brand_id'];
        $product->mrp = $request['mrp'];
        $product->status = $request['status'];
        $product->photo = $product_photo_url;
        $product->save();
        return redirect('products')->with(['success'=> 'Product Added!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function show(ProductMaster $productMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductMaster $productMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductMaster $productMaster)
    {
        $data = ProductMaster::all();
        foreach ($data as $key => $value) {
            if($value->name == $request['name']){
                if ($value->id != $request['id']) {
                    return redirect('products')->with(['error'=> 'Duplicate Record!!']);
                }
            }
        }
        
        $id = $request['id'];
        $count = ProductMaster::where('id',$id)->count();
        if ($count > 0) {
            $product = ProductMaster::where('id',$id)->first();
            
            if($request->file('Photo')){
                $product_photo= $request->file('Photo');
                $photo_name = time().round(1000,9999).'.'.$product_photo->getClientOriginalExtension();
                $product_photo->move(storage_path('app/product/'), $photo_name);
                $product_photo_url = 'app/product/'.$photo_name;
                $update_product = Product::where('name',$product->name)->update([
                   'name' => $request['name'],
                   'img' => $product_photo_url
                ]);
                $product->name = $request['name'];
                $product->brand_id = $request['brand_id'];
                $product->mrp = $request['mrp'];
                $product->photo = $product_photo_url;
                $product->status = $request['status'];
                $product->save();

            }else{
                $update_product = Product::where('name',$product->name)->update([
                   'name' => $request['name']
                ]);
                $product->name = $request['name'];
                $product->brand_id = $request['brand_id'];
                $product->mrp = $request['mrp'];
                $product->status = $request['status'];
                $product->save();
            }
            return redirect('products')->with(['success'=> 'Product Updated!!']);
        } else {
            return redirect('products')->with(['error'=> 'something is wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductMaster  $productMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductMaster $productMaster)
    {
        //
    }
}
