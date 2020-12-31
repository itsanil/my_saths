<?php

namespace App\Http\Controllers;

use App\Order;
use App\Customer;
use App\Product;
use App\PaymentType;
use App\CustomerDiscount;
use App\Stock;
use App\Tag;
use App\Brand;
use App\ProductCombo;
use App\ProductRate;
use App\ProductMaster;
use App\OtpVerification;
use App\ManageSgp;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use Auth;
use Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $order_list = Order::with('customer')->get();
        // return view('order.customer_list');
        return view('order.all_order');
        // return view('order.index',compact('order_list'));
    }

    public function orderCustomer(){
        return view('order.index');
    }

    public function OrderList(){
        // echo "<pre>"; print_r($_GET['id']); echo "</pre>"; die('end of code');
       return view('order.order_list');
    }

    public function sale(){
        $order_list = Order::with('customer')->get();
        return view('order.sale_report',compact('order_list'));
    }

    public function orderdata(Request $request){
        $StartDate = $request['StartDate'];
        $EndDate = $request['EndDate'];
        $id = $request['id'];
        
        if ($StartDate == 'all') {
            $order_list = Order::with('customer')->where('customer_id',$id)->orderBy('id','DESC')->get();
        } else {
            // $StartDate =  Carbon::createFromFormat('Y-m-d', $StartDate)->toDateTimeString();
            // $EndDate =  Carbon::createFromFormat('Y-m-d', $EndDate)->toDateTimeString();
            $order_list = Order::with('customer')->where('customer_id',$id)->whereBetween('order_date',[$StartDate,$EndDate])->orderBy('id','DESC')->get();
        }
        // dd($order_list);
        if($id == 'all'){
            if ($StartDate == 'Invalid date' || $StartDate == 'all') {
                $order_list = Order::with('customer')->orderBy('id','DESC')->get();
            } else {
                // $StartDate =  Carbon::createFromFormat('Y-m-d', $StartDate)->toDateTimeString();
                // $EndDate =  Carbon::createFromFormat('Y-m-d', $EndDate)->toDateTimeString();
                $order_list = Order::with('customer')->whereBetween('order_date',[$StartDate,$EndDate])->orderBy('id','DESC')->get();
            }
        }
        // echo "<pre>"; print_r($StartDate); echo "</pre>"; die('end of code');
        return DataTables::of($order_list)
        ->addColumn('name', function ($order_list) {
            return $order_list->customer->name.'-('.$order_list->customer->whatsapp_no.')' ;
        })
        ->addColumn('whatsapp_no', function ($order_list) {
            return $order_list->customer->whatsapp_no;
        })
        ->addColumn('status', function ($order_list) {
            if ($order_list->delivery_status == 1 && $order_list->payment_status == 1) {
                return '<span class="badge badge-success">success</span>';
            }
            if ($order_list->delivery_status == 1 && $order_list->payment_status == 0) {
                return '<span class="badge badge-danger">payment pending</span>';
            }
            if ($order_list->delivery_status == 0 && $order_list->payment_status == 1) {
                return '<span class="badge badge-danger">delivery pending</span>';
            }
            if ($order_list->order_status == 'cancel' ) {
                return '<span class="badge badge-danger">cancel</span>';
            }if ($order_list->order_status == 'approved' ) {
                return '<span class="badge badge-success">approved</span>';
            } else {
                return '<span class="badge badge-danger">pending</span>';
            }
        })
        ->addColumn('action', function ($value) {
            if ($value->order_status == 'approved' ) {
                $encryptid = substr($value->id.md5($value->id), 0, 7);

                $invoice = '&nbsp;<a class="btn btn-success btn-sm" target="_blank"  href="'.url('/getinvoice?id=').$encryptid.'">
                            <i class="fas fa-copy" style="color: #ffff;">
                              </i>
                            </a>';
            } else {
                $invoice = '';
            }
            if ($value->delivery_status == 1 && $value->payment_status == 1) {
                $delete = '';
            } else {
                $delete = '&nbsp;<a class="btn btn-danger btn-sm"  onclick="Delete('.$value->id.');">
                      <i class="fas fa-trash" style="color: #ffff;">
                      </i>
                    </a>';
            }
            if (Auth::user()->hasRole('customer')) {
                // $edit_url = 'my-order.edit';
                if ($value->order_status == 'cancel' ) {
                    return  '<a class="btn btn-primary btn-sm"  href="'.route('customer-orders.details',$value->id).'">
                          <i class="fas fa-eye">
                          </i>
                    </a>';
                }
                if ($value->order_status == 'approved' ) {
                        $delete = '';
                        return  '<a class="btn btn-primary btn-sm"  href="'.route('customer-orders.details',$value->id).'">
                              <i class="fas fa-eye">
                              </i>
                        </a>'.$invoice;
                }else{
                    return  '<a class="btn btn-primary btn-sm"  href="'.route('customer-orders.details',$value->id).'">
                              <i class="fas fa-eye">
                              </i>
                        </a>'.$delete;
                }
            } else {
                $edit_url = 'customer-orders.edit';
            }
            if ($value->order_status == 'cancel' ) {
                return  '<a class="btn btn-primary btn-sm"  href="'.route('customer-orders.details',$value->id).'">
                      <i class="fas fa-eye">
                      </i>
                </a>';
            }
                return  '<a class="btn btn-primary btn-sm"  href="'.route('customer-orders.details',$value->id).'">
                              <i class="fas fa-eye">
                              </i>
                        </a>
                        <a class="btn btn-info btn-sm"  href="'.route($edit_url,$value->id).'">
                              <i class="fas fa-pencil-alt" >
                              </i>
                        </a>'.$invoice.$delete;
            
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(empty(Auth::user())){
            return redirect('customer-login');   
        }

        $customer_list = Customer::where('status',1)->get();
        $stock_data = Stock::all();
        $product_list = Product::all();
        foreach ($product_list as $key => $value) {
            $check_product_entry = 0; 
            foreach ($stock_data as $keys => $values) {
               if($values->product_id == $value->id){
                    $check_product_entry++; 
                    $product_list[$key]->available_qty = $values->available_quantity; 
               }
           }
           if($check_product_entry == 0){
                $product_list[$key]->available_qty = $value->purchase_qty;
           }
        }
        $unique_product_list = array();
        $sgp = ManageSgp::orderBy('id','DESC')->first();
        foreach ($product_list as $key => $value) {
            if($value->available_qty != 0){
                $product_id = '';
                $available_qty = 0;
                $sale_price = 0;
                $bulk_sale_price = 0;
                $purchase_price = 0;
                foreach ($product_list as $keys => $values) {
                    // if($values->available_qty != 0){
                        if($value->name == $values->name){
                            $product_id .= $values->id.'_';
                            $available_qty += $values->available_qty;
                            $sale_price = $values->sale_price;
                            $bulk_sale_price = $values->bulk_sale_price;
                            $purchase_price = $values->purchase_price;
                        }
                    // }
                }  
                $unique_product_list[$value->name]['id'] = rtrim($product_id, "_"); 
                $unique_product_list[$value->name]['name'] = $value->name; 
                $unique_product_list[$value->name]['available_qty'] = $available_qty;
                $product_master = ProductMaster::where('name',$value->name)->first();
                if ($sgp && $product_master->mrp) {
                  if (round($sale_price + ($product_master->mrp * $sgp->value/100)) > $product_master->mrp) {
                    $unique_product_list[$value->name]['sale_price'] = $product_master->mrp;
                  } else {
                    $unique_product_list[$value->name]['sale_price'] = round($sale_price + ($product_master->mrp * $sgp->value/100));
                  }
                } else {
                  $unique_product_list[$value->name]['sale_price'] = $sale_price;
                } 
                if ($sgp && $product_master->mrp) {
                  if (round($bulk_sale_price + ($product_master->mrp * $sgp->value/100)) > $product_master->mrp) {
                    $unique_product_list[$value->name]['bulk_sale_price'] = $product_master->mrp;
                  } else {
                    $unique_product_list[$value->name]['bulk_sale_price'] = round($bulk_sale_price + ($product_master->mrp * $sgp->value/100));
                  }
                } else {
                  $unique_product_list[$value->name]['bulk_sale_price'] = $bulk_sale_price;
                } 
                // $unique_product_list[$value->name]['sale_price'] = $sale_price; 
                // $unique_product_list[$value->name]['bulk_sale_price'] = $bulk_sale_price; 
                $unique_product_list[$value->name]['purchase_price'] = $purchase_price; 
            }
        }

        $combo = ProductCombo::where('status','Active')->get();
        foreach ($combo as $key => $value) {
            $unique_product_list[$value->product_combo_name]['id'] = $value->id.'-combo';
            $unique_product_list[$value->product_combo_name]['name'] = $value->product_combo_name;
            $qty_status = false;
            $qty = 0;
            $purchase_price = 0;
            $mrp = 0;
            $name_array = array();
            $id_array = array();
            $a_array = array();
            //get available qty
            foreach (json_decode(json_decode($value->product_list)->id) as $keyss => $valuess) {
                  $stock_data = Stock::where('product_id',$valuess)->orderBy('id','DESC')->first();
                  $p_data = Product::where('id',$valuess)->orderBy('id','DESC')->first();
                  $master = ProductMaster::where('name',$p_data->name)->first();
                  if(isset($master->mrp)){
                    $mrp += $master->mrp*json_decode(json_decode($value->product_list)->qty)[$keyss];
                  }
                  $pro_id = Product::where('name',$p_data->name)->orderBy('id','DESC')->pluck('id');
                  $avail_qty = 0;
                  foreach ($pro_id as $i => $id) {
                    $stock = Stock::where('product_id',$id)->orderBy('id','DESC')->first();
                    $avail_qty += $stock->available_quantity;

                  }
                  $a_array[] = $avail_qty/json_decode(json_decode($value->product_list)->qty)[$keyss];
                  $purchase_price += $p_data->purchase_price * json_decode(json_decode($value->product_list)->qty)[$keyss];
                  $id_array[] = $valuess;
                  $qty_arry[] = json_decode(json_decode($value->product_list)->qty)[$keyss];
            }
            if ($sgp) {
                  if (round($value->combo_price + ($mrp * $sgp->value/100)) > $mrp) {
                    $unique_product_list[$value->product_combo_name]['sale_price'] = $mrp;
                    $unique_product_list[$value->product_combo_name]['bulk_sale_price'] = $mrp;
                  } else {
                    $unique_product_list[$value->product_combo_name]['sale_price'] = round($value->combo_price + ($mrp * $sgp->value/100));
                    $unique_product_list[$value->product_combo_name]['bulk_sale_price'] = round($value->combo_price + ($mrp * $sgp->value/100));
                  }
            } else {
              $unique_product_list[$value->product_combo_name]['sale_price'] = $value->combo_price;
              $unique_product_list[$value->product_combo_name]['bulk_sale_price'] = $value->combo_price;
            }
            $unique_product_list[$value->product_combo_name]['id_array'] = json_encode($id_array);
            $unique_product_list[$value->product_combo_name]['qty_arry'] = json_encode(json_decode(json_decode($value->product_list)->qty));
            $unique_product_list[$value->product_combo_name]['purchase_price'] = $purchase_price;
            $unique_product_list[$value->product_combo_name]['available_qty'] = explode('.', min($a_array))[0];
            if($qty_status == true){
               $unique_product_list[$value->product_combo_name]['available_qty'] = 0; 
            }
        }
        $payment_type_list = PaymentType::all();
            // echo "<pre>"; print_r($unique_product_list); echo "</pre>"; die('end of code');
        
        if(!empty(Auth::user()) && Auth::user()->hasRole('admin')){
            return view('order.create',compact('customer_list','product_list','payment_type_list','unique_product_list'));   
        }
        else{
            $cart = Session::get('cart_product');
            $cart_product_id_array = explode(',', $cart);
            if (isset($cart_product_id_array) && $cart_product_id_array[0] != '') {
                $cart_count =  count($cart_product_id_array);
              } else {
                $cart_count = 0;
              }
            $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
            $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
            return view('customer.order_create',compact('customer_list','product_list','payment_type_list','unique_product_list','cart_product_id_array','tag_list','brand_list','cart','cart_count'));
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
      $sgp = ManageSgp::orderBy('id','DESC')->first();
        if(Auth::user()->hasRole('admin')){
            // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
            $order_product_id = $request['product_id'];
            $order_product_qty = $request['product_qty'];
            $order_available_qty = $request['available_qtys'];
            foreach ($order_product_qty as $key => $value) {
                $final_available_qty[] = $order_available_qty[$key] - $value;
            }
            $payment_status = $request['payment_status'];
            $delivery_status = $request['delivery_status'];
            if ($delivery_status == 1) {//sucsess order
              // echo "<pre>"; print_r($order_product_qty); echo "</pre>"; die('end of code');
              // echo "<pre>"; print_r($order_product_id); echo "</pre>"; die('end of code');
                foreach ($order_product_id as $keys => $values) {
                    if (strpos($values, '_')) {
                        $stock_order_qty_by_part = $order_product_qty[$keys];
                        $product_id_array = explode('_', $values);
                            foreach ($product_id_array as $keys => $id) {
                                $product_data = Product::where('id',$id)->first();
                                $stock_data = Stock::where('product_id',$id)->first();
                                //check order qty is greater than available qty or not
                                if ($stock_data->count() == 0) {
                                    if ($stock_order_qty_by_part >= $product_data->purchase_qty) {
                                        $stock_product = new Stock();
                                        $stock_product->product_id =$values;
                                        $stock_product->purchase_quantity =$product_data->purchase_qty;
                                        $stock_product->available_quantity = 0;
                                        $stock_product->save();
                                        $product_data = Product::where('id',$id)->first();
                                        $product_data->status = 0;
                                        $product_data->save();
                                        $stock_order_qty_by_part -= $product_data->purchase_qty;
                                    } else {
                                        $stock_product = new Stock();
                                        $stock_product->product_id =$values;
                                        $stock_product->purchase_quantity =$product_data->purchase_qty;
                                        $stock_product->available_quantity = $product_data->purchase_qty - $stock_order_qty_by_part;
                                        $stock_product->save();
                                        $stock_order_qty_by_part = 0;
                                    }
                                }else {
                                    //update entry
                                    if ($stock_order_qty_by_part >= $stock_data->available_quantity) {
                                        $stock_product = Stock::where('product_id',$id)->first();
                                        $stock_order_qty_by_part -= $stock_product->available_quantity;
                                        $stock_product->available_quantity = 0;
                                        $stock_product->save();
                                        $product_data = Product::where('id',$id)->first();
                                        $product_data->status = 0;
                                        $product_data->save();
                                    } else {
                                        $stock_product = Stock::where('product_id',$id)->first();
                                        $stock_product->available_quantity = $stock_product->available_quantity -  $stock_order_qty_by_part;
                                        $stock_product->save();
                                        $stock_order_qty_by_part = 0;
                                    }
                                    
                                }
                                
                            }
                    }else{
                        if (strpos($values, 'combo')) {
                            $combo_data = ProductCombo::where('id',explode('-', $values)[0])->first();
                            $mrp = 0;
                            foreach (json_decode(json_decode($combo_data->product_list)->id) as $keyss => $valuess) {
                                $stock_order_qty_by_part = $order_product_qty[$keys]*json_decode(json_decode($combo_data->product_list)->qty)[$keyss];
                                $product_name = Product::where('id',$valuess)->first();
                                $product_id_array = Product::where('name',$product_name->name)->get()->pluck('id');
                                // echo "<pre>"; print_r($product_name); echo "</pre>"; die('end of code');
                                foreach ($product_id_array as $keys => $id) {
                                  $product_data = Product::where('id',$id)->first();
                                  $stock_data = Stock::where('product_id',$id)->first();
                                  //check order qty is greater than available qty or not
                                  if ($stock_data->count() == 0) {
                                      if ($stock_order_qty_by_part >= $product_data->purchase_qty) {
                                          $stock_product = new Stock();
                                          $stock_product->product_id =$values;
                                          $stock_product->purchase_quantity =$product_data->purchase_qty;
                                          $stock_product->available_quantity = 0;
                                          $stock_product->save();
                                          $product_data = Product::where('id',$id)->first();
                                          $product_data->status = 0;
                                          $product_data->save();
                                          $stock_order_qty_by_part -= $product_data->purchase_qty;
                                      } else {
                                          $stock_product = new Stock();
                                          $stock_product->product_id =$values;
                                          $stock_product->purchase_quantity =$product_data->purchase_qty;
                                          $stock_product->available_quantity = $product_data->purchase_qty - $stock_order_qty_by_part;
                                          $stock_product->save();
                                          $stock_order_qty_by_part = 0;
                                      }
                                  }else {
                                      //update entry
                                      if ($stock_order_qty_by_part >= $stock_data->available_quantity) {
                                          $stock_product = Stock::where('product_id',$id)->first();
                                          $stock_order_qty_by_part -= $stock_product->available_quantity;
                                          $stock_product->available_quantity = 0;
                                          $stock_product->save();
                                          $product_data = Product::where('id',$id)->first();
                                          $product_data->status = 0;
                                          $product_data->save();
                                      } else {
                                          $stock_product = Stock::where('product_id',$id)->first();
                                          $stock_product->available_quantity = $stock_product->available_quantity -  $stock_order_qty_by_part;
                                          $stock_product->save();
                                          $stock_order_qty_by_part = 0;
                                      }
                                      
                                  }
                                  
                                }
                            }
                        } else {
                            $product_data = Product::where('id',$values)->first();
                            $stock_data = Stock::where('product_id',$values)->get();
                            // $stock_order_qty_by_part = $order_product_qty[$keys];
                            if ($stock_data->count() == 0) {
                              //insert new entry
                                $stock_product = new Stock();
                                $stock_product->product_id =$values;
                                $stock_product->purchase_quantity =$product_data->purchase_qty;
                                $stock_product->available_quantity = $final_available_qty[$keys];
                                $stock_product->save();
                            } else {
                                //update entry
                                $stock_data = Stock::where('product_id',$values)->first();
                                $stock_data->available_quantity = $final_available_qty[$keys];
                                $stock_data->save();
                            }

                            if ($final_available_qty[$keys] == 0) {
                                $product_data = Product::where('id',$values)->first();
                                $product_data->status = 0;
                                $product_data->save();
                            }  
                        }
                    }
                }
            }
            //order entry
            
            foreach ($order_product_id as $key => $value) {
                $product_id_array = explode('_', $value); 
                $c = count($product_id_array); 
                $product_data = Product::where('id',$product_id_array[$c-1])->first();
                $product['product_id'][] = $value;
                $product['available_qty'][] =$order_available_qty[$key];
                $product['order_qty'][] =$order_product_qty[$key];
                if (strpos($value, 'combo')) {
                    $combo_data = ProductCombo::where('id',explode('-', $value)[0])->first();
                    $mrp = 0;
                    foreach (json_decode(json_decode($combo_data->product_list)->id) as $keyss => $valuess) {
                        $p_data = Product::where('id',$valuess)->orderBy('id','DESC')->first();
                        $master = ProductMaster::where('name',$p_data->name)->first();
                        if(isset($master->mrp)){
                        $mrp += $master->mrp*json_decode(json_decode($combo_data->product_list)->qty)[$keyss];
                        }
                    }
                    if ($sgp) {
                        if (round($combo_data->combo_price + ($mrp * $sgp->value/100)) > $mrp) {
                            $product_data->bulk_sale_price = $mrp;
                        } else {
                            $product_data->bulk_sale_price = round($combo_data->combo_price + ($mrp * $sgp->value/100));
                        }
                    } else {
                        $product_data->bulk_sale_price = $combo_data->combo_price;
                    }
                    $product['per_price'][] = $product_data->bulk_sale_price;
                    $product['sub_price'][] = $order_product_qty[$key]*$product_data->bulk_sale_price;
                } else {
                    $product_master = ProductMaster::where('name',$product_data->name)->first();
                    if ($sgp && $product_master->mrp) {
                        if (round($product_data->sale_price + ($product_master->mrp * $sgp->value/100)) > $product_master->mrp) {
                            $product_data->sale_price = $product_master->mrp;
                        } else {
                            $product_data->sale_price = round($product_data->sale_price + ($product_master->mrp * $sgp->value/100));
                        }
                    } else {
                        $product_data->sale_price = $product_data->sale_price;
                    }
                    if ($sgp && $product_master->mrp) {
                        if (round($product_data->sale_price + ($product_master->mrp * $sgp->value/100)) > $product_master->mrp) {
                            $product_data->bulk_sale_price = $product_master->mrp;
                        } else {
                            $product_data->bulk_sale_price = round($product_data->bulk_sale_price + ($product_master->mrp * $sgp->value/100));
                        }
                    } else {
                        $product_data->bulk_sale_price = $product_data->bulk_sale_price;
                    } 
                    if($request['price_type'] == 'Bulk Price'){
                        $product['per_price'][] = $product_data->bulk_sale_price;
                        $product['sub_price'][] = $order_product_qty[$key]*$product_data->bulk_sale_price;
                    }else{
                        $product['per_price'][] = $product_data->sale_price;    
                        $product['sub_price'][] = $order_product_qty[$key]*$product_data->sale_price;    
                    }
                }
                
                
            }
            $invoice_sent = 0;
            if ($request['order_status'] == 'approved') {
                $invoice_sent = 1;
            }

            $order = new Order();
            $order->customer_id = $request['customer_id'];
            $order->order_product = json_encode($product);
            $order->delivery_amount = $request['delivery_amount'];
            $order->discount_amount = $request['discount_amount'];
            $order->order_amt = $request['order_amount'];
            $order->order_date = $request['order_date'];
            $order->delivery_status = $request['delivery_status'];
            $order->payment_type_id = $request['payment_type_id'];
            $order->payment_status = $request['payment_status'];
            $order->price_type = $request['price_type'];
            $order->order_by = $request['order_by'];
            $order->order_status = $request['order_status'];
            $order->is_invoice_sms_sent = $invoice_sent;
            $order->save();
            if ($request['order_status'] == 'approved') {
                $customer_data = Customer::where('id',$request['customer_id'])->first();
                $this->Sendinvoice(array('mobile_no'=>$customer_data->whatsapp_no,'order_id'=>substr($order->id.md5($order->id), 0, 7)));
            }
            if($request['voucher_id'] != 0){
                //entery in customer_discounts
                $data = new CustomerDiscount();
                $data->customer_id = $request['customer_id'];
                $data->voucher_id = $request['voucher_id'];
                $data->order_id = $order->id;
                $data->save();
            }

                return redirect('customer-orders')->with(['success'=> 'Order Added!!']);
        }
        if(Auth::user()->hasRole('customer')){
            $order_product_id = $request['product_id'];
            $order_product_qty = $request['product_qty'];
            $order_available_qty = $request['available_qty'];
            $payment_status = 0;
            $delivery_status = 0;
            //order entry
            foreach ($order_product_id as $key => $value) {
                $product_id_array = explode('_', $value); 
                $c = count($product_id_array); 
                $product_data = Product::where('id',$product_id_array[$c-1])->first();
                $product['product_id'][] = $value;
                $product['available_qty'][] =$order_available_qty[$key];
                $product['order_qty'][] =$order_product_qty[$key];
                if ($sgp && $product_master->mrp) {
                    if (round($product_data->sale_price + ($product_master->mrp * $sgp->value/100)) > $product_master->mrp) {
                        $product_data->sale_price = $product_master->mrp;
                    } else {
                        $product_data->sale_price = round($product_data->sale_price + ($product_master->mrp * $sgp->value/100));
                    }
                } else {
                    $product_data->sale_price = $product_data->sale_price;
                }
                if ($sgp && $product_master->mrp) {
                    if (round($product_data->sale_price + ($product_master->mrp * $sgp->value/100)) > $product_master->mrp) {
                        $product_data->bulk_sale_price = $product_master->mrp;
                    } else {
                        $product_data->bulk_sale_price = round($product_data->bulk_sale_price + ($product_master->mrp * $sgp->value/100));
                    }
                } else {
                    $product_data->bulk_sale_price = $product_data->bulk_sale_price;
                } 
                if($request['price_type'] == 'Bulk Price'){
                    $product['per_price'][] = $product_data->bulk_sale_price;
                    
                    $product['sub_price'][] = $order_product_qty[$key]*$product_data->bulk_sale_price;
                }else{
                    $product['per_price'][] = $product_data->sale_price;    
                    $product['sub_price'][] = $order_product_qty[$key]*$product_data->sale_price;    
                }
            }

            $order = new Order();
            $order->customer_id = $request['customer_id'];
            $order->order_product = json_encode($product);
            $order->delivery_amount = 0;
            $order->discount_amount = $request['discount_amount'];
            $order->order_amt = $request['order_amount'];
            $order->order_date = $request['order_date'];
            $order->delivery_status = 0;
            $order->payment_type_id = 1;
            $order->payment_status = 0;
            $order->price_type = $request['price_type'];
            $order->order_by = 'customer';
            $order->order_status = 'pending';
            $order->save();
            if($request['voucher_id'] != 0){
                //entery in customer_discounts
                $data = new CustomerDiscount();
                $data->customer_id = $request['customer_id'];
                $data->voucher_id = $request['voucher_id'];
                $data->order_id = $order->id;
                $data->save();
            }
            //clear session
            session::forget('cart_product');
            $this->Sendnotification(array('mobile_no'=>Auth::User()->mobile,'name'=>Auth::User()->name));
            return redirect('my-order')->with(['success'=> 'Thank You, we have received your order #'.$order->id.', the same shall be processed in next few hours and invoice for the same shall be sent to you via SMS on your registered number.']);
        }
        // echo "<pre>"; print_r($request->path()); echo "</pre>"; die('end of code');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(){
        return view('order.index');
    }
    public function orderdetails($id)
    {
        $Order_data = Order::with('customer')->with('PaymentType')->where('id',$id)->first();
        $order_product_qty = json_decode($Order_data->order_product)->order_qty;
        $order_product_id = json_decode($Order_data->order_product)->product_id;
        $price_type = $Order_data->price_type;
        // echo "<pre>"; print_r(json_decode($Order_data->order_product)->sub_price); echo "</pre>"; die('end of code');
        foreach ($order_product_id as $key => $product_id) {
            $product_id_array = explode('_', $product_id);
            $c = count($product_id_array); 
            $product_data = Product::where('id',$product_id_array[$c-1])->first();
            if (strpos($product_id, 'combo')) {
                $combo_data = ProductCombo::where('id',explode('-', $product_id)[0])->first();
                $product['name'][] = $combo_data->product_combo_name;
                $product['img'][] = $product_data->photo;
                $product['order_qty'][] = $order_product_qty[$key];
                $product['price'][] = json_decode($Order_data->order_product)->per_price[$key];
                $product['sub_price'][] = json_decode($Order_data->order_product)->sub_price[$key];
            }else{
              $product['name'][] = $product_data->name;
              $product['img'][] = $product_data->img;
              $product['order_qty'][] = $order_product_qty[$key];
              $product['price'][] = json_decode($Order_data->order_product)->per_price[$key];
              $product['sub_price'][] = json_decode($Order_data->order_product)->sub_price[$key];
           }

        }

        // $product_photo = 
        return view('order.view',compact('Order_data','product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $customer_list = Customer::where('status',1)->get();
        $stock_data = Stock::all();
        $product_list = Product::all();
        $Order_data = Order::where('id',$id)->first();
        $products_list = Product::all();
        $sgp = ManageSgp::orderBy('id','DESC')->first();
        $later_order_product_qty = json_decode($Order_data->order_product)->order_qty;
        $later_order_product_id = json_decode($Order_data->order_product)->product_id;
        foreach ($products_list as $key => $value) {
            $check_product_entry = 0; 
            foreach ($stock_data as $keys => $values) {
               if($values->product_id == $value->id){
                    $check_product_entry++; 
                    if ($Order_data->delivery_status == 1) {
                        foreach ($later_order_product_id as $keyss => $valuess) {
                            if($valuess == $values->product_id){
                                $products_list[$key]->available_qty = $values->available_quantity + $later_order_product_qty[$keyss];
                            }else {
                                $products_list[$key]->available_qty = $values->available_quantity;
                            }
                        }
                    }else{
                            $products_list[$key]->available_qty = $values->available_quantity;
                    } 

                }
            }
        }
        foreach ($product_list as $key => $value) {
            $check_product_entry = 0; 
            foreach ($stock_data as $keys => $values) {
               if($values->product_id == $value->id){
                    $check_product_entry++; 
                    if ($Order_data->delivery_status == 1) {
                        foreach ($later_order_product_id as $keyss => $valuess) {
                            if($valuess == $values->product_id){
                                $product_list[$key]->available_qty = $values->available_quantity + $later_order_product_qty[$keyss];
                            }
                        }
                    } else {
                         $product_list[$key]->available_qty = $values->available_quantity;
                    }
               }else{
                    $product_list[$key]->available_qty = $value->purchase_qty;
               }
           }
           if($check_product_entry == 0){
                $product_list[$key]->available_qty = $value->purchase_qty;
           }
        }
        foreach ($product_list as $key => $value) {
            $check_product_entry = 0; 
            foreach ($stock_data as $keys => $values) {
               if($values->product_id == $value->id){
                    $check_product_entry++; 
                    $product_list[$key]->available_qty = $values->available_quantity; 
               }
           }
           if($check_product_entry == 0){
                $product_list[$key]->available_qty = $value->purchase_qty;
           }

        }
        $unique_product_list = array();
        foreach ($product_list as $key => $value) {
            // if($value->available_qty != 0){
                $product_id = '';
                $available_qty = 0;
                $sale_price = 0;
                $bulk_sale_price = 0;
                $purchase_price = 0;
                foreach ($product_list as $keys => $values) {
                    // if($value->available_qty != 0){
                        if($value->name == $values->name){
                            $product_id .= $values->id.'_';
                            $available_qty += $values->available_qty;
                            $sale_price = $values->sale_price;
                            $bulk_sale_price = $values->bulk_sale_price;
                            $purchase_price = $values->purchase_price;
                        // }
                    }
                }  
                if ($Order_data->delivery_status == 1) {
                    foreach ($later_order_product_id as $keyss => $valuess) {
                        // echo "<pre>"; print_r($valuess); echo "</pre>"; die('end of code');
                        // if($valuess == rtrim($product_id, "_")){
                        if(!empty(array_intersect(explode('_', $valuess), explode('_', $product_id)))){
                            $available_qty += $later_order_product_qty[$keyss];
                        }
                    }
                }
                $unique_product_list[$value->name]['id'] = rtrim($product_id, "_"); 
                $unique_product_list[$value->name]['name'] = $value->name; 
                $unique_product_list[$value->name]['available_qty'] = $available_qty; 
                $product_master = ProductMaster::where('name',$value->name)->first();
                if ($sgp && $product_master->mrp) {
                  if (round($sale_price + ($product_master->mrp * $sgp->value/100)) > $product_master->mrp) {
                    $unique_product_list[$value->name]['sale_price'] = $product_master->mrp;
                  } else {
                    $unique_product_list[$value->name]['sale_price'] = round($sale_price + ($product_master->mrp * $sgp->value/100));
                  }
                } else {
                  $unique_product_list[$value->name]['sale_price'] = $sale_price;
                } 
                if ($sgp && $product_master->mrp) {
                  if (round($bulk_sale_price + ($product_master->mrp * $sgp->value/100)) > $product_master->mrp) {
                    $unique_product_list[$value->name]['bulk_sale_price'] = $product_master->mrp;
                  } else {
                    $unique_product_list[$value->name]['bulk_sale_price'] = round($bulk_sale_price + ($product_master->mrp * $sgp->value/100));
                  }
                } else {
                  $unique_product_list[$value->name]['bulk_sale_price'] = $bulk_sale_price;
                }
                // $unique_product_list[$value->name]['sale_price'] = $sale_price; 
                // $unique_product_list[$value->name]['bulk_sale_price'] = $bulk_sale_price; 
                $unique_product_list[$value->name]['purchase_price'] = $purchase_price; 
            // }
        }
        $combo = ProductCombo::where('status','Active')->get();
        foreach ($combo as $key => $value) {
           $unique_product_list[$value->product_combo_name]['id'] = $value->id.'-combo';
            $unique_product_list[$value->product_combo_name]['name'] = $value->product_combo_name;
            $qty_status = false;
            $qty = 0;
            $purchase_price = 0;
            $mrp = 0;
            $name_array = array();
            $id_array = array();
            $a_array = array();
            //get available qty
            foreach (json_decode(json_decode($value->product_list)->id) as $keyss => $valuess) {
                  $stock_data = Stock::where('product_id',$valuess)->orderBy('id','DESC')->first();
                  $p_data = Product::where('id',$valuess)->orderBy('id','DESC')->first();
                  $master = ProductMaster::where('name',$p_data->name)->first();
                  if(isset($master->mrp)){
                    $mrp += $master->mrp*json_decode(json_decode($value->product_list)->qty)[$keyss];
                  }
                  $pro_id = Product::where('name',$p_data->name)->orderBy('id','DESC')->pluck('id');
                  $avail_qty = 0;
                  foreach ($pro_id as $i => $id) {
                    $stock = Stock::where('product_id',$id)->orderBy('id','DESC')->first();
                    $avail_qty += $stock->available_quantity;

                  }
                  $a_array[] = $avail_qty/json_decode(json_decode($value->product_list)->qty)[$keyss];
                  $purchase_price += $p_data->purchase_price * json_decode(json_decode($value->product_list)->qty)[$keyss];
                  $id_array[] = $valuess;
                  $qty_arry[] = json_decode(json_decode($value->product_list)->qty)[$keyss];
            }
            if ($sgp) {
                  if (round($value->combo_price + ($mrp * $sgp->value/100)) > $mrp) {
                    $unique_product_list[$value->product_combo_name]['sale_price'] = $mrp;
                    $unique_product_list[$value->product_combo_name]['bulk_sale_price'] = $mrp;
                  } else {
                    $unique_product_list[$value->product_combo_name]['sale_price'] = round($value->combo_price + ($mrp * $sgp->value/100));
                    $unique_product_list[$value->product_combo_name]['bulk_sale_price'] = round($value->combo_price + ($mrp * $sgp->value/100));
                  }
            } else {
              $unique_product_list[$value->product_combo_name]['sale_price'] = $value->combo_price;
              $unique_product_list[$value->product_combo_name]['bulk_sale_price'] = $value->combo_price;
            }
            $unique_product_list[$value->product_combo_name]['id_array'] = json_encode($id_array);
            $unique_product_list[$value->product_combo_name]['qty_arry'] = json_encode(json_decode(json_decode($value->product_list)->qty));
            $unique_product_list[$value->product_combo_name]['purchase_price'] = $purchase_price;
            $unique_product_list[$value->product_combo_name]['available_qty'] = explode('.', min($a_array))[0];
            if($qty_status == true){
               $unique_product_list[$value->product_combo_name]['available_qty'] = 0; 
            }
            if ($Order_data->delivery_status == 1) {
                foreach ($later_order_product_id as $k => $v) {
                    if($v == $value->id.'-combo'){
                        $unique_product_list[$value->product_combo_name]['available_qty'] += $later_order_product_qty[$k];
                        foreach (json_decode(json_decode($value->product_list)->id) as $keyss => $valuess) {
                          $product = Product::where('id',$valuess)->first();
                          $unique_product_list[$product->name]['available_qty'] += $later_order_product_qty[$k]*json_decode(json_decode($value->product_list)->qty)[$keyss];
                        }
                    }
                }
            }
        }
        // echo "<pre>"; print_r($unique_product_list); echo "</pre>"; die('end of code');
        $voucher_data = CustomerDiscount::with('voucher')->where('order_id',$id)->first();
        $payment_type_list = PaymentType::all();
        // echo "<pre>"; print_r(); echo "</pre>"; die('end of code');
        if(Auth::user()->hasRole('admin')){
            return view('order.edit',compact('customer_list','product_list','payment_type_list','Order_data','products_list','unique_product_list','voucher_data'));
        }
        if(Auth::user()->hasRole('customer')){
            return view('customer.order_edit',compact('customer_list','product_list','payment_type_list','Order_data','products_list','unique_product_list'));  
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
public function update(Request $request)
{
    if(Auth::user()->hasRole('admin')){
        $Order_data = Order::where('id',$request['order_id'])->first();
        $updated_product_id = $request['product_id'];
        $updated_order_product_qty = $request['product_qty'];
        $sgp = ManageSgp::orderBy('id','DESC')->first();
        if ($Order_data->delivery_status == 1) {
            //if order delivery_status is sucsess already and edit then add privious order qty to available stock after then subtract
            // latest order qty
            $later_order_product_qty = json_decode($Order_data->order_product)->order_qty;
            $later_order_product_id = json_decode($Order_data->order_product)->product_id;
            foreach ($later_order_product_id as $key => $product_id) {
                //update entry
                if (strpos($product_id, '_')) {
                        $product_id_array = explode('_', $product_id);
                        $later_order_product_qty_by_id = $later_order_product_qty[$key];
                            foreach ($product_id_array as $keys => $id) {
                                $stock_data = Stock::where('product_id',$id)->first();
                                $sell_qty = $stock_data->purchase_quantity - $stock_data->available_quantity;
                                if ($sell_qty >= $later_order_product_qty_by_id) {
                                    $stock_data->available_quantity =$stock_data->available_quantity + $later_order_product_qty_by_id;
                                    $stock_data->save();
                                    $product_data = Product::where('id',$id)->first();
                                    $product_data->status = 1;
                                    $product_data->save(); 
                                    $later_order_product_qty_by_id = 0;
                                } else {
                                    $stock_data->available_quantity =$stock_data->available_quantity + $sell_qty;
                                    $stock_data->save();
                                    $product_data = Product::where('id',$id)->first();
                                    $product_data->status = 1;
                                    $product_data->save(); 
                                    $later_order_product_qty_by_id -= $sell_qty;
                                }
                            }
                }else{
                  if (strpos($product_id, 'combo')) {
                            $combo_data = ProductCombo::where('id',explode('-', $product_id)[0])->first();
                            $mrp = 0;
                            foreach (json_decode(json_decode($combo_data->product_list)->id) as $keyss => $valuess) {
                                $later_order_product_qty_by_id = $later_order_product_qty[$key]*json_decode(json_decode($combo_data->product_list)->qty)[$keyss];
                                $product_name = Product::where('id',$valuess)->first();
                                $product_id_array = Product::where('name',$product_name->name)->get()->pluck('id');
                                // echo "<pre>"; print_r($product_name); echo "</pre>"; die('end of code');
                                foreach ($product_id_array as $keys => $id) {
                                  $stock_data = Stock::where('product_id',$id)->first();
                                  $sell_qty = $stock_data->purchase_quantity - $stock_data->available_quantity;
                                  if ($sell_qty >= $later_order_product_qty_by_id) {
                                      $stock_data->available_quantity =$stock_data->available_quantity + $later_order_product_qty_by_id;
                                      $stock_data->save();
                                      $product_data = Product::where('id',$id)->first();
                                      $product_data->status = 1;
                                      $product_data->save(); 
                                      $later_order_product_qty_by_id = 0;
                                  } else {
                                      $stock_data->available_quantity =$stock_data->available_quantity + $sell_qty;
                                      $stock_data->save();
                                      $product_data = Product::where('id',$id)->first();
                                      $product_data->status = 1;
                                      $product_data->save(); 
                                      $later_order_product_qty_by_id -= $sell_qty;
                                  }
                              }
                            }
                    }else {
                        $stock_data = Stock::where('product_id',$product_id)->first();
                        $stock_data->available_quantity =$stock_data->available_quantity + $later_order_product_qty[$key];
                        $stock_data->save();  
                        $product_data = Product::where('id',$product_id)->first();
                        $product_data->status = 1;
                        $product_data->save(); 
                    }
                    
                }
               
            }
            // echo "<pre>"; print_r('anil'); echo "</pre>"; die('end of code');
            if ($request['delivery_status'] == 1) {
                foreach ($updated_product_id as $key => $product_id) {
                    //update entry
                  $updated_order_product_qty_by_id = $updated_order_product_qty[$key];
                    // echo "<pre>"; print_r($updated_order_product_qty[$key]); echo "</pre>"; die('end of code');
                    if (strpos($product_id, '_')) {
                        $product_id_array = explode('_', $product_id);
                        
                            foreach ($product_id_array as $keys => $id) {
                                $stock_data = Stock::where('product_id',$id)->first();
                                if ($stock_data->available_quantity >= $updated_order_product_qty_by_id) {
                                    $stock_data->available_quantity = $stock_data->available_quantity - $updated_order_product_qty_by_id;
                                    $stock_data->save();
                                    $updated_order_product_qty_by_id = 0;
                                } else {
                                    $updated_order_product_qty_by_id -= $stock_data->available_quantity;
                                    $stock_data->available_quantity = 0;
                                    $stock_data->save();
                                    $product_data = Product::where('id',$id)->first();
                                    $product_data->status = 0;
                                    $product_data->save();
                                }
                                $updated_order_product_qty_by_id = $updated_order_product_qty_by_id;
                                // echo "<pre>"; print_r($updated_order_product_qty_by_id); echo "</pre>"; die('end of code');
                            }
                    }else{
                      if (strpos($product_id, 'combo')) {
                            $combo_data = ProductCombo::where('id',explode('-', $product_id)[0])->first();
                            $mrp = 0;
                            foreach (json_decode(json_decode($combo_data->product_list)->id) as $keyss => $valuess) {
                                $updated_order_product_qty_by_id = $updated_order_product_qty[$key]*json_decode(json_decode($combo_data->product_list)->qty)[$keyss];
                                $product_name = Product::where('id',$valuess)->first();
                                $product_id_array = Product::where('name',$product_name->name)->get()->pluck('id');
                                foreach ($product_id_array as $keys => $id) {
                                  $stock_data = Stock::where('product_id',$id)->first();
                                  if ($stock_data->available_quantity >= $updated_order_product_qty_by_id) {
                                      $stock_data->available_quantity = $stock_data->available_quantity - $updated_order_product_qty_by_id;
                                      $stock_data->save();
                                      $updated_order_product_qty_by_id = 0;
                                  } else {
                                      $updated_order_product_qty_by_id -= $stock_data->available_quantity;
                                      $stock_data->available_quantity = 0;
                                      $stock_data->save();
                                      $product_data = Product::where('id',$id)->first();
                                      $product_data->status = 0;
                                      $product_data->save();
                                  }
                                  $updated_order_product_qty_by_id = $updated_order_product_qty_by_id;
                              }
                            }
                    }else {
                          $stock_data = Stock::where('product_id',$product_id)->first();
                          $stock_data->available_quantity =$stock_data->available_quantity - $updated_order_product_qty[$key];
                          $stock_data->save();
                          if($stock_data->available_quantity == 0){
                              $product_data = Product::where('id',$product_id)->first();
                              $product_data->status = 0;
                              $product_data->save();
                          }
                        }
                    }
                }
            }

            
        } 
        else {
            if ($request['delivery_status'] == 1 && $Order_data->delivery_status != 1) {
                foreach ($updated_order_product_qty as $key => $value) {
                    $final_available_qty[] = $request['available_qtys'][$key] - $value;
                }

                foreach ($updated_product_id as $keys => $values) {
                    if (strpos($values, '_')) {
                        $stock_order_qty_by_part = $updated_order_product_qty[$keys];
                        $product_id_array = explode('_', $values);
                            foreach ($product_id_array as $keys => $id) {
                                $product_data = Product::where('id',$id)->first();
                                $stock_data = Stock::where('product_id',$id)->first();
                                //check order qty is greater than available qty or not
                                if ($stock_data->count() == 0) {
                                    if ($stock_order_qty_by_part >= $product_data->purchase_qty) {
                                        $stock_product = new Stock();
                                        $stock_product->product_id =$values;
                                        $stock_product->purchase_quantity =$product_data->purchase_qty;
                                        $stock_product->available_quantity = 0;
                                        $stock_product->save();
                                        $product_data = Product::where('id',$id)->first();
                                        $product_data->status = 0;
                                        $product_data->save();
                                        $stock_order_qty_by_part -= $product_data->purchase_qty;
                                    } else {
                                        $stock_product = new Stock();
                                        $stock_product->product_id =$values;
                                        $stock_product->purchase_quantity =$product_data->purchase_qty;
                                        $stock_product->available_quantity = $product_data->purchase_qty - $stock_order_qty_by_part;
                                        $stock_product->save();
                                        $stock_order_qty_by_part = 0;
                                    }
                                }else {
                                    //update entry
                                    if ($stock_order_qty_by_part >= $stock_data->available_quantity) {
                                        $stock_product = Stock::where('product_id',$id)->first();
                                        $stock_order_qty_by_part -= $stock_product->available_quantity;
                                        $stock_product->available_quantity = 0;
                                        $stock_product->save();
                                        $product_data = Product::where('id',$id)->first();
                                        $product_data->status = 0;
                                        $product_data->save();
                                    } else {
                                        $stock_product = Stock::where('product_id',$id)->first();
                                        $stock_product->available_quantity = $stock_product->available_quantity -  $stock_order_qty_by_part;
                                        $stock_product->save();
                                        $stock_order_qty_by_part = 0;
                                    }
                                    
                                }
                                
                            }
                    }else{
                        if (strpos($values, 'combo')) {
                            $combo_data = ProductCombo::where('id',explode('-', $values)[0])->first();
                            $mrp = 0;
                            foreach (json_decode(json_decode($combo_data->product_list)->id) as $keyss => $valuess) {
                                $stock_order_qty_by_part = $updated_order_product_qty[$keys]*json_decode(json_decode($combo_data->product_list)->qty)[$keyss];
                                $product_name = Product::where('id',$valuess)->first();
                                $product_id_array = Product::where('name',$product_name->name)->get()->pluck('id');
                                // echo "<pre>"; print_r($product_name); echo "</pre>"; die('end of code');
                                foreach ($product_id_array as $keys => $id) {
                                  $product_data = Product::where('id',$id)->first();
                                  $stock_data = Stock::where('product_id',$id)->first();
                                  //check order qty is greater than available qty or not
                                  if ($stock_data->count() == 0) {
                                      if ($stock_order_qty_by_part >= $product_data->purchase_qty) {
                                          $stock_product = new Stock();
                                          $stock_product->product_id =$values;
                                          $stock_product->purchase_quantity =$product_data->purchase_qty;
                                          $stock_product->available_quantity = 0;
                                          $stock_product->save();
                                          $product_data = Product::where('id',$id)->first();
                                          $product_data->status = 0;
                                          $product_data->save();
                                          $stock_order_qty_by_part -= $product_data->purchase_qty;
                                      } else {
                                          $stock_product = new Stock();
                                          $stock_product->product_id =$values;
                                          $stock_product->purchase_quantity =$product_data->purchase_qty;
                                          $stock_product->available_quantity = $product_data->purchase_qty - $stock_order_qty_by_part;
                                          $stock_product->save();
                                          $stock_order_qty_by_part = 0;
                                      }
                                  }else {
                                      //update entry
                                      if ($stock_order_qty_by_part >= $stock_data->available_quantity) {
                                          $stock_product = Stock::where('product_id',$id)->first();
                                          $stock_order_qty_by_part -= $stock_product->available_quantity;
                                          $stock_product->available_quantity = 0;
                                          $stock_product->save();
                                          $product_data = Product::where('id',$id)->first();
                                          $product_data->status = 0;
                                          $product_data->save();
                                      } else {
                                          $stock_product = Stock::where('product_id',$id)->first();
                                          $stock_product->available_quantity = $stock_product->available_quantity -  $stock_order_qty_by_part;
                                          $stock_product->save();
                                          $stock_order_qty_by_part = 0;
                                      }
                                      
                                  }
                                  
                                }
                            }
                        } else {
                            $product_data = Product::where('id',$values)->first();
                            $stock_data = Stock::where('product_id',$values)->get();
                            if ($stock_data->count() == 0) {
                              //insert new entry
                                $stock_product = new Stock();
                                $stock_product->product_id =$values;
                                $stock_product->purchase_quantity =$product_data->purchase_qty;
                                $stock_product->available_quantity =$final_available_qty[$keys];
                                $stock_product->save();
                            } else {
                                //update entry
                                $stock_data = Stock::where('product_id',$values)->first();
                                $stock_data->available_quantity =$final_available_qty[$keys];
                                $stock_data->save();
                            }

                            if ($final_available_qty[$keys] == 0) {
                                $product_data = Product::where('id',$values)->first();
                                $product_data->status = 0;
                                $product_data->save();
                            }   
                        }
                         
                    }
                }
            }
        }

        //order entry
        foreach ($updated_product_id as $key => $value) {
            $product_id_array = explode('_', $value); 
            $c = count($product_id_array); 
            $product_data = Product::where('id',$product_id_array[$c-1])->first();
            $product['product_id'][] = $value;
            $product['available_qty'][] =$request['available_qty'][$key];
            $product['order_qty'][] =$updated_order_product_qty[$key];
            if (strpos($value, 'combo')) {
                $combo_data = ProductCombo::where('id',explode('-', $value)[0])->first();
                $mrp = 0;
                foreach (json_decode(json_decode($combo_data->product_list)->id) as $keyss => $valuess) {
                    $p_data = Product::where('id',$valuess)->orderBy('id','DESC')->first();
                    $master = ProductMaster::where('name',$p_data->name)->first();
                    if(isset($master->mrp)){
                    $mrp += $master->mrp*json_decode(json_decode($combo_data->product_list)->qty)[$keyss];
                    }
                }
                if ($sgp) {
                    if (round($combo_data->combo_price + ($mrp * $sgp->value/100)) > $mrp) {
                        $product_data->bulk_sale_price = $mrp;
                    } else {
                        $product_data->bulk_sale_price = round($combo_data->combo_price + ($mrp * $sgp->value/100));
                    }
                } else {
                    $product_data->bulk_sale_price = $combo_data->combo_price;
                }
                $product['per_price'][] = $product_data->bulk_sale_price;
                $product['sub_price'][] = $updated_order_product_qty[$key]*$product_data->bulk_sale_price;
            } else {
                $product_master = ProductMaster::where('name',$product_data->name)->first();
                if ($sgp && $product_master->mrp) {
                    if (round($product_data->sale_price + ($product_master->mrp * $sgp->value/100)) > $product_master->mrp) {
                        $product_data->sale_price = $product_master->mrp;
                    } else {
                        $product_data->sale_price = round($product_data->sale_price + ($product_master->mrp * $sgp->value/100));
                    }
                } else {
                    $product_data->sale_price = $product_data->sale_price;
                }
                if ($sgp && $product_master->mrp) {
                    if (round($product_data->sale_price + ($product_master->mrp * $sgp->value/100)) > $product_master->mrp) {
                        $product_data->bulk_sale_price = $product_master->mrp;
                    } else {
                        $product_data->bulk_sale_price = round($product_data->bulk_sale_price + ($product_master->mrp * $sgp->value/100));
                    }
                } else {
                    $product_data->bulk_sale_price = $product_data->bulk_sale_price;
                }
                if($request['price_type'] == 'Bulk Price'){
                    $product['per_price'][] = $product_data->bulk_sale_price;
                    $product['sub_price'][] = $updated_order_product_qty[$key]*$product_data->bulk_sale_price;
                }else{
                    $product['per_price'][] = $product_data->sale_price;    
                    $product['sub_price'][] = $updated_order_product_qty[$key]*$product_data->sale_price;    
                }
            }
        }

        $order = Order::where('id',$request['order_id'])->first();
        if ($order->is_invoice_sms_sent == 0 && $request['order_status'] == 'approved') {
            $order->is_invoice_sms_sent = 1;
            $customer_data = Customer::where('id',$request['customer_id'])->first();
                // $this->Sendinvoice(array('mobile_no'=>$customer_data->whatsapp_no,'order_id'=>substr($order->id.md5($order->id), 0, 7)));
        }
        $order->customer_id = $request['customer_id'];
        $order->order_product = json_encode($product);
        $order->order_amt = $request['order_amount'];
        $order->delivery_amount = $request['delivery_amount'];
        $order->discount_amount = $request['discount_amount'];
        $order->order_date = $request['order_date'];
        $order->delivery_status = $request['delivery_status'];
        $order->payment_type_id = $request['payment_type_id'];
        $order->payment_status = $request['payment_status'];
        $order->price_type = $request['price_type'];
        $order->order_status = $request['order_status'];
        $order->save();

        $Order_data = Order::where('id',$request['order_id'])->first();
        if ($request['order_status'] == 'cancel') {
            $delivery_status = $Order_data->delivery_status;
            if ($delivery_status == 1) {
                //update stock
                $later_order_product_qty = json_decode($Order_data->order_product)->order_qty;
                $later_order_product_id = json_decode($Order_data->order_product)->product_id;
                foreach ($later_order_product_id as $key => $product_id) {
                    //update entry
                    $stock_data = Stock::where('product_id',$product_id)->first();
                    $stock_data->available_quantity =$stock_data->available_quantity + $later_order_product_qty[$key];
                    $stock_data->save();
                }
            }
        }

        if($request['voucher_id'] == 0){
            //entery in customer_discounts
            $data = CustomerDiscount::where('order_id',$request['order_id'])->first();
            if($data){
                $data->delete();
            }
        }

        if($request['voucher_id'] != 0){
            //entery in customer_discounts
            $data = CustomerDiscount::where('order_id',$request['order_id'])->first();
            if($data){
               $data->voucher_id =  $request['voucher_id'];
               $data->customer_id =  $request['customer_id'];
               $data->save();
            }else{
                $data = new CustomerDiscount();
                $data->voucher_id =  $request['voucher_id'];
               $data->customer_id =  $request['customer_id'];
               $data->order_id =  $request['order_id'];
               $data->save();  
            }
            
        }

        return redirect('customer-orders')->with(['success'=> 'Order Updated!!']);
    }
}

    public function OrderUpdate(Request $request)
    {
        //
        echo "<pre>"; print_r($request->input()); echo "</pre>"; die('end of code');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $Order_data =Order::where('id',$_GET['id'])->first();
        if ($Order_data != null) {
            $delivery_status = $Order_data->delivery_status;
            if ($delivery_status == 1) {
                //update stock
                $later_order_product_qty = json_decode($Order_data->order_product)->order_qty;
                $later_order_product_id = json_decode($Order_data->order_product)->product_id;
                foreach ($later_order_product_id as $key => $product_id) {
                //update entry
                    if (strpos($product_id, '_')) {
                            $product_id_array = explode('_', $product_id);
                            $later_order_product_qty_by_id = $later_order_product_qty[$key];
                                foreach ($product_id_array as $keys => $id) {
                                    $stock_data = Stock::where('product_id',$id)->first();
                                    $sell_qty = $stock_data->purchase_quantity - $stock_data->available_quantity;
                                    if ($sell_qty >= $later_order_product_qty_by_id) {
                                        $stock_data->available_quantity =$stock_data->available_quantity + $later_order_product_qty_by_id;
                                        $stock_data->save();
                                        $product_data = Product::where('id',$id)->first();
                                        $product_data->status = 1;
                                        $product_data->save(); 
                                        $later_order_product_qty_by_id = 0;
                                    } else {
                                        $stock_data->available_quantity =$stock_data->available_quantity + $sell_qty;
                                        $stock_data->save();
                                        $product_data = Product::where('id',$id)->first();
                                        $product_data->status = 1;
                                        $product_data->save(); 
                                        $later_order_product_qty_by_id -= $sell_qty;
                                    }
                                }
                    }else{
                        if (strpos($product_id, 'combo')) {
                            $combo_data = ProductCombo::where('id',explode('-', $product_id)[0])->first();
                            $mrp = 0;
                            foreach (json_decode(json_decode($combo_data->product_list)->id) as $keyss => $valuess) {
                                $later_order_product_qty_by_id = $later_order_product_qty[$key]*json_decode(json_decode($combo_data->product_list)->qty)[$keyss];
                                $product_name = Product::where('id',$valuess)->first();
                                $product_id_array = Product::where('name',$product_name->name)->get()->pluck('id');
                                // echo "<pre>"; print_r($product_name); echo "</pre>"; die('end of code');
                                foreach ($product_id_array as $keys => $id) {
                                  $stock_data = Stock::where('product_id',$id)->first();
                                  $sell_qty = $stock_data->purchase_quantity - $stock_data->available_quantity;
                                  if ($sell_qty >= $later_order_product_qty_by_id) {
                                      $stock_data->available_quantity =$stock_data->available_quantity + $later_order_product_qty_by_id;
                                      $stock_data->save();
                                      $product_data = Product::where('id',$id)->first();
                                      $product_data->status = 1;
                                      $product_data->save(); 
                                      $later_order_product_qty_by_id = 0;
                                  } else {
                                      $stock_data->available_quantity =$stock_data->available_quantity + $sell_qty;
                                      $stock_data->save();
                                      $product_data = Product::where('id',$id)->first();
                                      $product_data->status = 1;
                                      $product_data->save(); 
                                      $later_order_product_qty_by_id -= $sell_qty;
                                  }
                              }
                            }
                        }else {
                            $stock_data = Stock::where('product_id',$product_id)->first();
                            $stock_data->available_quantity =$stock_data->available_quantity + $later_order_product_qty[$key];
                            $stock_data->save(); 
                            $product_data = Product::where('id',$product_id)->first();
                            $product_data->status = 1;
                            $product_data->save(); 
                        }
                    }
               
                }
            }
            $Order_data =Order::where('id',$_GET['id'])->first();
            $Order_data->order_status = 'cancel';
            $Order_data->save();

            $data = CustomerDiscount::where('order_id',$_GET['id'])->first();
            if($data){
                $data->delete();
            }
            if (Auth::user()->hasRole('customer')) {
                return redirect('my-order')->with(['success'=> 'Order Cancelled!!']);
            } else {
                return redirect('customer-orders')->with(['success'=> 'Order Cancelled!!']);
            }
        }
        if (Auth::user()->hasRole('customer')) {
                return redirect('my-order')->with(['success'=> 'Order Cancelled!!']);
        } else {
            return redirect('customer-orders')->with(['success'=> 'Order Cancelled!!']);
        }
    }

    public function Sendinvoice($request){
        // return true;
        $result = '';
        $ch = curl_init();

        $user = "sanchitsoftware";

        $pass = "Sanchit@123";

        $receipientno = $request['mobile_no']; 

        $senderID="SGSHOP"; 

        $msgtxt = "Dear Customer, view your order details at ".url('/getinvoice?id=').$request['order_id']." | Savita's Grocery";
        // echo "<pre>"; print_r($msgtxt); echo "</pre>"; die('end of code'); 

        $url="http://smsjust.com/blank/sms/user/urlsms.php?username=".urlencode($user)."&pass=".urlencode($pass)."&senderid=".urlencode($senderID)."&dest_mobileno=".urlencode($receipientno)."&message=".urlencode($msgtxt)."&response=Y";
        curl_setopt($ch,CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result= curl_exec($ch);
        curl_close($ch);

        $OtpVerification = new OtpVerification();
        $OtpVerification->msg = $msgtxt;
        // $OtpVerification->token = $token;
        $OtpVerification->whatsapp_no = $request['mobile_no']; 
        $OtpVerification->save();
      }

    public function Sendnotification($request){
        // return true;
        $result = '';
        $ch = curl_init();

        $user = "sanchitsoftware";

        $pass = "Sanchit@123";

        $receipientno = '8652427021'; 

        $senderID="SGSHOP"; 

        $msgtxt = "SGO - New order created by ".$request['name'].",".$request['mobile_no'];
        // echo "<pre>"; print_r($msgtxt); echo "</pre>"; die('end of code'); 

        $url="http://smsjust.com/blank/sms/user/urlsms.php?username=".urlencode($user)."&pass=".urlencode($pass)."&senderid=".urlencode($senderID)."&dest_mobileno=".urlencode($receipientno)."&message=".urlencode($msgtxt)."&response=Y";
        curl_setopt($ch,CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result= curl_exec($ch);
        curl_close($ch);

        $OtpVerification = new OtpVerification();
        $OtpVerification->msg = $msgtxt;
        // $OtpVerification->token = $token;
        $OtpVerification->whatsapp_no = '8652427021'; 
        $OtpVerification->save();
    }

}
