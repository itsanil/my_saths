<?php

namespace App\Http\Controllers;

use App\Promotion;
use App\Brand;
use App\Tag;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotion_list = Promotion::with('brand')->orderBy('id', 'DESC')->get();
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        return view('promotion.index',compact('promotion_list','brand_list'));
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
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ]);
        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $product_photo_url = '';
        if($request->file('banner')){
            $product_photo= $request->file('banner');
            $photo_name = time().round(1000,9999).'.'.$product_photo->getClientOriginalExtension();
            $product_photo->move(storage_path('app/banner/'), $photo_name);
            $banner_url = 'app/banner/'.$photo_name;
        }
        // echo "<pre>"; print_r($request->file('img')); echo "</pre>"; die('end of code');
        $banner = new Promotion();
        $banner->promo_name = $request['promo_name'];
        $banner->brand_id = $request['brand_id'];
        $banner->link = $request['link'];
        $banner->start_date = $request['start_date'];
        $banner->end_date = $request['end_date'];
        $banner->status = $request['status'];
        $banner->banner_url = $banner_url;
        $banner->save();
        return redirect('promotions')->with(['success'=> 'Promotion Added!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        $banner = Promotion::where('id',$request['id'])->first();
        if($request->file('banner')){
            $validator = Validator::make($request->all(), [
                'banner' => 'required|image|mimes:jpeg,png,jpg|max:1024'
            ]);
            if ($validator->fails()) {
                return Redirect::back()
                            ->withErrors($validator)
                            ->withInput();
            }
            $product_photo= $request->file('banner');
            $photo_name = time().round(1000,9999).'.'.$product_photo->getClientOriginalExtension();
            $product_photo->move(storage_path('app/banner/'), $photo_name);
            $banner_url = 'app/banner/'.$photo_name;
            $banner->banner_url = $banner_url;
        }
        $banner->promo_name = $request['promo_name'];
        $banner->brand_id = $request['brand_id'];
        $banner->link = $request['link'];
        $banner->start_date = $request['start_date'];
        $banner->end_date = $request['end_date'];
        $banner->status = $request['status'];
        $banner->save();
        return redirect('promotions')->with(['success'=> 'Promotion updated!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        //
    }

    public function disclaimer(){
         $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        return view('footer.disclaimer',compact('tag_list','brand_list'));
    }

    public function privacy(){
         $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        return view('footer.privacy',compact('tag_list','brand_list'));
    }

     public function terms(){
         $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        return view('footer.terms',compact('tag_list','brand_list'));
    }
}
