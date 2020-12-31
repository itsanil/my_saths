<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Area;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DataTables;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_list = Order::with('customer')->get();
        // return view('customer.index');
        return view('order.index',compact('order_list'));
    }

    public function orderCustomer(){
        return view('customer.index');
    }

    public function OrderList(){
        // echo "<pre>"; print_r($_GET['id']); echo "</pre>"; die('end of code');
       return view('order.order_list');
    }
}

