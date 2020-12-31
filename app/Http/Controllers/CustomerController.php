<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Area;
use App\Order;
use App\Product;
use App\User;
use App\Tag;
use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DataTables;
use Auth;
use Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Customer_list = Customer::with('areas')->get();
        return view('customer.index',compact('Customer_list'));
    }

     public function MyOrder(){
      $customer_id = Customer::where('user_id',Auth::user()->id)->first();
      $customer_id = $customer_id->id;
      $Customer_data = Customer::where('id',$customer_id)->first();
      if( $Customer_data->status == 0){
        return redirect('customer-login');
      }
      $tag_list = Tag::where('status','Active')->orderBy('name', 'ASC')->get()->pluck('name');
      $brand_list = Brand::where('status','Active')->orderBy('name', 'ASC')->get();
      $cart = Session::get('cart_product');
        $cart_product_id_array = explode(',', $cart);
        if (isset($cart_product_id_array) && $cart_product_id_array[0] != '') {
            $cart_count =  count($cart_product_id_array);
          } else {
            $cart_count = 0;
          }
      return view('order.my_order',compact('customer_id','tag_list','brand_list','cart','cart_product_id_array','cart_count'));
      // return redirect('/customer/order-list/'.$customer_id->id.'');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Area_list = Area::all();
        $building_list = Customer::with('areas')->groupBy('building_name')->pluck('building_name');
        // echo "<pre>"; print_r($building_list); echo "</pre>"; die('end of code');
        
        return view('customer.create',compact('Area_list','building_list'));
    }

    public function data(Request $request){
        $Customer_list = Customer::with('areas')->get();
        return DataTables::of($Customer_list)
        ->addColumn('action', function ($Customer_list) {
                return '<a class="btn btn-primary btn-sm"  href="'.route('customer.show',$Customer_list->id).'">
                                  <i class="fas fa-eye">
                                  </i>
                            </a>
                            <a class="btn btn-info btn-sm"  href="'.route('customer.edit',$Customer_list->id).'">
                                  <i class="fas fa-pencil-alt">
                                  </i>
                            </a>
                            <a class="btn btn-danger btn-sm"  style="color:ffff!important;"  onclick="Delete('.$Customer_list->id.');">
                              <i class="fas fa-trash" style="color: #ffff;">
                              </i>
                            </a>';
        })
        ->addColumn('create_date', function ($Customer_list) {
                return date('d-m-Y',strtotime($Customer_list->created_at));
        })
        ->rawColumns(['action','create_date'])
        ->make(true);
    }

    public function Customerdata(Request $request){
        $Customer_list = Customer::with('areas')->get();
        return DataTables::of($Customer_list)
        ->addColumn('action', function ($Customer_list) {
                return '<a class="btn btn-primary btn-sm"  href="'.url('order/customer?id=').$Customer_list->id.'">
                                  <i class="fas fa-eye">
                                  </i>View Orders
                            </a>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd($request->path());
        if (empty($request['contact_no'])) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'whatsapp_no' => ['required', 'numeric', 'digits:10', 'unique:customers'],
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'whatsapp_no' => ['required', 'numeric', 'digits:10', 'unique:customers'],
                'contact_no' => ['required','numeric', 'digits:10', 'unique:customers'],
            ]);
        }
        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $User = new User();
        $User->name = $request['name'];
        $User->mobile = $request['whatsapp_no'];
        $User->save();
        $customer = new Customer();
        $customer->name = $request['name'];
        $customer->user_id = $User->id;
        $customer->whatsapp_no = $request['whatsapp_no'];
        $customer->contact_no = $request['contact_no'];
        $customer->flat_no = $request['flat_no'];
        if ($request['select_building_name'] == 'Other') {
            $customer->building_name = $request['building_name'];
        } else {
            $customer->building_name = $request['select_building_name'];
        }
        $customer->area_id = $request['area_id'];
        $customer->lane = $request['lane'];
        $customer->city = $request['city'];
        $customer->status = $request['status'];
        $customer->save();
        $User->attachRole('customer');
        return redirect(($request->path() == 'customer') ? 'customer' : 'order/create')->with(['success'=> 'Customer Added!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $Customer_Data = Customer::with('areas')->where('id',$id)->first();
        return view('customer.view',compact('Customer_Data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Customer_Data = Customer::with('areas')->where('id',$id)->first();
        $Area_list = Area::all();
        $building_list = Customer::with('areas')->pluck('building_name');
        return view('customer.edit',compact('Customer_Data','Area_list','building_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        // dd($request->all());
        if (empty($request['contact_no'])) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'whatsapp_no' => ['required', 'numeric', 'digits:10'],
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'whatsapp_no' => ['required', 'numeric', 'digits:10'],
                'contact_no' => ['required','numeric', 'digits:10'],
            ]);
        }
        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $count = Customer::where('whatsapp_no',$request['whatsapp_no'])->count();
        if ($count > 1) {
            return Redirect::back()->with(['error'=> 'Whatsapp Number already registered!!']);
        }
        $customer = Customer::where('id',$request['id'])->first();
        $customer->name = $request['name'];
        $customer->whatsapp_no = $request['whatsapp_no'];
        $customer->contact_no = $request['contact_no'];
        $customer->flat_no = $request['flat_no'];
        if ($request['select_building_name'] == 'Other') {
            $customer->building_name = $request['building_name'];
        } else {
            $customer->building_name = $request['select_building_name'];
        }
        $customer->area_id = $request['area_id'];
        $customer->lane = $request['lane'];
        $customer->city = $request['city'];
        $customer->status = $request['status'];
        $customer->save();

        $User = User::where('mobile',$request['whatsapp_no'])->first();
        $User->name = $request['name'];
        $User->mobile = $request['whatsapp_no'];
        $User->save();
        return redirect('customer')->with(['success'=> 'Customer Detail Updated!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $post =Customer::where('id',$_GET['id'])->first();
        if ($post != null) {
          $User = User::where('mobile',$post['whatsapp_no'])->first();
          $User->delete();
          $post =Customer::where('id',$_GET['id'])->first();
            $post->delete();
            return redirect('customer')->with(['success'=> 'Customer Record Deleted!!']);
        }
        return redirect('customer');
    }

    public function customerOrderList($id){
        $order_list = Order::with('PaymentType')->where('customer_id',$id)->orderBy('id', 'DESC')->get();
        foreach ($order_list as $key => $order) {
          foreach (json_decode($order->order_product)->product_id as $keys => $value) {
            $product_data = Product::where('id',$value)->first();
            $product_list[$key][$keys]['name'] = $product_data->name;
            $product_list[$key][$keys]['per_price'] = json_decode($order->order_product)->per_price[$keys];
            $product_list[$key][$keys]['sub_price']= json_decode($order->order_product)->sub_price[$keys];
            $product_list[$key][$keys]['order_qty'] = json_decode($order->order_product)->order_qty[$keys];
          }
        }
        // echo "<pre>"; print_r($product_list); echo "</pre>"; die('end of code');
        return view('customer.order-list',compact('order_list','product_list'));
    }
}

