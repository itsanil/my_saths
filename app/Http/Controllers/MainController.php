<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Redirect;
use Toastr;
use Auth;
use Response;
use App\User;

use Str;
use Hash;
use Carbon;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
  public function login(Request $request) {
        $validator = Validator::make($request->all(), [
                'whatsapp_no' => ['required', 'numeric', 'digits:10'],
        ]);
    if ($validator->fails()) {
     return Response::json(array('success' => false,'message'=>'Please type a valid number'));
    }
    $validator = Validator::make($request->all(), [
            'whatsapp_no' => ['required', 'numeric', 'digits:10', 'unique:customers'],
    ]);
        if ($validator->fails()) {
          //whatsapp number is in the customer list hence send otp
          $data = Customer::where('whatsapp_no',$request['whatsapp_no'])->first();
          $otps = rand(1000, 9999);
          // echo "<pre>"; print_r($otp); echo "</pre>"; die('end of code');
          $otp_data = OtpVerification::where('whatsapp_no',$request['whatsapp_no'])->orderBy('id','DESC')->where('is_verified','0')->first();
          if (!empty($otp_data)) {
            $old_time = strtotime($otp_data->created_at);
            $time_diff = time() - $old_time;
            if ($time_diff < 1800) {
              return Response::json(array('success' => true,'message'=>'Please enter OTP to verify your account, OTP is valid for 30 mins.'));
            }
// echo $date;
          }
          $otp = new OtpVerification();
          $token = Str::random(25);
          $otp->customer_id = $data->id;
          $otp->whatsapp_no = $request['whatsapp_no'];
          $otp->token = $token;
          $otp->msg = "Use OTP: ".$otps." to login | Savita's Grocery";
          $otp->otp = $otps;
          $otp->save();
          $this->SendOtp(array('mobile_no'=>$request['whatsapp_no'],'otp'=>$otps));
               return Response::json(array('success' => true,'message'=>'Please type the OTP sent on your mobile'));
        }else{
            return Response::json(array('success' => 'not valid','message'=>'Please register to login'));
        }
  }


  public function ValidateUser(Request $request) {
    $rules = array (
      'username' => 'required|unique:users',
      'email' => 'required|unique:users',
      'mobile' => 'required|numeric|digits:10|unique:users',
    );
    $validator = Validator::make ( $request->all (), $rules );
    if ($validator->fails ()) {
      return Response::json(array('success'=>0 ,'message' => $validator->getMessageBag()->toArray()));
    } else {

      $user = new User();
      $user->firstname = $request['MembName_F'];
      $user->lastname = $request['MembName_L'];
      $user->username = $request['username'];
      $user->usertype = $request['USERTYPE'];
      $user->dob = $request['DOB'];
      $user->gender = $request['Gender'];
      $user->phonecode = $request['phonecode'];
      $user->mobile = $request['mobile'];
      $user->email = $request['email'];
      $user->password = Hash::make($request['mpwd']);
      $user->security_pin = $request['pin'];
      $user->country = $request['M_COUNTRY'];
      $user->state = $request['State'];
      $user->district = $request['District'];
      $user->city = $request['City'];
      $user->pinno = $request['pinno'];
      $user->panno_aadharno = $request['PanNo'];
      $user->campaign = $request['campaign'];
      $user->remember_token = $request['_token'];
      $user->save();
      Auth::loginUsingId($user->id);
      $user->attachRole('user');
      return Response::json(array('success'=>1,'message'=>'Registration successful.'));
      
      
    }
  }

  //  register new customer
  public function Register(Request $request) {
    // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
    $rules = array (
      'name' => 'required',
      'area_id' => 'required',
      'building_name' => 'required',
      // 'password' => 'required|min:6|confirmed',
      'contact_no' => 'nullable|numeric|digits:10|unique:customers',
      'mobile' => 'numeric|digits:10|unique:users',
      // 'gender' => 'required',
      'otp_number' => 'required|numeric|digits:4',
      'token' => 'required',
    );
    $validator = Validator::make ( $request->all (), $rules );
    if ($validator->fails ()) {
      return Response::json(array('message' => $validator->getMessageBag()->toArray()));
    } else {
      $OtpData = new \Illuminate\Http\Request();
      $OtpData->setMethod('POST');
      $OtpData->request->add(['otp_number' => $request->otp_number]);
      $OtpData->request->add(['token' => $request->token]);
      $OtpData->request->add(['mobile_no' => $request->mobile]);
      // echo "<pre>"; print_r($OtpData); echo "</pre>"; die('end of code');
      $OtpVerification =  $this->OtpVerifications($OtpData);
      // print_r($OtpVerification->getData()->message->wrong_otp);
      if($OtpVerification->getData()->success == 0){
        return Response::json(array('success'=>0,'message' => @$OtpVerification->getData()->message->wrong_otp));
      }
      $name = $request['name'];
      $mobile = $request['mobile'];
      $contact_no = $request['contact_no'];

      // ADD IN USERS TABLE
      $user = new User();
      $user->name = $name;
      $user->mobile = $mobile;
      $user->save();
      $user_id = $user->id;

      $customer = new customer();
      $customer->name = $name;
      $customer->user_id =  $user_id;
      $customer->whatsapp_no = $mobile;
      $customer->contact_no = $contact_no;
      $customer->flat_no = $request['flat_no'];
      $customer->building_name = $request['building_name'];
      $customer->area_id = $request['area_id'];
      $customer->lane = $request['lane'];
      $customer->city = $request['city'];
      $customer->status = 1;
      $customer->save();

      Auth::loginUsingId($user->id);
      $user->attachRole('customer');
      return Response::json(array('success'=>1,'message'=>'Registration successful.'));
    }
  }

  //  varification of user otp
  public function OtpVerifications(Request $request) {
    $rules = array (
      'mobile_no' => 'required|numeric|digits:10',
      'otp_number' => 'required|numeric|digits:4',
      'token' => 'required',
    );
    $validator = Validator::make ($request->all(), $rules );
    if ($validator->fails ()) {
      return Response::json(array('success'=>0 ,'message' => $validator->getMessageBag()->toArray()));
    } else {
      // $verifycode = 1;
      $verifycode = OtpVerification::where('whatsapp_no', $request['mobile_no'])->where('otp',$request['otp_number'])->where('token',$request['token'])->where('is_verified','0')->first();
      if($verifycode){
        $verifycode->is_verified = '1';
        $verifycode->save();
        return Response::json(array('success'=>1));
      }
      else
      {
        return Response::json(array('success'=>0,'message'=>array("wrong_otp"=>array("0"=>'Invalid OTP, please type again!!'))));
      }
    }
  }

  public function customer($id)
  {
    return view('home');
  }

  public function showlogin(){
    $Area_list = Area::all();
    $building_list = Customer::with('areas')->groupBy('building_name')->pluck('building_name');
    return view('auth.customerlogin',compact('Area_list','building_list'));
  }

  public function otp(Request $request) {
      $verifycode = OtpVerification::where('whatsapp_no', $request->whatsapp_otp_no)->where('otp',$request->otp_no)->where('is_verified','0')->first();
      if($verifycode){
        $verifycode->is_verified = '1';
        $verifycode->save();
        $user = User::where('mobile',$request->whatsapp_otp_no)->first();
        Auth::loginUsingId($user->id);
        return Response::json(array('success'=>true,'message'=>'Thank You!!'));
      }
      else
      {
        return Response::json(array('success'=>false,'message'=>'Invalid OTP, please type again!!'));
      }
  } 


  public function SendOtp($request)
  {
    return true;
    $result = '';
    $ch = curl_init();

    $user = "sanchitsoftware";

    $pass = "Sanchit@123";

    $receipientno = $request['mobile_no']; 

    $senderID="SSASPL"; 

    // $msgtxt = "Your OTP is: ".$request['otp']." ,GamerzByte India."; 
    $msgtxt = "Use OTP: ".$request['otp']." to login | Savita's Grocery"; 

    $url="http://smsjust.com/blank/sms/user/urlsms.php?username=".urlencode($user)."&pass=".urlencode($pass)."&senderid=".urlencode($senderID)."&dest_mobileno=".urlencode($receipientno)."&message=".urlencode($msgtxt)."&response=Y";
    curl_setopt($ch,CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result= curl_exec($ch);
    curl_close($ch);
  }

  public function getHomedData(){
        $home_product = HomeProduct::where('status','Active')->where('position', '!=','Offer')->where('position', '!=','Our Delivery Area')->orderBy('id','ASC')->get();

        $sgp = ManageSgp::orderBy('id','DESC')->first();
        foreach ($home_product as $key => $value) {
          $product_master_id = json_decode($value->product_master_id);
          $data = array();
            foreach ($product_master_id as $keys => $values) {
              $Product = ProductMaster::where('id',$values)->first();
              if ($value->position == 'Combo Offer' || strpos($values, '-combo')) {
                $Product = ProductCombo::where('id',$values)->first();
                $data['product_type'][] = 'combo';
                $data['name'][] = $Product->product_combo_name;
                $data['photo'][] = $Product->photo;
                $mrp = 0;
                $status = true;
                foreach (json_decode(json_decode($Product->product_list)->id) as $keyss => $valuess) {
                  $master = Product::where('id',$valuess)->first();
                  $master = ProductMaster::where('name',$master->name)->first();
                  if(isset($master->mrp)){
                    $mrp += $master->mrp*json_decode(json_decode($Product->product_list)->qty)[$keyss];
                  }
                  $pro_id = Product::where('name',$master->name)->orderBy('id','DESC')->pluck('id');
                  $avail_qty = 0;
                  foreach ($pro_id as $i => $id) {
                    $stock = Stock::where('product_id',$id)->orderBy('id','DESC')->first();
                    $avail_qty += $stock->available_quantity;
                  }
                  if($avail_qty/json_decode(json_decode($Product->product_list)->qty)[$keyss] < 0){
                    $status = false;
                  }
                }
                if ($status) {
                  $data['product_id'][] = $Product->id.'-combo';
                } else {
                  $data['product_id'][] = 0;
                }
                $data['mrp'][] = $mrp;
                if ($sgp) {
                  if (round($Product->combo_price + ($mrp * $sgp->value/100)) > $mrp) {
                    $data['sale_price'][] = $mrp;
                  } else {
                    $data['sale_price'][] = round($Product->combo_price + ($mrp * $sgp->value/100));
                  }
                } else {
                  $data['sale_price'][] = $Product->combo_price;
                }
              } else {
                $data['product_type'][] = 'single';
                $data['name'][] = $Product->name;
                $data['photo'][] = $Product->photo;
                $data['mrp'][] = $Product->mrp;
                $product_data = Product::where('name',$Product->name)->orderBy('id','DESC')->first();
                if ($product_data) {
                  $stock_data = Stock::where('product_id',$product_data->id)->where('available_quantity','!=',0)->first();
                    if ($stock_data) {
                        $data['product_id'][] = $product_data->id;
                    } else {
                        $data['product_id'][] = 0;
                    }
                  
                  if ($sgp && $Product->mrp) {
                    if (round($product_data->sale_price + ($Product->mrp * $sgp->value/100)) > $Product->mrp) {
                      $data['sale_price'][] = $Product->mrp;
                    } else {
                      $data['sale_price'][] = round($product_data->sale_price + ($Product->mrp * $sgp->value/100));
                    }
                  } else {
                    $data['sale_price'][] = $product_data->sale_price;
                  }
                } else {
                  $data['sale_price'][] = '';
                  $data['product_id'][] = 0;
                }
              }
              
            }
            $value->data = json_encode($data);
          }
        $area = HomeProduct::where('status','Active')->where('position','Our Delivery Area')->get();
        $Area = array();
        foreach ($area as $key => $value) {
          $product_master_id = json_decode($value->product_master_id);
          foreach ($product_master_id as $keys => $values) {
            $Product = Area::where('id',$values)->first();
              $Area[] = $Product->name;
          }
        }

        $offer = HomeProduct::where('status','Active')->where('position','Offer')->first();
        $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
        $tag_data = Tag::where('photo','!=','')->where('status','Active')->orderBy('name', 'ASC')->get();
        $promotion_list = Promotion::with('brand')->where('status','Active')->orderBy('id', 'DESC')->get();
        $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
        $cart = Session::get('cart_product');
        $cart_product_id_array = explode(',', $cart);
        if (isset($cart_product_id_array) && $cart_product_id_array[0] != '') {
          $cart_count =  count($cart_product_id_array);
        } else {
          $cart_count = 0;
        }

        // echo "<pre>"; print_r($home_product); echo "</pre>"; die('end of code');
        return view('welcome',compact('brand_list','home_product','Area','offer','tag_list','cart','cart_count','promotion_list','cart_product_id_array','tag_data'));
  }



    public function buildingname(Request $request)
    {
          $search = $request->get('term');
     
          $result = Customer::where('building_name', 'LIKE', '%'. $search. '%')->groupBy('building_name')->pluck('building_name');

          return response()->json($result);
           
    } 

    public function getstate(Request $request){
      // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
      $url = "https://api.printful.com/countries";
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      //for debug only!
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

      $resp = curl_exec($curl);
      curl_close($curl);
      $c_html = '<option value="">Select</option>';
      $s_html = '<option value="">Select</option>';
      $s_status = false;
      
      foreach (json_decode($resp)->result as $key => $value) {
        $c_html .= '<option value="'.$value->name.'">'.$value->name.'</option>';
        if($value->name == $request['state_code']){
          if($value->states){
            foreach ($value->states as $s => $v) {
              $s_status = true;
              $s_html .= '<option value="'.$v->name.'">'.$v->name.'</option>';
            }
          }
        }
      }
      if($request['state_code'] == 'country'){
        return Response::json(array('success'=>1,'data'=>$c_html));
      }else{
        if ($s_status) {
          return Response::json(array('success'=>1,'data'=>$s_html));
        } else {
          return Response::json(array('success'=>0,'data'=>$s_html));
        }
      }
    }
    
}
