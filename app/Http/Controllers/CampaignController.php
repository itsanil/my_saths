<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignCategory;
use App\Perk;
use Illuminate\Http\Request;
use Validator;
use Auth;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Campaign::with('campaign')->where('added_by',Auth::User()->id)->get();
        return view('backend.campaign.index',compact('data'));
    }

    public function campaignview($id){
        $campaign = Campaign::findorfail($id);
        return view('backend.campaign.show',compact('campaign'));
        // echo "<pre>"; print_r($id); echo "</pre>"; die('end of code');
        // $data = Campaign::with('campaign')->where('category_id',$_GET['id'])->first();
        // return view('frontend.campaign_view',compact('data'));
    }

    public function campaignlist(){
        $category = CampaignCategory::where('status','Active')->get();
        $data = Campaign::with('campaign')->where('category_id',$_GET['id'])->get();
        // echo "<pre>"; print_r($data); echo "</pre>"; die('end of code');
        return view('frontend.campaign_view',compact('data','category'));
    }

    public function contributenow($id){
        $campaign = Campaign::findorfail($id);
        return view('frontend.contribute_now',compact('campaign'));
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
            $campaign->recipient_type = $request['recipient_type'];
            $campaign->recipient_first_name = $request['recipient_first_name'];
            $campaign->recipient_last_name = $request['recipient_last_name'];
            $campaign->recipient_business_name = $request['recipient_business_name'];
            $campaign->legal_recipient_first_name = $request['legal_recipient_first_name'];
            $campaign->legal_recipient_last_name = $request['legal_recipient_last_name'];
            $campaign->added_by = $request['added_by'];
            $campaign->title = $request['title'];
            $campaign->project = json_encode($request['project']);
            $campaign->video_1 = $request['video_1'];
            $campaign->video_2 = $request['video_2'];
            if (isset($request['video_type'])) {
                $campaign->video_type = $request['video_type'];
            } else {
                $campaign->video_type = 0;
            }
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
        // echo "<pre>"; print_r($campaign); echo "</pre>"; die('end of code');
        return view('backend.campaign.show',compact('campaign'));
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
        $perk_data = Perk::where('campaign_id',$campaign->id)->first();
        return view('backend.campaign.edit',compact('campaign','data','perk_data'));
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
        // echo "<pre>"; print_r(); echo "</pre>"; die('end of code');
        if($request->file('photo')){
                $campaign_photo= $request->file('photo');
                $photo_name = time().round(1000,9999).'.'.$campaign_photo->getClientOriginalExtension();
                $campaign_photo->move(storage_path('app/campaign/'), $photo_name);
                $campaign_photo_url = 'app/campaign/'.$photo_name;
                $campaign->photo = $campaign_photo_url;
            }

        $add_photo = array();
        if($request->file('add_photo')){
            foreach ($request->file('add_photo') as $key => $value) {
                $campaign_photo= $value;
                $photo_name = time().round(1000,9999).'.'.$campaign_photo->getClientOriginalExtension();
                $campaign_photo->move(storage_path('app/campaign/'), $photo_name);
                $campaign_photo_url = 'app/campaign/'.$photo_name;
                $add_photo[] = $campaign_photo_url;
            }
            $campaign->add_photo = json_encode($add_photo);   
        }
        $campaign->category_id = $request['category_id'];
        $campaign->discription = $request['description'];
        $campaign->status = $request['status'];
        $campaign->recipient_type = $request['recipient_type'];
        $campaign->recipient_first_name = $request['recipient_first_name'];
        $campaign->recipient_last_name = $request['recipient_last_name'];
        $campaign->recipient_business_name = $request['recipient_business_name'];
        $campaign->legal_recipient_first_name = $request['legal_recipient_first_name'];
        $campaign->legal_recipient_last_name = $request['legal_recipient_last_name'];
        $campaign->added_by = $request['added_by'];
        $campaign->title = $request['title'];
        $campaign->project = json_encode($request['project']);
        $campaign->video_1 = $request['video_1'];
        $campaign->video_2 = $request['video_2'];
        if (isset($request['video_type'])) {
            $campaign->video_type = $request['video_type'];
        } else {
            $campaign->video_type = 0;
        }
        $campaign->save();


        if(isset($request['perk'])){
            $perk = Perk::where('campaign_id',$campaign->id)->first();
            if(empty($perk)){
               $perk = new Perk(); 
            }
            if(isset($request->file('perk')['image'])){
                $perk_photo= $request->file('perk')['image'];
                $photo_name = time().round(1000,9999).'.'.$perk_photo->getClientOriginalExtension();
                $perk_photo->move(storage_path('app/perk/'), $photo_name);
                $perk_photo_url = 'app/perk/'.$photo_name;
                $perk->perk_photo = $perk_photo_url;
            }

            $perk->campaign_id = $request['perk']['project_id'];
            $perk->perk_type = $request['perk']['perk_type'];
            $perk->perk_title = $request['perk']['perk_title'];
            $perk->perk_description = $request['perk']['perk_description'];
            $perk->amount = $request['perk']['amount'];
            $perk->max_perks = $request['perk']['max_perks'];
            $perk->estimated_date = $request['perk']['estimated_date'];
            if(isset($request['shipping_address'])){
                $perk->shipping_address = json_encode($request['shipping_address']);
            }
            $perk->save();
        }
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
