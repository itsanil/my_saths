<?php

namespace App\Http\Controllers;

use App\User;
use App\Pdf;
use App\ProductMaster;
use App\Product;
use Illuminate\Http\Request;
use Auth;
use Storage;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pdfData = Pdf::where('user_id',Auth::user()->id)->get();
        return view('pdf.index',compact('pdfData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $master = ProductMaster::all();
        $product_list = Product::with('ProductSource')->where('status',1)->orderBy('id','DESC')->get()->unique('name');
        foreach ($product_list as $key => $value) {
            $master = ProductMaster::where('name',$value->name)->first();
            if ($master->mrp) {
                $value->mrp = $master->mrp;
            } else {
                $value->mrp = '';
            }
            
        }
        // echo "<pre>"; print_r($product_list); echo "</pre>"; die('end of code');
        // $pdfData = ProductMaster::where('user_id',Auth::user()->id)->get();
        return view('pdf.create',compact('product_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // echo "<pre>"; print_r($request->all()); echo "</pre>"; die('end of code');

        foreach ($request['product_id'] as $key => $value) {
            $product['product_id'][] = $value;
            $product['order'][] = $request['product_order'][$key];
        }
        $pdfData = new Pdf();
        $pdfData->user_id = Auth::user()->id;
        $pdfData->whatsapp_no = $request['whatsapp_num'];
        $pdfData->product_description = json_encode($product);
        $pdfData->store_name = $request['store_name'];
        $pdfData->contact_no = $request['store_phone'];
        if($request->file('background_photo')){
            $background_photo= $request->file('background_photo');
            $back_banner_photo = $photo_name.'_background_photo.'.$background_photo->getClientOriginalExtension();
            $background_photo->move(storage_path('app/PdfData/'.$folder_name), $back_banner_photo);
            $background_photo_url = 'app/PdfData/'.$folder_name.'/'.$back_banner_photo;
            $pdfData->background_photo = $background_photo_url;
        }
        $pdfData->background_color = $request['background_color'];
        $pdfData->sub_title = $request['sub_title'];
        $pdfData->store_photo = json_encode($request['store_photo']);
        $pdfData->store_description = $request['store_description'];
        $pdfData->offer_details = $request['offer_details'];
        $pdfData->delivery_charge = $request['delivery_charge'];
        $pdfData->delivery_time = $request['delivery_time'];
        $pdfData->delivery_holiday = $request['delivery_holiday'];
        $pdfData->delivery_address = $request['delivery_address'];
        $pdfData->save();
        return redirect('online-pdf')->with(['success'=> 'pdf created Sucsessfully!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pdf  $pdf
     * @return \Illuminate\Http\Response
     */
 public function show($id)
    {   
        $pdfData = Pdf::find($id);
        $product = json_decode($pdfData->product_description);
        $store_photo = json_decode($pdfData->store_photo);
        if($pdfData->background_color == '#ffffff'){
            $page_style = 'background-image: url('.asset('storage/'.$pdfData->background_photo).');';
        }else{
           $page_style = 'background-image: url('.storage_path($pdfData->background_photo).');background-color:'.$pdfData->background_color.';'; 
        }
        
        // echo "<pre>"; print_r($page_style); echo "</pre>";
        // echo "<pre>"; print_r($product->url); echo "</pre>";
        // echo "<pre>"; print_r($store_photo); echo "</pre>";
        // echo "<pre>"; print_r($pdfData); echo "</pre>"; exit();
        $output = ' 
                    <style>
                        .page-break {
                            page-break-after: always;
                        }
                        .page { background-color: #c7b39b; /* background Color */ }
                            html{
                            width: 100%;
                            height: 100%;
                            padding: 0;
                            margin: 0;
                            }
                            /** Define the footer rules **/
                        footer {
                            position: fixed; 
                            bottom: 0cm; 
                            left: 0cm; 
                            right: 0cm;
                            height: 2cm;

                            /** Extra personal styles 
                            color: black;
                            text-align: center;
                            line-height: 2cm;**/
                        }
                        #section-content{
                            padding: 20px;
                        }
                        .last {
                            
                            float:right;
                            width: 350px;
                            height: 60px;
                            background-color:#009933;
                            color:#ffff;
                        }
                        .column4 {
                            float: left;
                            width: 30%;
                            padding: 0px;
                        }

                        .dot {
                            height: 250px;
                            width: 250px;
                            background-color: yellow;
                            display: inline-block;
                            border-radius: 120px;
                        }

                        .column {
                            float: left;
                            width: 33.33%;
                            padding: 10px;
                        }
                        /* Clearfix (clear floats) */
                        .row::after {
                            content: "";
                            clear: both;
                            display: table;
                        }   
                        * {
                            box-sizing: border-box;
                        } 
                    </style>
                    <html>
                    <body style="'.$page_style.'">';
        $output .= '<section style="background-image: url('.asset('public/images/home_banner.jpg').');">
                        <div style=" right-padding:0px; background-color:#9400D3; color:#ffff; text-align:center; font-size:35px;  height:120px;">
                            <div class="banner-content">
                                <h1>'.$pdfData->sub_title.'</h1>
                            </div>
                        </div>
                        <h1 style="text-align:center;">WHATSAPP STORE</h1>';
           switch (key( array_slice($store_photo, -1, 1, TRUE ) )) {
                case 3:
                    $output .= '
                                        <div class="row" style="margin-left: 340px!important; padding-right: 100px!important;">
                                                
                                                    <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                        <center style="">
                                                            <img src="'.storage_path($store_photo[0]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                        </center>
                                                    </section>
                                                
                                        </div>
                                        <div class="row" style="margin-top: 20px!important;margin-left: 70px!important; padding-right: 100px!important;">
                                            <div class="column4">
                                                <div class="row" style="margin-top: 70px!important;">
                                                    
                                                        <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                            <center style="">
                                                                <img src="'.storage_path($store_photo[1]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                            </center>
                                                        </section>
                                                    
                                                </div>
                                            </div>
                                            <div class="column" >
                                                <a href="whatsapp://tel:+91'.$pdfData->contact_no.'" style="text-decoration:none">
                                                    <center>
                                                    <span class="dot" style="margin-top:20px;"><p style="font-size:60px;color:red;">Click<br>to<br>Call!!</p></span>
                                                    </center>
                                                </a>
                                            </div>
                                            <div class="column4" style="margin-left:150px;">
                                                <div class="row" style="margin-top: 70px!important;">
                                                    
                                                        <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                            <center style="">
                                                                <img src="'.storage_path($store_photo[2]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                            </center>
                                                        </section>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 35px!important;margin-left: 340px!important; padding-right: 100px!important;">
                                                
                                                    <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                        <center style="">
                                                            <img src="'.storage_path($store_photo[3]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                        </center>
                                                    </section>
                                              
                                        </div>
                                    ';
                    break;
                case 7:
                    $output .= '
                                <div class="row" style="margin-left: 70px!important; padding-right: 100px!important;">
                                    <div class="column4">
                                            <section style="width:110px;  height:110px; ">
                                                
                                            </section>
                                    </div>
                                    <div class="column4">
                                        
                                            <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                <center style="">
                                                    <img src="'.storage_path($store_photo[0]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                </center>
                                            </section>
                                        
                                    </div>
                                    <div class="column4">
                                        
                                            <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                <center style="">
                                                    <img src="'.storage_path($store_photo[1]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                </center>
                                            </section>
                                        
                                    </div>
                                    <div class="column4">
                                            <section style="width:110px;  height:110px; ">
                                                
                                            </section>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px!important;margin-left: 70px!important; padding-right: 100px!important;">
                                    <div class="column4">
                                        <div class="row" style="margin-top: 35px!important;">
                                            
                                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                    <center style="">
                                                        <img src="'.storage_path($store_photo[2]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                    </center>
                                                </section>
                                          
                                        </div>
                                        <div class="row" style="margin-top:60px;">
                                            
                                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                    <center style="">
                                                        <img src="'.storage_path($store_photo[3]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                    </center>
                                                </section>
                                            
                                        </div>
                                    </div>
                                    <div class="column" >
                                        <a href="whatsapp://tel:+91'.$pdfData->contact_no.'" style="text-decoration:none">
                                                    <center>
                                                    <span class="dot" style="margin-top:20px;"><p style="font-size:60px;color:red;">Click<br>to<br>Call!!</p></span>
                                                    </center>
                                                </a>
                                    </div>
                                    <div class="column4" style="margin-left:150px;">
                                        <div class="row" style="margin-top: 35px!important;">
                                            
                                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                    <center style="">
                                                        <img src="'.storage_path($store_photo[4]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                    </center>
                                                </section>
                                            <br>
                                            
                                                <section style="width:110px;margin-top: 30px!important;  height:110px; background-color:#ffff; border:1px solid black;">
                                                    <center style="">
                                                        <img src="'.storage_path($store_photo[5]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                    </center>
                                                </section>
                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 35px!important;margin-left: 70px!important; padding-right: 100px!important;">
                                    <div class="column4">
                                            <section style="width:110px;  height:110px; ">
                                                
                                            </section>
                                    </div>
                                    <div class="column4">
                                        
                                            <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                <center style="">
                                                    <img src="'.storage_path($store_photo[6]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                </center>
                                            </section>
                                        
                                    </div>
                                    <div class="column4">
                                        
                                            <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                                <center style="">
                                                    <img src="'.storage_path($store_photo[7]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                                </center>
                                            </section>
                                        
                                    </div>
                                    <div class="column4">
                                            <section style="width:110px;  height:110px; ">
                                                
                                            </section>
                                    </div>
                                </div>
                                ';
                    break;
                case 11:
                    $output .= '
                    <div class="row" style="margin-left: 70px!important; padding-right: 100px!important;">
                        <div class="column4">
                            
                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                    <center style="">
                                        <img src="'.storage_path($store_photo[0]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                    </center>
                                </section>
                            
                        </div>
                        <div class="column4">
                            
                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                    <center style="">
                                        <img src="'.storage_path($store_photo[1]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                    </center>
                                </section>
                            </a>
                        </div>
                        <div class="column4">
                            
                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                    <center style="">
                                        <img src="'.storage_path($store_photo[2]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                    </center>
                                </section>
                            </a>
                        </div>
                        <div class="column4">
                            
                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                    <center style="">
                                        <img src="'.storage_path($store_photo[3]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                    </center>
                                </section>
                            
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px!important;margin-left: 70px!important; padding-right: 100px!important;">
                        <div class="column4">
                            <div class="row" style="margin-top: 35px!important;">
                                
                                    <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                        <center style="">
                                            <img src="'.storage_path($store_photo[4]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                        </center>
                                    </section>
                                
                            </div>
                            <div class="row" style="margin-top:60px;">
                                
                                    <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                        <center style="">
                                            <img src="'.storage_path($store_photo[5]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                        </center>
                                    </section>
                                
                            </div>
                        </div>
                        <div class="column" >
                            <a href="whatsapp://tel:+91'.$pdfData->contact_no.'" style="text-decoration:none">
                                                    <center>
                                                    <span class="dot" style="margin-top:20px;"><p style="font-size:60px;color:red;">Click<br>to<br>Call!!</p></span>
                                                    </center>
                                                </a>
                        </div>
                        <div class="column4" style="margin-left:150px;">
                            <div class="row" style="margin-top: 35px!important;">
                                
                                    <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                        <center style="">
                                            <img src="'.storage_path($store_photo[6]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                        </center>
                                    </section>
                                <br>
                                
                                    <section style="width:110px;margin-top: 30px!important;  height:110px; background-color:#ffff; border:1px solid black;">
                                        <center style="">
                                            <img src="'.storage_path($store_photo[7]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                        </center>
                                    </section>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 35px!important;margin-left: 70px!important; padding-right: 100px!important;">
                        <div class="column4">
                            
                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                    <center style="">
                                        <img src="'.storage_path($store_photo[8]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                    </center>
                                </section>
                            
                        </div>
                        <div class="column4">
                            
                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                    <center style="">
                                        <img src="'.storage_path($store_photo[9]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                    </center>
                                </section>
                            
                        </div>
                        <div class="column4">
                            
                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                    <center style="">
                                        <img src="'.storage_path($store_photo[10]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                    </center>
                                </section>
                            
                        </div>
                        <div class="column4">
                            
                                <section style="width:110px;  height:110px; background-color:#ffff; border:1px solid black;">
                                    <center style="">
                                        <img src="'.storage_path($store_photo[11]).'"  alt="Forest" style="width:100px;height:100px;padding-top:5px;">
                                    </center>
                                </section>
                        </div>
                    </div>
                ';
                    break;
            }

        // $output .= '<div style="font-size:20px;text-align:center;">
        //                 <h1 style="padding:0px 100px; color:#ff00c8; height:50px;  text-align:center; ">'.$pdfData->store_description.'</h1>
        //                 <h1>Choose Your favourite products from List</h1>
        //             </div>
        //             <div style="font-size:20px;text-align:center; margin-top:150px;">
        //             </div>
        //             </section>
        //             <div class="page-break"></div>
        //             <center><b style="font-size:25px;">'.$pdfData->store_name.'</b></center><div class="row" style="padding-right: 60px!important;">';
            $output .= '<div style="font-size:20px;text-align:center;">
                        <h2 style="padding:30px 80px; color:#9400D3; height:50px;  text-align:center; ">'.$pdfData->store_description.'</h2>
                    <h1></h1>
                    </div>
                    <div style="font-size:20px;text-align:center; margin-top:100px;">
                    </div>
                    </section>
                    <div class="page-break"></div>
                    <section style="background-color:#0099cc;"><center><b style="color:#ffff;font-size:25px;">'.$pdfData->store_name.'</b></center></section><div class="row" style="padding-right: 60px!important;">';
                    $page_no = 1;
                    $product_key = 0;
        foreach ($product->order as $key => $value) {
            foreach ($product->order as $keys => $values) {
                if($product_key == $values-1){
                    $final_key = $keys;
                }
            }
            if ($key > 0 && $key%3 == 0){
                $output .= '<div class="row" style="padding-right: 60px!important;">
                            ';
            }
            $product_id = $product->product_id[$final_key];
            $product_data = Product::where('id',$product_id)->first();
            $mrp = ProductMaster::where('name',$product_data->name)->first();
            $mrp_html = '';
            if (!empty(($mrp->mrp))) {
                $mrp_html = '<span style="color:black">
                                            <b>MRP - '.$mrp->mrp.'</b>
                                        </span>
                                        <br>';
            }
            $output .= '<div class="column">
                            <a style="text-decoration:none" href="https://api.whatsapp.com/send?phone=91'.$pdfData->whatsapp_no.'&text=I Required '.$product_data->name.' Qty-">
                                <section style="width:100%; height:320px; background-color:#ffff;">
                                    <center style="padding:10px 10px 10px 10px;">
                                        <img src="'.storage_path($product_data->img).'" alt="Forest" style="width:100%;height:230px;">
                                        <span style="color:black">
                                            <b>'.$product_data->name.'</b>
                                        </span>
                                        <br>'.$mrp_html.'
                                        <span style="color:black">
                                            <b>Price:&nbsp;'.$product_data->sale_price.'</b>
                                        </span>
                                        <br>
                                        <span style="color:red">Click Here To Order</span>
                                         <span>
                                    </center>
                                </section>
                            </a>
                        </div>
                        ';

            if ($key%3 == 2 ){
                $output .= '</div>
                            ';
            }
            if(key( array_slice($product->order, -1, 1, TRUE ) ) == $key && $key%3 == 0) {
                    $output .= '<div class="column">
                                    <section style="width:100%; height:320px; ">
                                    </section>
                                </div>
                                <div class="column">
                                    <section style="width:100%; height:320px; ">
                                    </section>
                                </div>
                            </div>
                            ';
            }
            if(key( array_slice($product->order, -1, 1, TRUE ) ) == $key && $key%3 == 1) {
                    $output .= '<div class="column">
                                    <section style="width:100%; height:320px; ">
                                    </section>
                                </div>
                            </div>
                            ';
            }
            if ($key > 0 && $key%9 == 8){
            $output .= '<footer style="width: 100%;
                background-color: #A9A9A9;
                color: white;
                height: 0.8cm;
                "><b style="color:#ffff;text-align:center;padding-top:0px;padding-bottom:0px;padding-left:200px;font-size:25px;">Contact us on WhatsApp @ '.$pdfData->contact_no.'</b></footer>
                        <div class="page-break"></div>';
                    $page_no ++;
                if (key( array_slice($product->order, -1, 1, TRUE ) ) !== $key) {
                        $output .='<section style="background-color:#0099cc;"><center><b style="color:#ffff;font-size:25px;">'.$pdfData->store_name.'</b></center></section>';
                }   
            }
            
            if (key( array_slice($product->order, -1, 1, TRUE ) ) == $key && $key%9 !== 8) {
                        $output .='<footer style="width: 100%;
                background-color: #A9A9A9;
                color: white;
                height: 0.8cm;
                "><b style="color:#ffff;text-align:center;padding-top:0px;padding-bottom:0px;padding-left:200px;font-size:25px;">Contact us on WhatsApp @ '.$pdfData->contact_no.'</b></footer>
                        <div class="page-break"></div>';
            } 
             $product_key ++;
            
        }
        $offerList = explode(PHP_EOL, $pdfData->offer_details);//splite string at line break
        if(!isset($offerList[1])){
            $offerList[1] = '';
        }
        $output .= '
        <div style="overflow:auto;border: dotted 2px black; padding:10px;margin:10px;margin-top:10px;">
            <div style="margin: 10px; background-color:yellow"><center><h1 style="font-size:40px;color:red;">OFFERS</h1></center><div>
            <div style=" background-color:#e6005c;"><center><h3 style="padding:0px 100px; color:#ffff;   text-align:center; ">'.$offerList[0].'</h3></center><div>
            <div style=" background-color:#00b300;"><center><h3 style="padding:0px 100px; color:#ffff;   text-align:center; ">'.$offerList[1].'</h3></center><div>
            </div>
            </div></div></div></div></div></div>
            <center>
            <h1>WHATSAPP STORE</h1>
            <span class="dot" style="margin-left:280px;margin-top:20px; border:2px solid black"><a href="whatsapp://tel:+91'.$pdfData->contact_no.'" style="text-decoration:none"><p style="font-size:60px;color:red;">Click<br>To<br>Call!!</p></a></span>
            </center>
            <center>
            <center><h1 style="font-size:40px;padding:0px 100px;text-align:center;color:green; ">Whatsapp No:&nbsp;'.$pdfData->whatsapp_no.'</h1></center>
            <center>
            <p style="font-size:30px;color:red;    word-break: break-all;    padding: 0px 0px;">'.$pdfData->delivery_charge.'</p>
            </center>
            <footer style="width: 100%;
                background-color: #0099cc;
                color: white;
                height: 200px;
                ">
            <div class="row">
            <div class="column" style="margin:0px;">
            <h2 style="padding:0px 0px; color:#ffff;text-align:center;"><span style="text-decoration: underline;">Delivery Information</span><br>'.$pdfData->delivery_time.'<br>'.$pdfData->delivery_holiday.'</h2>
            </div>
            <div class="column" style="float:right">
            <h2 style="padding:0px 10px; color:#ffff;text-align:center;"><span style="text-decoration: underline;">Pickup Address</span><br>'.$pdfData->delivery_address.'</h2>
            </div>
            </div>
            </footer>

                    </body>
                </html>
                ';
        // echo "<pre>"; print_r($output); echo "</pre>"; die('end of code');
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        return $pdf->stream();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pdfData = Pdf::find($id);
        $product = json_decode($pdfData->product_description);
        // echo "<pre>"; print_r($product); echo "</pre>"; die('end of code');
        $product_id = $product->product_id;
        $product_list = Product::with('ProductSource')->whereIn('id',$product_id)->get();
        $product->product_list = $product_list;
        // echo "<pre>"; print_r($product); echo "</pre>"; die('end of code');
        $store_photo = json_decode($pdfData->store_photo);
        return view('pdf.edit',compact('pdfData','product','store_photo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {   
        // dd($request->all());
        $oldpdfData = Pdf::find($request['pdf_id']);
        // find pdf data folder path to delete old data
        // $str = json_decode($oldpdfData->store_photo)[0];
        // // $path = "app/PdfData/user_id_1/pdf_1/";
        // $folder_name = explode("/",$str)[2]."/".explode("/",$str)[3];
        // $file_exists = storage_path('app/PdfData/'.$folder_name);
        // if (file_exists($file_exists))
        // {
        //     // echo "<pre>"; print_r('file hai'); echo "</pre>"; exit('end of code');

        // }else{
        //     $file_create = Storage::disk('local')->put('PdfData/'.$folder_name.'/sample.txt', 'pdf data is here');
        // }
        $product_key = 0;
        $product_order = $request['product_order'];
        foreach ($product_order as $key => $value) {
            foreach ($product_order as $keys => $values) {
                if($values-1 == $product_key){
                    $final_key = $keys;
                }
            }
            $product['product_id'][] = $request['product_id'][$final_key];
            $product['order'][] = $product_key+1;
            // $product['product_id'][] = $request['product_id'][$final_key];
            // $product['order'][] = $request['product_order'][$final_key];
            $product_key ++;
        }
        // $store_photo = $request->input('store_photo');
        // foreach ($store_photo as $key => $value) {
        //     $store_photo_url[] = $product['url'][$value];
        // }

        $pdfData = Pdf::find($request['pdf_id']);
        $pdfData->whatsapp_no = $request['whatsapp_num'];
        $pdfData->product_description = json_encode($product);
        $pdfData->store_name = $request['store_name'];
        $pdfData->contact_no = $request['store_phone'];
        if($request->file('background_photo')){
            $background_photo= $request->file('background_photo');
            $back_banner_photo = $photo_name.'_background_photo.'.$background_photo->getClientOriginalExtension();
            $background_photo->move(storage_path('app/PdfData/'.$folder_name), $back_banner_photo);
            $background_photo_url = 'app/PdfData/'.$folder_name.'/'.$back_banner_photo;
            $pdfData->background_photo = $background_photo_url;
        }
        $pdfData->background_color = $request['background_color'];
        $pdfData->sub_title = $request['sub_title'];
        $pdfData->store_photo = json_encode($request['store_photo']);
        $pdfData->store_description = $request['store_description'];
        $pdfData->offer_details = $request['offer_details'];
        $pdfData->delivery_charge = $request['delivery_charge'];
        $pdfData->delivery_time = $request['delivery_time'];
        $pdfData->delivery_holiday = $request['delivery_holiday'];
        $pdfData->delivery_address = $request['delivery_address'];
        $pdfData->save();
        return redirect('online-pdf')->with(['success'=> 'pdf Updated Sucsessfully!!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
