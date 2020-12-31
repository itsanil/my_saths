<?php

namespace App\Http\Controllers;

use App\Voucher;
use App\CustomerDiscount;
use App\Customer;
use Illuminate\Http\Request;
use Validator;
use Response;
use Auth;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $voucher_list = Voucher::orderBy('id', 'DESC')->get();
        return view('voucher.index',compact('voucher_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $voucher_list = Voucher::orderBy('id', 'DESC')->get();
        return view('voucher.create',compact('voucher_list'));
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
          'voucher_code' => 'required|unique:vouchers',
        );
        $validator = Validator::make ( $request->all (), $rules );
        if ($validator->fails ()) {
            return redirect('voucher/create')->with(array('error'=>'Duplicate Voucher Code!!'));
        } else {
            $data = new Voucher();
            $data->voucher_code = $request['voucher_code'];
            $data->type = $request['type'];
            $data->value = $request['value'];
            $data->max_use = $request['max_use'];
            $data->min_order_value = $request['min_order_value'];
            $data->start_date = $request['start_date'];
            $data->end_date = $request['end_date'];
            $data->status = $request['status'];
            $data->save();
            return redirect('voucher')->with(['success'=> 'Voucher Added!!']);
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $voucher_Data = Voucher::where('id',$id)->first();
        $voucher_list = Voucher::orderBy('id', 'DESC')->get();
        return view('voucher.edit',compact('voucher_Data','voucher_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        $data = Voucher::all();
        foreach ($data as $key => $value) {
            if($value->voucher_code == $request['voucher_code']){
                if ($value->id != $request['id']) {
                    return redirect('voucher/'.$request['id'].'/edit')->with(['error'=> 'Duplicate Record!!']);
                }
            }
        }
        $id = $request['id'];
            $data = Voucher::where('id',$id)->first();
            $data->voucher_code = $request['voucher_code'];
            $data->type = $request['type'];
            $data->value = $request['value'];
            $data->max_use = $request['max_use'];
            $data->min_order_value = $request['min_order_value'];
            $data->start_date = $request['start_date'];
            $data->end_date = $request['end_date'];
            $data->status = $request['status'];
            $data->save();
            return redirect('voucher')->with(['success'=> 'Voucher Updated!!']);
    }

     public function validateVoucher(Request $request){
        // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
        if ($request['customer_id'] == 'customer') {
           $customer_data = Customer::where('user_id',Auth::User()->id)->first();
           $customer_id = $customer_data->id;
        } else {
            $customer_id = $request['customer_id'];
        }
        
        
        $data = Voucher::where('voucher_code',$request['voucher_code'])->where('status','Active')->first();
        // $status = false;
        if (empty($data)) {
           return Response::json(array('success' => false,'message'=>'Invalid Coupon Code'));
        } else {
            if (date("Y-m-d") > $data->end_date) {
               return Response::json(array('success' => false,'message'=>'Coupon Code is Expired'));
            }
            $Coupon_use = CustomerDiscount::where('customer_id',$customer_id)->count();
            if($request->path() == 'validate_voucher'){
                if ($Coupon_use >= $data->max_use) {
                   return Response::json(array('success' => false,'message'=>'Coupon Code already used'));
                }
            }else{
                if (($Coupon_use-1) >= $data->max_use) {
                   return Response::json(array('success' => false,'message'=>'Coupon Code already used'));
                }
            }
            if ($request['order_amount'] < $data->min_order_value) {
               return Response::json(array('success' => false,'message'=>'Order Amt is Invalid for this Coupon Code'));
            } 

            if ($data->type == 'Flate') {
                $discount = $data->value;
            } else {
                $discount = $request['order_amount']*$data->value/100;
            }
            return Response::json(array('success' => true,'message'=>'Coupon Code applied Successfully!!','discount'=>$discount,'voucher_id'=>$data->id));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        //
    }
}
