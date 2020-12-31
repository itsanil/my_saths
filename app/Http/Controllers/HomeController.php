<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\User;
use App\Role;
use App\RoleUser;
use App\Pdf;
use App\Order;
use App\Product;
use App\Customer;
use App\Refund;
use App\Brand;
use App\Promotion;
use App\ManageSgp;
use App\ProductCombo;
use Auth;
use Response;
use Validator;
use Illuminate\Support\Facades\Session;
use App\ProductRate;
use App\ProductMaster;
use App\Stock;
use App\HomeProduct;
use App\Area;
use App\Tag;
use App\Http\Controllers\MainController;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $User = User::where('id',Auth::user()->id)->with('roles')->first();
        $product_list = Product::all();
        $product['name']  = array();
        foreach ($product_list as $key => $value) {
            $product['name'][]  = $value->name;
            $product['id'][]  = $value->id;
            $product['b2b_sells'][]  = 0;
            $product['b2c_sells'][]  = 0;
        }
        $combo_list = ProductCombo::all();
        foreach ($combo_list as $key => $value) {
          $product['name'][]  = $value->product_combo_name;
          $product['id'][]  = $value->id.'-combo';
          $product['b2b_sells'][]  = 0;
          $product['b2c_sells'][]  = 0;
        }
        // echo "<pre>"; print_r($product); echo "</pre>"; die('end of code');
        $role = $User->roles[0]['name'];
        
        if ($role == 'admin') {
            $order_list = Order::where('payment_status',1)->get();
            $total_order = $order_list->count();
            $total_stock_amt = 0;
            $total_stock_refund_amt = 0;
            $total_discount = 0;
            $total_delivery = 0;
            foreach ($order_list as $key => $order) {
              $total_discount += $order->discount_amount;
              $total_delivery += $order->delivery_amount;
              foreach (json_decode($order->order_product)->product_id as $keys => $value) {
                foreach ($product['id'] as $keyss => $valuess) {
                    if($value == $valuess){
                        if ($order->price_type == 'Sale Price') {
                            $product['b2c_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                        } else {
                            $product['b2b_sells'][$keyss]  += json_decode($order->order_product)->order_qty[$keys];
                        }
                    }
                }
                  
                  // echo "<pre>"; print_r($value); echo "</pre>"; 
                if (count(explode('combo',$value)) > 1) {
                  $product_data->purchase_price = 0;
                  $combo_data = ProductCombo::where('id',explode('-', $value)[0])->first();
                  foreach (json_decode(json_decode($combo_data->product_list)->id) as $keysss => $valuesss) {
                    $p_data = ProductRate::where('product_id',$valuesss)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                    $product_data->purchase_price += $p_data->purchase_price * json_decode(json_decode($combo_data->product_list)->qty)[$keysss];
                  }
                  $product_data->transport_expence = 0;
                } else {
                  if (count(explode('_',$value)) > 1) {
                    $value = max(explode('_',$value)); 

                  }
                  $product_data = ProductRate::where('product_id',$value)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                  
                }
                if (!isset($product_data->purchase_price)) {
                  $product_data = Product::where('id',$value)->first();
                } 
                
                $total_stock_amt += json_decode($order->order_product)->order_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
              }
            }
            // echo "<pre>"; print_r($total_stock_amt); echo "</pre>"; die('end of code');
            foreach ($order_list as $key => $order) {
                $stock_refund_list = Refund::where('order_id',$order->id)->first();
                if ($stock_refund_list) {
                    foreach (json_decode($stock_refund_list->refund_product)->product_id as $keys => $value) {
                        foreach ($product['id'] as $keyss => $valuess) {
                            if($value == $valuess){
                                if ($order->price_type == 'Sale Price') {
                                    $product['b2c_sells'][$keyss]  -= json_decode($order->order_product)->order_qty[$keys];
                                } else {
                                    $product['b2b_sells'][$keyss]  -= json_decode($order->order_product)->order_qty[$keys];
                                }
                            }
                        }
                        $product_data = ProductRate::where('product_id',$value)->where('created_at', '<=', $order->created_at)->orderBy('id', 'DESC')->first();
                        $total_stock_refund_amt += json_decode($stock_refund_list->refund_product)->refund_qty[$keys]*($product_data->purchase_price+$product_data->transport_expence/$product_data->purchase_qty);
                        
                    }
                }
              
            }
            //B2C Sales
            $B2C_order_list = Order::where('price_type','Sale Price')->where('payment_status',1)->get();
            $total_b2c_order = $B2C_order_list->count();
            $b2c_sells = 0;
            foreach ($B2C_order_list as $key => $value) {
                $B2C_refund_list = Refund::where('order_id',$value->id)->first();
                if ($B2C_refund_list) {
                   $b2c_sells += $value->order_amt - $B2C_refund_list->refund_amount;
                }else{
                    $b2c_sells += $value->order_amt;
                }
            }
            //B2B Sales
            $B2B_order_list = Order::where('price_type','Bulk Price')->where('payment_status',1)->get();
            $total_b2b_order = $B2B_order_list->count();
            $b2b_sells = 0;
            foreach ($B2B_order_list as $key => $value) {
                $B2b_refund_list = Refund::where('order_id',$value->id)->first();
                if ($B2b_refund_list) {
                    $b2b_sells += $value->order_amt - $B2C_refund_list->refund_amount;
                }else{
                    $b2b_sells += $value->order_amt;
                }
            }
            if ($total_stock_refund_amt > $total_stock_amt) {
                $total_stock_amt = $total_stock_refund_amt - $total_stock_amt;
            }else{
                $total_stock_amt = $total_stock_amt - $total_stock_refund_amt;
            }
            $total_stock_amt = number_format((float)$total_stock_amt, 2, '.', '');
            $Total_revenue = $b2c_sells + $b2b_sells + $total_delivery  - $total_stock_amt - $total_discount;
            $Total_revenue = number_format((float)$Total_revenue, 2, '.', '');
            return view('home',compact('total_stock_amt','b2c_sells','b2b_sells','Total_revenue','total_order','total_b2c_order','total_b2b_order','product'));
        }

        
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


    public function changepswd(){
      return view('user.chgpwd');
    }

    public function reset(Request $request){
      
      // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');
      $user = User::where('id',Auth::User()->id)->first();
      $user->password = Hash::make($request['password']);
      $user->save();
      return redirect('/');

    }



}
