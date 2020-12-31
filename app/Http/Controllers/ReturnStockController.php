<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Product;
use App\ReturnStockLog;
use DB;

class ReturnStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_datas = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->where('stocks.available_quantity','!=',0)
            ->get();

        return view('stock.return-stock',compact('stock_datas'));
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
        //
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
    public function update(Request $request)
    {
        //we have to update products(purchase table) and stock table and generate logs in return_stock_logs table
        $id = $request['id'];
        $return_qty = $request['return_qty'];
        $return_date = $request['return_date'];
        //update products table

        $product_data = Product::findorfail($id);
        $product_data->purchase_qty = $product_data->purchase_qty - $return_qty;
        $product_data->order_amount = $product_data->order_amount - $product_data->purchase_price * $return_qty;
        $total_order_amt = $product_data->total_order_amt - $product_data->purchase_price * $return_qty;
        $order_no = $product_data->stock_order_id;
        $purchase_qty = $product_data->purchase_qty;
        $product_data->total_order_amt = $total_order_amt;
        $product_data->save();

        $order_no_product = Product::where('stock_order_id', $order_no)->update(['total_order_amt'=>$total_order_amt]);

        //update stock table
        $stock_datas = Stock::findorfail($id);
        $stock_datas->purchase_quantity = $stock_datas->purchase_quantity - $return_qty;
        $stock_datas->available_quantity = $stock_datas->available_quantity - $return_qty;
        $stock_datas->save();

        //generate logs in return_stock_logs table

        $data = new ReturnStockLog();
        $data->purchase_order_no = $order_no;
        $data->product_id = $id;
        $data->purchase_qtys = $purchase_qty;
        $data->return_qty = $return_qty;
        $data->return_date = $return_date;
        $data->save();

        return redirect('return-stock')->with(['success'=> 'Update Successful!!']);
        
    }

    public function stocklog(){
        $stock_logs = ReturnStockLog::with('product')->get();
        return view('stock.return-stock-logs',compact('stock_logs'));
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
