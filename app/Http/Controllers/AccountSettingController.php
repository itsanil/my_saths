<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CampaignCategory;
use App\User;
use Validator;
use Response;
use Redirect;
use Hash;

class AccountSettingController extends Controller
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

    public function editProfile(){
        $user_id=\Auth::id();
        $user_data = User::findorfail($user_id);
        $inviter_data = User::where('inviter_id',$user_data->inviter_id)->first();
         // $dob=date('d-m-Y',strtotime($user_data->dob));
         // dd($inviter_data);
        return view('backend.account-setting.edit-profile',compact('user_data','inviter_data'));
    }
    public function viewProfile(){
        $user_id=\Auth::id();
         $user_data = User::findorfail($user_id);
         $inviter_data = User::where('inviter_id',$user_data->inviter_id)->first();
         // dd($data);
        return view('backend.account-setting.view-profile',compact('user_data','inviter_data'));
    }
    
    public function changePassword(){
        $user_id=\Auth::id();
         $data = User::findorfail($user_id);
         // dd($data);
        return view('backend.account-setting.change-password',compact('data'));
    }

    public function checkUserPassword(Request $request){
        // dd($request->all());
        $oldpassword=$request->oldpassword; 
        if (!empty($oldpassword)) {
            $user_id=\Auth::id();
            $user_data = User::findorfail($user_id);
            if(!empty($user_data)){
                $password=$user_data->password;
                $result=\Hash::check($oldpassword,$password);
                if($result==true){
                 $returnArray['status']=true;
                 $returnArray['message']="Old Password Matched";
                }else{
                 $returnArray['status']=false;
                 $returnArray['message']="Old Password Does Not Matched";
                }
            }   
        }

        echo json_encode($returnArray);
    }

    public function checkUserSecurityPin(Request $request){
         $current_security_pin=$request->current_security_pin; 
        if (!empty($current_security_pin)) {
            $user_id=\Auth::id();
            $user_data = User::findorfail($user_id);
            if(!empty($user_data)){
                $security_pin=$user_data->security_pin;
                if($security_pin==$current_security_pin){
                 $returnArray['status']=true;
                 $returnArray['message']="Security Pin Matched";
                }else{
                 $returnArray['status']=false;
                 $returnArray['message']="Security Pin Does Not Matched";
                }
            }   
        }

        echo json_encode($returnArray);
    }
    

    public function updatepassword(Request $request){
        // dd($request->all());
        $user_id=\Auth::id();
        $oldpassword=$request->oldpassword;
        $newpassword=$request->newpassword;
        $confirmpassword=$request->confirmpassword;
        $user_data = User::findorfail($user_id);
        $password=$user_data->password;
        $result=\Hash::check($oldpassword,$password);
        if($result==true){
            if ($newpassword == $confirmpassword) {
                $data=array(
                   'password'=> Hash::make($confirmpassword),
                );
                // dd($data);
            $update=User::where('id',$user_id)->update($data);
            return Redirect::back()->withSuccess('Successfully Update Password');
            }else{
            return Redirect::back()->withError('New And Confirm Password Does Not Matched!');
            }
                 
        }else{
            return Redirect::back()->withError('Old Password Does Not Matched!');
        }

       
    }

    public function updateSecurityPin(Request $request){
        // dd($request->all());
        $current_security_pin=$request->current_security_pin;
        $new_security_pin=$request->new_security_pin;
        $confirm_security_pin=$request->confirm_security_pin;
        $user_id=\Auth::id();
        $user_data = User::findorfail($user_id);
        $security_pin=$user_data->security_pin;
            if ($new_security_pin == $confirm_security_pin) {
                $data=array(
                   'security_pin'=>$security_pin,
                );
                // dd($data);
            $update=User::where('id',$user_id)->update($data);
            return Redirect::back()->withSuccess('Successfully Update Security Pin');
            }else{
            return Redirect::back()->withError('New And Confirm Security Pin Does Not Matched!');
            }
                 
       
    }


    public function changeMobileEmail(){
        $user_id=\Auth::id();
         $data = User::findorfail($user_id);
         // dd($data);
        return view('backend.account-setting.change-mobile-email',compact('data'));
    }
    public function changeSecurityPassword(){
        $user_id=\Auth::id();
         $data = User::findorfail($user_id);
         // dd($data);
        return view('backend.account-setting.change-security-password',compact('data'));
    }
    public function payoutSettings(){
        $user_id=\Auth::id();
         $data = User::findorfail($user_id);
         // dd($data);
        return view('backend.account-setting.payout-settings',compact('data'));
    }
    public function showVerification(){
        $user_id=\Auth::id();
         $data = User::findorfail($user_id);
         // dd($data);
        return view('backend.account-setting.show-verification',compact('data'));
    }

    public function getUserPin(Request $request){
        // dd($request->tpin_no);
        $tpin_no=$request->tpin_no;
        if (!empty($tpin_no)) {
         $user_id=\Auth::id();
         $data = User::where(['id'=>$user_id,'security_pin'=>$tpin_no])->first();
         if (!empty($data)) {
             $returnArray['status']=true;
           
         }else{
              $returnArray['status']=false;
         }
        }
        echo json_encode($returnArray);
        
    }

    public function updateProfile(Request $request){
        // dd($request->all());
          $user_id=\Auth::id();
        $user_sex=$request->user_sex;
        $dob=$request->dob;
        $address=$request->address;
        $state=$request->state;
        $district=$request->district;
        $city=$request->city;
        $pinno=$request->pinno;
        $skype_id=$request->skype_id;
        $anonymous=$request->anonymous;
        $is_online_sensor=$request->is_online_sensor;
        $security_pin=$request->security_pin;

        $user_check=User::where(['id'=>$user_id,'security_pin'=>$security_pin])->first();
        if (!empty($user_check)) {
            $data=array(
               'gender'=>$user_sex,
               'dob'=>$dob,
               'address'=>$address,
               'state'=>$state,
               'district'=>$district,
               'city'=>$city,
               'pinno'=>$pinno,
               'skype_id'=>$skype_id,
               'is_anonymous'=>$anonymous=='on'?1:0,
               'is_online_sensor'=>$is_online_sensor=='on'?1:0
            );
            // dd($data);
            $update=User::where('id',$user_id)->update($data);
            return Redirect::back()->withSuccess('Successfully Update Profile');
        }else{
              return Redirect::back()->withError('Security Pin not matched!');
        }

    }

    public function updateMobileEmail(Request $request){
        // dd($request->email);
        $email=$request->email;
        if (!empty($email)) {
            $data=array(
               'email'=>$email,
            );
             $user_id=\Auth::id();
            $update=User::where('id',$user_id)->update($data);
            return Redirect::back()->withSuccess('Successfully Update Profile');
        }else{
            return Redirect::back()->withError('Security Pin not matched!');
        }
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
