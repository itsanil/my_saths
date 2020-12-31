<?php

namespace App\Http\Controllers;

use App\Refund;
use App\Customer;
use App\Order;
use App\Product;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DataTables;
use Response;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('refund.index');
    }


    public function data(Request $request){
        $refund_list = Refund::with('customer')->with('order')->get();
        return DataTables::of($refund_list)
        ->addColumn('name', function ($refund_list) {
            return $refund_list->customer->name;
        })
        ->addColumn('whatsapp_no', function ($refund_list) {
            return $refund_list->customer->whatsapp_no;
        })
        ->addColumn('order_amount', function ($refund_list) {
            return $refund_list->order->order_amt;
        })
        ->addColumn('action', function ($refund_list) {
                return '<a class="btn btn-primary btn-sm"  href="'.route('refund.show',$refund_list->id).'">
                                  <i class="fas fa-eye">
                                  </i>
                            </a>
                            <a class="btn btn-info btn-sm"  href="'.route('refund.edit',$refund_list->id).'">
                                  <i class="fas fa-pencil-alt">
                                  </i>
                            </a>
                            <a class="btn btn-danger btn-sm"  style="color:ffff!important;"  onclick="Delete('.$refund_list->id.');">
                              <i class="fas fa-trash" style="color: #ffff;">
                              </i>
                            </a>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer_list = Customer::where('status',1)->get();
        return view('refund.create',compact('customer_list'));
    }

    public function orderdata(Request $request){
        $order_list = Order::where('customer_id',$request['customer_id'])->where('delivery_status',1)->where('payment_status',1)->orderBy('id','DESC')->get();
        if ($order_list->count() > 0) {
                return Response::json(array('success' => true,'data'=>$order_list));
        }else{
            return Response::json(array('success' => false,'data'=>$order_list));
        }

    }

    public function refundproduct(Request $request){
        // echo "<pre>"; print_r(); echo "</pre>"; die('end of code');
        $order_list = Order::where('id',$request['order_id'])->first();
        if ($order_list->count() > 0) {
            $data['order_amount'] =  $order_list->order_amt;
            $product_list = json_decode($order_list->order_product);
            foreach ($product_list->product_id as $key => $value) {
                $product_data = Product::where('id',$value)->first();
                if($product_data){
                    $data['product_id'][] = $value;
                    $data['name'][] = $product_data->name;
                    $data['order_qty'][] = $product_list->order_qty[$key];
                    $data['per_price'][] = $product_list->per_price[$key];
                    $data['sub_price'][] = $product_list->sub_price[$key];
                }
            }
            // echo "<pre>"; print_r($product_list); echo "</pre>"; die('end of code');
                return Response::json(array('success' => true,'data'=>$data));
        }else{
            return Response::json(array('success' => false));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
            //update stock
            foreach ($request['product_id'] as $key => $value) {
                $stock_data = Stock::where('product_id',$value)->first();
                $stock_data->available_quantity = $stock_data->available_quantity + $request['product_id'][$key];
                $stock_data->save();
                $product_data = Product::where('id',$value)->first();
                $product_data->status = 1;
                $product_data->save();
                $product['product_id'][] = $value;
                $product['product_name'][] =$request['product_name'][$key];
                $product['order_qty'][] =$request['order_qty'][$key];
                $product['per_price'][] =$request['per_price'][$key];
                $product['sub_price'][] =$request['sub_price'][$key];
                $product['refund_qty'][] =$request['refund_qty'][$key];
                   
            }


            $data = new Refund();
            $data->customer_id = $request['customer_id'];
            $data->order_id = $request['order_id'];
            $data->refund_product = json_encode($product);
            $data->refund_amount = $request['refund_amount'];
            $data->refund_date = $request['refund_date'];
            $data->save();
             return redirect('refund')->with(['success'=> 'Refund Added!!']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $refund_data = Refund::with('customer')->with('order')->where('id',$id)->first();
        return view('refund.view',compact('refund_data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer_list = Customer::where('status',1)->get();
        $refund_data = Refund::with('customer')->with('order')->where('id',$id)->first();
        return view('refund.edit',compact('refund_data','customer_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $refund_data = Refund::with('customer')->with('order')->where('id',$request['refund_id'])->first();
        foreach (json_decode($refund_data->refund_product)->product_id as $key => $value) {
            $stock_data = Stock::where('product_id',$value)->first();
            $stock_data->available_quantity = $stock_data->available_quantity - json_decode($refund_data->refund_product)->refund_qty[$key];
            $stock_data->save();
        }

        foreach ($request['product_id'] as $key => $value) {
                $stock_data = Stock::where('product_id',$value)->first();
                $stock_data->available_quantity = $stock_data->available_quantity + $request['product_id'][$key];
                $stock_data->save();

                $product['product_id'][] = $value;
                $product['product_name'][] =$request['product_name'][$key];
                $product['order_qty'][] =$request['order_qty'][$key];
                $product['per_price'][] =$request['per_price'][$key];
                $product['sub_price'][] =$request['sub_price'][$key];
                $product['refund_qty'][] =$request['refund_qty'][$key];
                   
            }


            $data = Refund::with('customer')->with('order')->where('id',$request['refund_id'])->first();
            $data->customer_id = $request['customer_id'];
            $data->order_id = $request['order_id'];
            $data->refund_product = json_encode($product);
            $data->refund_amount = $request['refund_amount'];
            $data->refund_date = $request['refund_date'];
            $data->save();
            return redirect('refund')->with(['success'=> 'Refund Updated!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $refund_data = Refund::with('customer')->with('order')->where('id',$_GET['id'])->first();
        foreach (json_decode($refund_data->refund_product)->product_id as $key => $value) {
            $stock_data = Stock::where('product_id',$value)->first();
            $stock_data->available_quantity = $stock_data->available_quantity - json_decode($refund_data->refund_product)->refund_qty[$key];
            $stock_data->save();
            if ($stock_data->available_quantity == 0) {
                $product_data = Product::where('id',$value)->first();
                $product_data->status = 0;
                $product_data->save();
            }
        }
        $refund_data = Refund::with('customer')->with('order')->where('id',$_GET['id'])->first();
        $refund_data->delete();
        return redirect('refund')->with(['success'=> 'Refund Deleted!!']);
    }
}
