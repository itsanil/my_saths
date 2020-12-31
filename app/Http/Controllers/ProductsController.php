<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductSource;
use App\ProductRate;
use App\Stock;
use App\Pdf;
use App\ProductMaster;
use App\ManageSgp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Storage;
use DataTables;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_list = Product::with('ProductSource')->get();
        return view('product.index',compact('product_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ProductSource_list = ProductSource::all();
        $ProductMaster_list = ProductMaster::where('status','Active')->get();
        return view('product.create',compact('ProductSource_list','ProductMaster_list'));
    }

    public function data(Request $request){
        $StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        if ($StartDate == 'Invalid date' || $StartDate == 'all') {
            if (isset($request['id'])) {
                $product_list = Product::with('ProductSource')->where('product_source_id',$request['id'])->orderBy('id','DESC')->get()->unique('stock_order_id');
            } else {
                $product_list = Product::with('ProductSource')->orderBy('id','DESC')->get()->unique('stock_order_id');
            }            
        } else {
            if (isset($request['id'])) {
                $product_list = Product::with('ProductSource')->where('product_source_id',$request['id'])->whereBetween('order_date',[$StartDate,$EndDate])->orderBy('id','DESC')->get()->unique('stock_order_id');
            } else {
                $product_list = Product::with('ProductSource')->whereBetween('order_date',[$StartDate,$EndDate])->orderBy('id','DESC')->get()->unique('stock_order_id');
            } 
            
        }
        if (isset($request['id'])) {
                return DataTables::of($product_list)
        ->addColumn('status', function ($product) {
            if ($product->status == 1) {
                return '<span class="badge badge-success">Active</span>';
            } else {
                return '<span class="badge badge-danger">In-Active</span>';
            }
        })
        
        ->addColumn('action', function ($value) {
                return '<a class="btn btn-primary btn-sm"  href="'.route('purchase.show',$value->stock_order_id).'">
                                  <i class="fas fa-eye">
                                  </i>
                                 
                            </a>';
        })
        ->rawColumns(['status','action'])
        ->make(true);
        } else {
            return DataTables::of($product_list)
        ->addColumn('status', function ($product) {
            if ($product->status == 1) {
                return '<span class="badge badge-success">Active</span>';
            } else {
                return '<span class="badge badge-danger">In-Active</span>';
            }
        })
        
        ->addColumn('action', function ($value) {
                return '<a class="btn btn-primary btn-sm"  href="'.route('purchase.show',$value->stock_order_id).'">
                                  <i class="fas fa-eye">
                                  </i>
                                 
                            </a>
                            <a class="btn btn-info btn-sm"  href="'.route('purchase.edit',$value->stock_order_id).'">
                                  <i class="fas fa-pencil-alt">
                                  </i>
                            </a>
                            <a class="btn btn-danger btn-sm"  style="color:ffff!important;"  onclick="Delete('.$value->stock_order_id.');">
                              <i class="fas fa-trash" style="color: #ffff;">
                              </i>
                            </a>';
        })
        ->rawColumns(['status','action'])
        ->make(true);
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
        
        $order_no = time().round(1000,9999);
        foreach ($request['name'] as $key => $value) {
            $product = new product();
            $product->name = $value;
            $product->img = $request['img'][$key];
            $product->product_source_id = $request['product_source_id'];
            $product->purchase_price = $request['purchase_price'][$key];
            $product->bulk_sale_price = $request['bulk_sale_price'][$key];
            $product->transport_expence = $request['transport_expence'];
            $product->status = $request['status'];
            $product->purchase_qty = $request['purchase_qty'][$key];
            $product->order_amount = $request['net_amt'][$key];
            $product->sale_price = $request['sale_price'][$key];
            $product->order_date = $request['order_date'];
            $product->invoice_no = $request['invoice_no'];
            $product->total_order_amt = $request['order_amount'];
            $product->stock_order_id = $order_no;
            $product->save();
            $last_id = $product->id;
            $count = product::where('name',$value)->count();
            if($count == 1){
                //add in pdf
                $pdf = Pdf::all();
                foreach ($pdf as $pdfkeys => $pdfdata) {
                    $pdf_order = json_decode($pdfdata->product_description);
                    $last_count = count($pdf_order->order);
                    $pdf_order->order[$last_count] = "".($last_count+1)."";
                    $pdf_order->product_id[$last_count] = "".$last_id."";
                    $pdfs = Pdf::where('id',$pdfdata->id)->first();
                    $pdfs->product_description = json_encode($pdf_order);
                    $pdfs->save();
                }
            }
            $stock_data = new Stock();
            $stock_data->product_id = $last_id;
            $stock_data->purchase_quantity = $request['purchase_qty'][$key];
            $stock_data->available_quantity = $request['purchase_qty'][$key];
            $stock_data->save();
            $product_rate = new ProductRate();
            $product_rate->product_id = $last_id;
            $product_rate->purchase_qty = $request['purchase_qty'][$key];
            $product_rate->purchase_price = $request['purchase_price'][$key];
            $product_rate->transport_expence = $request['transport_expence'];
            $product_rate->order_amount = $request['net_amt'][$key];
            $product_rate->bulk_sale_price = $request['bulk_sale_price'][$key];
            $product_rate->sale_price = $request['sale_price'][$key];
            $product_rate->save();
        }
        // $str_arr = explode ("}", $request['name']);
        
        
        return redirect('purchase')->with(['success'=> 'Stock Added!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_Data = Product::with('ProductSource')->where('stock_order_id',$id)->get();
        return view('product.view',compact('product_Data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Product_Data = Product::with('ProductSource')->where('stock_order_id',$id)->get();
        $ProductSource_list = ProductSource::all();
        $ProductMaster_list = ProductMaster::all();
        return view('product.edit',compact('Product_Data','ProductSource_list','ProductMaster_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $products)
    {
        // dd($request->all());
        foreach ($request['id'] as $key => $value) {
            $product = Product::where('id',$value)->first();
            $stock_data = Stock::where('product_id',$value)->first();
            $delivery_qty = $stock_data->purchase_quantity - $stock_data->available_quantity;
            $updated_delivery_qty = $request['purchase_qty'][$key] - $delivery_qty;
            if ($updated_delivery_qty < 0) {
                return redirect('purchase')->with(['error'=> 'Your Privious Purchase qty for '.$request['name'][$key].' is deliverd So You can not decrese your purchase qty']);
            } else {
                $stock_data->purchase_quantity = $request['purchase_qty'][$key];
                $stock_data->available_quantity = $request['purchase_qty'][$key] - $delivery_qty;
                $stock_data->save();
            }
            // $str_arr = explode ("}", $request['name']);
            $product->name = $request['name'][$key];
            $product->img = $request['img'][$key];
            $product->product_source_id = $request['product_source_id'];
            $product->purchase_price = $request['purchase_price'][$key];
            $product->bulk_sale_price = $request['bulk_sale_price'][$key];
            $product->transport_expence = $request['transport_expence'];
            $product->status = $request['status'];
            $product->purchase_qty = $request['purchase_qty'][$key];
            $product->order_amount = $request['net_amt'][$key];
            $product->sale_price = $request['sale_price'][$key];
            $product->order_date = $request['order_date'];
            $product->invoice_no = $request['invoice_no'];
            $product->total_order_amt = $request['order_amount'];
            $product->save();

            

            $product_rate = new ProductRate();
            $product_rate->product_id = $value;
            $product_rate->purchase_qty = $request['purchase_qty'][$key];
            $product_rate->purchase_price = $request['purchase_price'][$key];
            $product_rate->transport_expence = $request['transport_expence'];
            $product_rate->order_amount = $request['net_amt'][$key];
            $product_rate->bulk_sale_price = $request['bulk_sale_price'][$key];
            $product_rate->sale_price = $request['sale_price'][$key];
            $product_rate->save();
        }
        
        return redirect('purchase')->with(['success'=> 'Stock Record Updated!!']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        // $post = Product::where('id',$_GET['id'])->first();
        // echo "<pre>"; print_r($_GET['id']); echo "</pre>"; die('end of code');
        // if ($post != null) {
        //     unlink(storage($post->img));
        //     $post->delete();
        //     return redirect('product')->with(['success'=> 'Successfully deleted!!']);
        // }
        // return redirect('product');
    }

    public function delete(){
        $post = Product::where('stock_order_id',$_GET['id'])->get();
        foreach ($variable as $key => $value) {
            $post->status = 0;
            $post->save();
        }
        return redirect('purchase')->with(['success'=> 'Stock Record Deleted!!']);
    }


    public function sgp(){
        $sgp = ManageSgp::OrderBy('id','DESC')->first();
        return view('product.manage_sgp',compact('sgp'));
    }

    public function sgpstore(Request $request){
        $sgp = ManageSgp::OrderBy('id','DESC')->first();
        if ($sgp) {
            //update
            $sgp->value = $request['value'];
            $sgp->save();
            return redirect('manage-sgp')->with(['success'=> 'updated Successful!!']);
        } else {
            //insert
            $sgp = new ManageSgp();
            $sgp->value = $request['value'];
            $sgp->save();
            return redirect('manage-sgp')->with(['success'=> 'Save Successful!!']);
        }
    }
}
