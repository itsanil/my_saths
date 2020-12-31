<?php

namespace App\Http\Controllers;

use App\PaymentType;
use Illuminate\Http\Request;
use Redirect;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_type_list = PaymentType::all();
        return view('payment_type.index',compact('payment_type_list'));
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
        $name = $request['name'];
        $count = PaymentType::where('name',$name)->count();
        if ($count == 0) {
            $data = new PaymentType();
            $data->name = $name;
            $data->save();
            return redirect('payment-options')->with(['success'=> 'Payment Type Added!!']);
        } else {
            return redirect('payment-options')->with(['error'=> 'Duplicate Payment Type!!']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentType $paymentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentType $paymentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentType $paymentType)
    {
        $data = PaymentType::all();
        foreach ($data as $key => $value) {
            if ($value->id != $request['id'] && strtolower($value->name) == strtolower($request['name'])) {
                return Redirect::back()->with(['error'=> 'Duplicate Payment Type!!']);
            } 
        }
        $data = PaymentType::where('id',$request['id'])->first();
        $data->name = $request['name'];
        $data->save();
        return redirect('payment-options')->with(['success'=> 'Payment Typed Updated!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentType $paymentType)
    {
        //
    }
}
