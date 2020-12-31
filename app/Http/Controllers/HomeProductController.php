<?php

namespace App\Http\Controllers;

use App\Brand;
use App\HomeProduct;
use App\Area;
use App\ProductMaster;
use App\ProductCombo;
use Illuminate\Http\Request;
use redirect;

class HomeProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home_product_list = HomeProduct::all();
        $brand_list = Brand::all();
        $product_master_list = ProductMaster::with('brand')->get();
        $Area_list = Area::all();
        $combo_list = ProductCombo::all();
        return view('home_product.index',compact('home_product_list','brand_list','product_master_list','Area_list','combo_list'));
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
        $position = substr($request['position'], 0, -1);
        $data_count = homeProduct::where('position',$position)->count();
        if($data_count > 0){
            return redirect('manage-home')->with(['error'=> 'Already Available!!']);
        }
        $data = new homeProduct();
        $data->position = $position;
        if($position == 'Offer'){
            $data->product_master_id = $request['offer'];
        }else{
           $data->product_master_id = json_encode($request['product_master_id']); 
        }
        $data->status = $request['status'];
        $data->save();
         return redirect('manage-home')->with(['success'=> 'Added Successfully!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HomeProduct  $homeProduct
     * @return \Illuminate\Http\Response
     */
    public function show(HomeProduct $homeProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HomeProduct  $homeProduct
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // echo "<pre>"; print_r('dck'); echo "</pre>"; die('end of code');
        $Home_data = HomeProduct::where('id',$id)->first();
        $brand_list = Brand::all();
        $product_master_list = ProductMaster::with('brand')->get();
        $Area_list = Area::all();
        $combo_list = ProductCombo::all();
        return view('home_product.edit',compact('Home_data','brand_list','product_master_list','Area_list','combo_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HomeProduct  $homeProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeProduct $homeProduct)
    {
        if($request['position'] == 'Offer'){
            $product_master_id = $request['offer'];
        }else{
           $product_master_id = json_encode($request['product_master_id']); 
        }
        if ($request['product_master_id'] || $request['offer']) {
            $data = homeProduct::where('id',$request['id'])->first();
            $data->position = $request['position'];
            $data->product_master_id = $product_master_id;
            $data->status = $request['status'];
            $data->save();
        }else{
            $data = homeProduct::where('id',$request['id'])->first();
            $data->position = $request['position'];
            $data->status = $request['status'];
            $data->save();
        }
        return redirect('manage-home')->with(['success'=> 'Update Successful!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HomeProduct  $homeProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeProduct $homeProduct)
    {
        //
    }
}
