<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CampaignCategory;
use Validator;

class CampaignCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CampaignCategory::all();
        return view('backend.campaign.category',compact('data'));
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
        $rules = array (
          'title' => 'required|unique:campaign_categorys',
        );
        $validator = Validator::make ( $request->all (), $rules );
        if ($validator->fails ()) {
            return Redirect::back()
                            ->withErrors($validator)
                            ->withInput();
        } else {
            if($request->file('photo')){
                $campaign_photo= $request->file('photo');
                $photo_name = time().round(1000,9999).'.'.$campaign_photo->getClientOriginalExtension();
                $campaign_photo->move(storage_path('app/category/'), $photo_name);
                $campaign_photo_url = 'app/category/'.$photo_name;
            }
            $campaign = new CampaignCategory();
            $campaign->title = $request['title'];
            $campaign->status = $request['status'];
            $campaign->photo = $campaign_photo_url;
            $campaign->save();
            return redirect('campaign-category')->with(['success'=> 'campaigns Category Added!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CampaignCategory $CampaignCategory)
    {
        
        

    }

    public function categoryupdate(Request $request){
        $campaign = CampaignCategory::findorfail($request['id']);
        if($request->file('photo')){
                $campaign_photo= $request->file('photo');
                $photo_name = time().round(1000,9999).'.'.$campaign_photo->getClientOriginalExtension();
                $campaign_photo->move(storage_path('app/category/'), $photo_name);
                $campaign_photo_url = 'app/category/'.$photo_name;
                $campaign->photo = $campaign_photo_url;
            }
        $campaign->title = $request['title'];
        $campaign->status = $request['status'];
        $campaign->save();
        return redirect('campaign-category')->with(['success'=> 'campaigns category Updated!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
