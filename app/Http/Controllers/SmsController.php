<?php

namespace App\Http\Controllers;

use App\OtpVerification;
use App\Customer;
use Illuminate\Http\Request;
use DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sms_list = OtpVerification::orderBy('id','DESC')->get();
        return view('user.sms',compact('sms_list'));
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
        
        
        // echo "<pre>"; print_r(); echo "</pre>"; die('end of code');
        if ($request['user'] == 'all') {
            $mobile_list = Customer::where('status','1')->pluck('whatsapp_no');
            foreach ($mobile_list as $key => $value) {
                $this->Sendbulksms(array('mobile_no'=>$value,'text'=>$request['text']));
            }
        } else {
            if ($request['user'] == 'Excel') {
                // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($request['excel']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $mobile_no_array = array();
                $invalid_mobile_no_array = array();

                foreach ($sheetData as $key => $value) {
                    $invalid_mobile_no_array[] = $value['A'];
                    if($key > 1 && is_numeric($value['A']) && strlen($value['A']) == 10){
                        $mobile_no_array[] = $value['A'];
                    }else{
                        
                    }
                }
                // echo "<pre>"; print_r(array_unique($mobile_no_array)); echo "</pre>"; die('end dcsadcof code');
                foreach (array_unique($mobile_no_array) as $key => $value) {
                    echo $key;
                    $this->Sendbulksms(array('mobile_no'=>$value,'text'=>$request['text']));
                }
                die('anil');
            } else {
                $test = array('8652427021','9920785930');
                // $test = array('8652427021','9967634450');
                foreach ($test as $key => $value) {
                    $this->Sendbulksms(array('mobile_no'=>$value,'text'=>$request['text']));
                }
            }
        }

        return redirect('sms')->with(['success'=> 'SMS Sended!!']);
        
    }

     public function Sendbulksms($request){
        
        $result = '';
        $ch = curl_init();

        // $user = "sanchitsoftware";

        $pass = "Sanchit@123";

        $receipientno = $request['mobile_no']; 

        $senderID="SGSHOP"; 

        $msgtxt = $request['text'];
        // $url="http://smsjust.com/blank/sms/user/urlsms.php?username=".urlencode($user)."&pass=".urlencode($pass)."&senderid=".urlencode($senderID)."&dest_mobileno=".urlencode($receipientno)."&message=".urlencode($msgtxt)."&response=Y";
        // curl_setopt($ch,CURLOPT_URL, $url);

        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $result= curl_exec($ch);
        // curl_close($ch);

        $OtpVerification = new OtpVerification();
        $OtpVerification->msg = $request['text'];
        // $OtpVerification->token = $token;
        $OtpVerification->whatsapp_no = $request['mobile_no']; 
        $OtpVerification->save();
        echo "<pre>"; print_r($OtpVerification->id); echo "</pre>"; 
        echo "<pre>"; print_r($request['mobile_no']); echo "</pre>"; 
        return true;
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request){
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
        $StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        if ($StartDate == 'Invalid date' || $StartDate == 'all') {
            $sms_list = OtpVerification::orderBy('id','DESC')->get();
        } else {
            $sms_list = OtpVerification::whereDate('created_at','>=',$StartDate)->whereDate('created_at','<=',$EndDate)->orderBy('id','DESC')->get();
        }
        return DataTables::of($sms_list)
         ->addColumn('date', function ($sms_list) {
                return date("jS F Y", strtotime($sms_list->created_at));
        })
        ->rawColumns(['date'])
        ->make(true);
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
    public function update(Request $request, $id)
    {
        //
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
