<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignCategory;
use Illuminate\Http\Request;
use Validator;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Campaign::with('campaign')->get();
        return view('backend.campaign.index',compact('data'));
    }

    public function campaignview(){
        $data = Campaign::with('campaign')->where('category_id',$_GET['id'])->first();
        return view('frontend.campaign_view',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = CampaignCategory::all();
        return view('backend.campaign.create',compact('data'));
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
        $rules = array (
          'category_id' => 'required|unique:campaigns',
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
                $campaign_photo->move(storage_path('app/campaign/'), $photo_name);
                $campaign_photo_url = 'app/campaign/'.$photo_name;
            }
            $campaign = new Campaign();
            $campaign->category_id = $request['category_id'];
            $campaign->discription = $request['description'];
            $campaign->status = $request['status'];
            $campaign->photo = $campaign_photo_url;
            $campaign->save();
            return redirect('campaigns')->with(['success'=> 'campaigns Added!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        $data = CampaignCategory::all();
        return view('backend.campaign.edit',compact('campaign','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campaign)
    {
        if($request->file('photo')){
                $campaign_photo= $request->file('photo');
                $photo_name = time().round(1000,9999).'.'.$campaign_photo->getClientOriginalExtension();
                $campaign_photo->move(storage_path('app/campaign/'), $photo_name);
                $campaign_photo_url = 'app/campaign/'.$photo_name;
                $campaign->photo = $campaign_photo_url;
            }
        $campaign->discription = $request['description'];
        $campaign->status = $request['status'];
        $campaign->save();
        return redirect('campaigns')->with(['success'=> 'campaigns Updated!!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
