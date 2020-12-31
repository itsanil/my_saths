<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8"/>
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Savita's Grocery Online - Choose and Buy Online Grocery from a wide range of quality products at discounted prices and much more. Shop Now !"/>
  <meta name="keywords" content="Online Grocery, Staples, Fortune, Ram Bandhu, Pickle, Papad, Rice, Oil, Atta, Snacks, Khakra, Grocery Discount, Free Delivery,Savita Grocery, Savita's Grocery, Savitas Grocery " />
  <link rel="canonical" href="https://www.sgonline.in" />
  <meta property="og:site_name" content="Savita's Grocery" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Buy Grocery Online | Quality Products at discounted prices - Savita's Grocery" />
  <meta property="og:description" content="Savita's Grocery - Choose and Buy Online Grocery from a wide range of quality products at discounted prices and much more. Shop Now !" />
  <meta property="og:url" content="https://www.sgonline.in" />
  <meta name=”robots” content=”index, follow”>
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <title>Buy Grocery Online | Quality Products at discounted prices - Savita's Grocery</title>
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/images/favicon_io/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/images/favicon_io/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/images/favicon_io/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('public/images/favicon_io/site.webmanifest') }}">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
    <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/toastr/toastr.min.css') }}">
  @yield('css')
  <link rel="stylesheet" href="{{ asset('public/adminlte/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- <script type="text/javascript" src="jquery-3.3.1.min.js"></script> -->
  <link rel="stylesheet" href="{{ asset('public/chat/floating-wpp.css') }}">
  <!-- Bootstrap core CSS -->
  <style>
    .offer-header {
        font-size: 3em;
        width: 100%;
        height: 100%;
        margin: 0;
        line-height: 50px;
        text-align: center;
        background: #ff0707;
        color: white;
    }
    .example1 {
       overflow: hidden;
      }

    .example1 h3 {
     font-size: 2em;
     width: 100%;
     height: 100%;
     margin: 0;
     line-height: 50px;
     text-align: center;
     /* Starting position */
     -moz-transform:translateX(100%);
     -webkit-transform:translateX(100%);  
     transform:translateX(100%);
     /* Apply animation to this element */  
     -moz-animation: example1 15s linear infinite;
     -webkit-animation: example1 15s linear infinite;
     animation: example1 15s linear infinite;
    }
    /* Move it (define the animation) */
    @-moz-keyframes example1 {
     0%   { -moz-transform: translateX(100%); }
     100% { -moz-transform: translateX(-100%); }
    }
    @-webkit-keyframes example1 {
     0%   { -webkit-transform: translateX(100%); }
     100% { -webkit-transform: translateX(-100%); }
    }
    @keyframes example1 {
     0%   { 
     -moz-transform: translateX(100%); /* Firefox bug fix */
     -webkit-transform: translateX(100%); /* Firefox bug fix */
     transform: translateX(100%);     
     }
     100% { 
     -moz-transform: translateX(-100%); /* Firefox bug fix */
     -webkit-transform: translateX(-100%); /* Firefox bug fix */
     transform: translateX(-100%); 
     }
    }
    .thumbnail {
        display: block;
        padding: 4px;
        margin-bottom: 20px;
        line-height: 1.42857143;
        background-color: #fff;
        border: 1px solid #999;
        border-radius: 4px;
        -webkit-transition: border .2s ease-in-out;
        -o-transition: border .2s ease-in-out;
        transition: border .2s ease-in-out;
        height: 100%;
    }
    
    .form-gradient .header {
    border-top-left-radius: .3rem;
    border-top-right-radius: .3rem;
}
 .dis_section{
        float: left;
    width: 38px;
    height: 38px;
    text-align: center;
    position: absolute;
    /* top: 0; */
    /* left: 0; */
    background: url(https://www.jiomart.com/assets/version1605113383/smartweb/images/icons/offer_bg.svg) center no-repeat;
    font-size: 11px;
    font-family: JioLight;
    color: #fff;
    display: block;
    padding: 5px 0;
  }
.peach-gradient {
    background: linear-gradient(40deg,#ffd86f,#fc6262) !important;
}

.white-text{
  color:#ffff;
}

.home-product{
  height: 175px;
  width:100%;
  /*width:175px;*/
}

.tag-product{
  height: 175px;
  /*width:100%;*/
  /*width:175px;*/
}

@media only screen and (max-width: 768px) {
  /* For mobile phones: */
  .home-product{
      height: 175px;
      width:auto;
      /*width:175px;*/
    }
}



.home-section{
  /*border: 2px solid black;*/
    padding: 10px;
    text-align: center;
    /*height: 100%!important;*/
}

.home-sections{
  /*border: 2px solid black;*/
    padding: 10px;
    text-align: center;
    height: 100%!important;
}

.orientation-div {
    display: -webkit-box!important;
    display: -ms-flexbox!important;
    display: flex!important;
    pointer-events: auto;
    position: fixed;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    min-height: 100vh;
    background: #008ecc;
    z-index: 9999999999;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
 .orientation-div .orientation {
    width: 80%;
    display: -webkit-box!important;
    display: -ms-flexbox!important;
    display: flex!important;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

html .orientation-div .orientation .alert-text {
    font-size: 14px;
    color: #fff;
    text-align: center;
    display: block!important;
}

 @media (max-width: 768px) and (orientation:portrait) {
    .orientation-section {
        display: none;
    }
}
@media screen and (min-width: 768px) {
.orientation-section {
        display: none;
    }

}
/*.orientation-section {
        display: none;
    }*/

@media (max-width: 768px) and (orientation:portrait) {
  .col {
    -ms-flex-preferred-size: 0;
    flex-basis: 0;
    -ms-flex-positive: 1;
    flex-grow: 1;
    max-width: 50%;
    margin-top: 7px;
  }
  
  .col-md-12{
    position: relative;
    width: 100%;
    padding-right: 7.5px;
    padding-left: 7.5px;
    margin: 10px;
  }

  .tag-product{
    height: 120px;
  }

}
    
  </style>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MT0B9Q5ZZE"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-MT0B9Q5ZZE');
</script>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
 <!-- <section class="orientation-section">
     <div class="orientation-div"> <div class="orientation"> <center><div class="content" style="color: #ffff;"> <img src="{{ asset('public/images/landscape-m.png') }}" alt="sgonline" style="width:50%;height: 50%;"> <br> Please rotate your device </div></center> <div class="alert-text"> We don't support landscape mode yet. Please go back to portrait mode for the best experience </div> </div> </div>  
  </section> -->
 
<div class="wrapper">

  <!-- Navbar -->
 @include('layouts1.include.header')
  @include('layouts1.include.sidebar')
  <!-- /.navbar -->
<!-- Main Sidebar Container -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="content-header">
      
    </div>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 text-center">
            
             <h1>Delivering quality products at discounted rates - <b>upto 25% off</b></h1> 
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <section class="content">
      @if($promotion_list->count() > 0)
      <section style="margin-bottom: 10px;">
        <div id="carouselExampleControlss" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
                @foreach($promotion_list as $keys => $value)
                  <?php 
                  if (empty($value->link)) {
                    $url = url('brand/').'/'.$value->brand->name;
                  } else {
                    $url = $value->link;
                  }

                  if ($keys == 0) {
                    $class = 'active';
                  } else {
                   $class = '';
                  }
                  
                   ?>
                      <div class="carousel-item {{ $class }}">
                        <a href="{{ $url }}" title="">
                          <center>
                             <img  src="{{ url('storage') }}/{{ $value->banner_url }}" style="max-width:800px;max-height: 150px; width:100%;">
                          </center>
                        </a>
                      </div>
                @endforeach
          </div>
           @if($promotion_list->count() > 1)
          <a class="carousel-control-prev" href="#carouselExampleControlss" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleControlss" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
           @endif
        </div>
      </section>
      @endif
      @include('layouts1.include.searchbox')

      @foreach($home_product as $key => $home_product)
      @if($home_product->position == "Top Selling Products")
        <div class="card">
          <div class="card-header" style="background-color: #184cd8;">
            <b><label class="card-title" style="color:white;">{{ $home_product->position }}</label></b>
          </div>
          <div class="card-body p-0">
              <?php
              $ProductMaster = json_decode($home_product->data);
              $brand_name = '';
              $name = '';
              $photo = '';
              $mrp = '';
              $sale_price = '';
              $product_id_mobile = '';
                foreach($ProductMaster->name as $keys => $v){
                          $name .= $v.'[]';
                          $photo .= $ProductMaster->photo[$keys].'[]';
                          $mrp .= $ProductMaster->mrp[$keys].'[]';
                          $sale_price .= $ProductMaster->sale_price[$keys].'[]';
                          $product_id_mobile .= $ProductMaster->product_id[$keys].'[]';
                }
               $a = 0; ?>
               <input type="hidden" id="name" value="{{ rtrim($name, '[]') }}">
               <input type="hidden" id="photo" value="{{ rtrim($photo, '[]') }}">
               <input type="hidden" id="mrp" value="{{ rtrim($mrp, '[]') }}">
               <input type="hidden" id="sale_price" value="{{ rtrim($sale_price, '[]') }}">
               <input type="hidden" id="product_id_mobile" value="{{ rtrim($product_id_mobile, '[]') }}">
               @if(count($ProductMaster->name) > 5)
                <div class="box-body">
                  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner mobile-carousel">
                          @foreach($ProductMaster->name as $keys => $value)
                            @if($keys%5 == 0 && $keys == 0)
                                <div class="carousel-item active">
                                <div class="row" style="padding: 25px;">
                            @elseif($keys%5 == 0 && $keys != 0)
                                <div class="carousel-item">
                                <div class="row" style="padding: 25px;">
                            @endif
                                <div class="col">
                                  <div class="thumbnail">
                                    @guest
                                    <a  onclick="getmsg('{{ $value }}');" style="color: black;" href="javascript:void(0);">
                                    @endguest
                                  <section class="home-section">
                                    
                                    @if(ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) != 0 && ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) != 100)
                                    <span class="dis_section"> <span>
                                      {{ ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) }}
                                    <span class="per_txt">%</span></span> <br> off </span> 
                                    @endif
                                    <img class="home-product" src="{{ url('storage') }}/{{ $ProductMaster->photo[$keys] }}">
                                    <center style="padding-top:10px;">
                                      <label>{{ $value }}</label><br/>
                                      @if($ProductMaster->mrp[$keys])
                                      <b style="font-size: 75.5%;color: black;">MRP: {{ $ProductMaster->mrp[$keys] }} 
                                      @if($ProductMaster->mrp[$keys] && $ProductMaster->sale_price[$keys])
                                      |
                                      @endif
                                      </b>@endif @if($ProductMaster->sale_price[$keys])<b style="font-size: 75.5%;color: red;">SG Price: {{ $ProductMaster->sale_price[$keys] }}</b>
                                      @endif
                                    </center>
                                  </section>
                                @guest
                                </a>
                                @endguest
                              <center>
                                @if($ProductMaster->product_id[$keys] == 0)
                                  <div class="btn btn-primary btn-sm disabled" >
                                    <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                    Out of Stock
                                  </div>
                                @else
                                   @if(in_array($ProductMaster->product_id[$keys],$cart_product_id_array))
                                      <div class="btn btn-primary btn-sm adds-cart-btn added-cart" data="{{ $ProductMaster->product_id[$keys] }}">
                                      <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                      Remove
                                     </div>
                                    @else
                                  <div class="btn btn-primary btn-sm adds-cart-btn" data="{{ $ProductMaster->product_id[$keys] }}">
                                    <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                    Add to Cart
                                  </div>
                                @endif
                                @endif
                              </center>
                                </div>
                                </div>
                            @if($keys == (count($ProductMaster->name) - 1))
                              @if($keys%5 == 0)
                                  <div class="col">
                                  </div>
                                  <div class="col">
                                  </div>
                                  <div class="col">
                                  </div>
                                  <div class="col">
                                  </div>
                                </div>
                              </div>
                              @endif 
                              @if($keys%5 == 1)
                                  <div class="col">
                                  </div>
                                  <div class="col">
                                  </div>
                                  <div class="col">
                                  </div>
                                </div>
                              </div>
                              @endif 
                              @if($keys%5 == 2)
                                  <div class="col">
                                  </div>
                                  <div class="col">
                                  </div>
                                </div>
                              </div>
                              @endif
                              @if($keys%5 == 1)
                                  <div class="col">
                                  </div>
                                </div>
                              </div>
                              @endif 
                            @endif
                            @if($keys%5 == 4)
                                </div>
                              </div>
                            @endif
                          <?php $a++; ?>
                          @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>
                @else
                <div class="card-body p-0">
              <div class="row" style="padding: 25px;">
              <?php
                $ProductMaster = json_decode($home_product->data);
              ?>
              @foreach($ProductMaster->name as $keys => $value)
                @if($keys > 0 && $keys%5 == 0)
                    @break;
                @endif
                  <div class="col">
                     <div class="thumbnail">
                      @guest
                                    <a  onclick="getmsg('{{ $value }}');" style="color: black;" href="javascript:void(0);">
                                    @endguest
                    <section class="home-section">
                      @if(ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) != 0 && ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) != 100)
                                    <span class="dis_section"> <span>
                                      {{ ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) }}
                                    <span class="per_txt">%</span></span> <br> off </span> 
                                    @endif
                      <img class="home-product" src="{{ url('storage') }}/{{ $ProductMaster->photo[$keys] }}">
                      <center style="padding-top:10px;">
                        <label>{{ $value }}</label><br>
                        @if($ProductMaster->mrp[$keys])
                        <b style="font-size: 75.5%;color: black;">MRP: {{ $ProductMaster->mrp[$keys] }} 
                        @if($ProductMaster->mrp[$keys] && $ProductMaster->sale_price[$keys])
                        |
                        @endif
                        </b>@endif @if($ProductMaster->sale_price[$keys])<b style="font-size: 75.5%; color: red;">SG Price: {{ $ProductMaster->sale_price[$keys] }}</b>
                        @endif
                      </center>
                    </section>
                    @guest
                    </a>
                    @endguest
                  </div>
                  </div>
                  
                @endforeach
              </div>
            </div>
              @endif
          </div>
          
        </div>
      @else
      @if($key == 1 && $offer != '')
        <div class="card">
         <div class="card-body p-0">
            <div class="row">
              <div class="col-md-2">
                <center><h3 class="offer-header">OFFER</h3></center>
              </div>
              <div class="col-md-10">
                  <div class=""><marquee>
                    <h3><?php echo rtrim($offer->product_master_id,"<br>") ?></h3></marquee>
                  </div>
              </div>
            </div>
          </div>
        </div>
      
      @endif
    @if($key == 1 && $tag_data->count() > 0)
      <div class="card">
              <div class="card-header" style="background-color: #184cd8;">
                <b><label class="card-title" style="color:white;">Top Categories</label></b>
              </div>
              <div class="card-body p-0">
                @foreach($tag_data as $keysss => $value)
                  @if($keysss%4 == 0)
                    <div class="row" style="padding: 5px;">
                  @endif
                    <div class="col" >
                       <a  style="color: black;" href="{{ url('category') }}/{{ $value->name }}">
                       <div class="thumbnail">
                           <center>
                            <img class="tag-product" src="{{ url('storage') }}/{{ $value->photo }}"><br/>
                            <label for="">{{ str_replace("_", " ", $value->name) }}</label>
                          </center>
                        </div>
                        </a>
                      </div>
                    @if($keysss > 0 && $keysss%4 == 3)
                    </div>
                    @endif
                  @endforeach
                  @if($tag_data->count()%4 != 3)
                    </div>
                  @endif
              </div>
    </div>
    </div>
    @endif
      <?php
        $brand_name .= $home_product->id.'[]';
      ?>
      <div class="card mobile-{{ $home_product->id }}">
          <div class="card">
              <div class="card-header" style="background-color: #184cd8;">
                <b><label class="card-title" style="color:white;">{{ $home_product->position }} Products</label></b>
                @if($home_product->position == 'Combo Offer')
                  <a href="{{ url('/') }}/{{ str_replace(' ', '_', $home_product->position) }}" class="btn btn-info btn-sm float-right">Explore</a>
                @else
                  <a href="{{ url('/brand/') }}/{{ $home_product->position }}" class="btn btn-info btn-sm float-right">Explore</a>
                @endif
              </div>
              <div class="card-body p-0">
                <div class="row" style="padding: 5px;">
                <?php
                  $ProductMaster = json_decode($home_product->data);
                ?>
                @foreach($ProductMaster->name as $keys => $value)
                  @if($keys > 0 && $keys%5 == 0)
                      @break;
                  @endif
                    <div class="col-md-12">
                       <div class="thumbnail">
                        
                      <section class="home-sections">
                        <div class="row">
                          <div class="col">
                            @if(ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) != 0 && ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) != 100)
                                    <span class="dis_section"> <span>
                                      {{ ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) }}
                                    <span class="per_txt">%</span></span> <br> off </span> 
                                    @endif
                            @guest
                              <a  onclick="getmsg('{{ $value }}');" style="color: black;" href="javascript:void(0);">
                            @endguest
                            <img class="home-product" src="{{ url('storage') }}/{{ $ProductMaster->photo[$keys] }}">
                            @guest
                              </a>
                            @endguest
                          </div>
                          <div class="col">
                            
                              @guest
                              <ul class="list-unstyled" style="text-align: left;font-weight: bold;padding-top: 30px;">
                                    @else
                            <ul class="list-unstyled" style="text-align: left;font-weight: bold;padding-top: 5px;">
                                @endguest
                              <li><u>{{ $value }}</u></li><br/>
                              <li>MRP: {{ $ProductMaster->mrp[$keys] }}</li>
                              <li style="color: red;">SG Price: {{ $ProductMaster->sale_price[$keys] }}</li>
                            </ul>
                            
                                      @if($ProductMaster->product_id[$keys] == 0)
                                        <div class="btn btn-primary btn-sm disabled" >
                                          <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                          Out of Stock
                                        </div>
                                      @else
                                         @if(in_array($ProductMaster->product_id[$keys],$cart_product_id_array))
                                            <div class="btn btn-primary btn-sm add-cart-btn added-cart" data="{{ $ProductMaster->product_id[$keys] }}">
                                            <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                            Remove
                                           </div>
                                          @else
                                        <div class="btn btn-primary btn-sm add-cart-btn" data="{{ $ProductMaster->product_id[$keys] }}">
                                          <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                          Add to Cart
                                        </div>
                                      @endif
                                      @endif
                          </div>
                        </div>
                      </section>
                      
                    </div>
                    </div>
                    
                  @endforeach
                </div>
              </div>
            </div>
      </div>
      <div class="card desktop-{{ $home_product->id }}">
        <div class="card">
          <div class="card-header" style="background-color: #184cd8;">
            <b><label class="card-title" style="color:white;">{{ $home_product->position }} Products</label></b>
            @if($home_product->position == 'Combo Offer')
            <a href="{{ url('/') }}/{{ str_replace(' ', '_', $home_product->position) }}" class="btn btn-info btn-sm float-right">Explore</a>
            @else
              <a href="{{ url('/brand/') }}/{{ $home_product->position }}" class="btn btn-info btn-sm float-right">Explore</a>
            @endif
          </div>
          <div class="card-body p-0">
            <div class="row" style="padding: 25px;">
            <?php
              $ProductMaster = json_decode($home_product->data);
            ?>
            @foreach($ProductMaster->name as $keys => $value)
              @if($keys > 0 && $keys%5 == 0)
                  @break;
              @endif
                <div class="col">
                   <div class="thumbnail">
                    @guest
                                  <a  onclick="getmsg('{{ $value }}');" style="color: black;" href="javascript:void(0);">
                                  @endguest
                  <section class="home-section">
                    @if(ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) != 0 && ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) != 100)
                                    <span class="dis_section"> <span>
                                      {{ ceil(((float)$ProductMaster->mrp[$keys] - (float)$ProductMaster->sale_price[$keys])*100/(float)$ProductMaster->mrp[$keys]) }}
                                    <span class="per_txt">%</span></span> <br> off </span> 
                                    @endif
                    <img class="home-product" src="{{ url('storage') }}/{{ $ProductMaster->photo[$keys] }}">
                    <center style="padding-top:10px;">
                      {{ $value }}</label><br>
                      @if($ProductMaster->mrp[$keys])
                      <b style="font-size: 75.5%;color: black;">MRP: {{ $ProductMaster->mrp[$keys] }} 
                      @if($ProductMaster->mrp[$keys] && $ProductMaster->sale_price[$keys])
                      |
                      @endif
                      </b>@endif @if($ProductMaster->sale_price[$keys])<b style="font-size: 75.5%; color: red;">SG Price: {{ $ProductMaster->sale_price[$keys] }}</b>
                      @endif
                     
                    </center>
                  </section>
                  @guest
                  </a>
                  @endguest
                    <center>
                      @if($ProductMaster->product_id[$keys] == 0)
                        <div class="btn btn-primary btn-sm disabled" >
                          <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                          Out of Stock
                        </div>
                      @else
                         @if(in_array($ProductMaster->product_id[$keys],$cart_product_id_array))
                            <div class="btn btn-primary btn-sm add-cart-btn added-cart" data="{{ $ProductMaster->product_id[$keys] }}">
                            <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                            Remove
                           </div>
                          @else
                        <div class="btn btn-primary btn-sm add-cart-btn" data="{{ $ProductMaster->product_id[$keys] }}">
                          <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                          Add to Cart
                        </div>
                      @endif
                      @endif
                    </center>
                </div>
                </div>
                
              @endforeach
            </div>
          </div>
        </div>
          
      </div>
      @endif
      @endforeach
      <input type="hidden" id="brand_name" value="{{ rtrim($brand_name, '[]') }}">
      <section id="responsive-html">
        
      </section>
      @if(count($Area)  != 0)
      <div class="card">
            <div class="card-header" style="background-color: #333;">
              <b><label class="card-title" style="color:white;">Delivery now available at select areas in: </label></b>
            </div>
            <div class="card-body p-0">
                <div class="row" style="padding: 25px;">
                    <div class="col-md-12">
                      <div class="">
                        <?php $html = '';  ?>
                        @foreach($Area as $key => $value)
                          <?php $html .= $value.',  ';  ?>
                        @endforeach
                        <label>{{ rtrim($html, ", ") }}.</label>
                      </div>
                    </div>
              </div>
            </div>
        </div>
      @endif

      <div class="card">
            <div class="card-header bg-warning">
              <b><label class="card-title" style="color:white;">Contact Us</label></b>
            </div>
            <div class="card-body p-0">
               <div class="row" style="padding: 25px;">
                  <div class="col-md-12">
                    <span>
                      WhatsApp or Call us: <label>9321504147</label> | 10:00 AM to 7:00 PM, <label>365</label> days.<br/>
                      <a href="{{ url('terms-and-condition') }}" target="_blank" title="">Terms and Conditions</a>,
                      <a href="{{ url('privacy-policy') }}" target="_blank" title="">Privacy Policy</a>,
                      <a href="{{ url('disclaimer') }}" target="_blank" title="">Disclaimer</a>.
                    </span>
                  </div>
                </div>
            </div>
        </div>
    </section>
  <!-- /.content-wrapper -->
  </div>

    <div id="myButton"></div>
  <!-- Main Footer -->
  <footer class="main-footer" style="color: black;">
    
    Copyright &copy; 2020 - <strong>Savita's Grocery</strong> | All Rights Reserved | Managed by <strong><a href="https://www.sanchitsolutions.com/" target="_blank">Sanchit Solutions</a></strong>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('public/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('public/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@yield('js')
<!-- AdminLTE -->
<script src="{{ asset('public/adminlte/dist/js/adminlte.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('public/adminlte/plugins/toastr/toastr.min.js') }}"></script>
<!-- OPTIONAL SCRIPTS -->
<!-- <script src="{{ asset('public/adminlte/plugins/chart.js/Chart.min.js') }}"></script> -->
<script src="{{ asset('public/adminlte/dist/js/demo.js') }}"></script>
<!-- <script src="{{ asset('public/adminlte/dist/js/pages/dashboard3.js') }}"></script> -->
<script type="text/javascript" src="{{ asset('public/chat/floating-wpp.js') }}"></script>
  @if(!empty(Auth::user()) && Auth::user()->hasRole('admin'))

  @else
  <script src="{{ asset('public/adminlte/js/bootstrap3-typeahead.min.js') }}"></script>
  <script type="text/javascript">
    $("#search_form").submit(function(){
      if ($('#search').val() =='' ){
        toastr.error('No search data found!!');
        return false;
      }else{
          if ($('#search_type').val() == 'brand') {
            window.location.href = '{{ url('') }}/brand/'+$('#search').val();
            return false;
          } else {
            window.location.href = '{{ url('') }}/search/'+$('#search').val();
            return false;
          }
      }
    });
    $('.typeahead').hide();
        var route = "{{ url('get-search-data') }}";
        $(document).ready(function() {
        var product_id = '{{ $cart }}';
        var cart_count = parseInt('{{ $cart_count }}');
         
    });
      $('#search').typeahead({
          source:  function (term, process) {
            return $.get(route, { term: term,filter:$('#filter_search').val() }, function (data) {
                var html = '';
                process($.map(data.brand,function(obj){
                       html += '<li>\
                              <a class="dropdown-item search-drop" href="#" role="option" type="brand" data="'+obj.name+'">'+obj.name+'</a></li>';
                }));
                process($.map(data.product,function(obj){
                        // console.log(obj);
                         html += '<li>\
                              <a class="dropdown-item " href="#" role="option" ><span class="search-drop" type="product" data="'+obj.name+'">'+obj.name+'</span>';
                        if (obj.product_id==0) {
                           html +='<div class="btn btn-primary btn-sm disabled float-right" style="margin-left: 20px;" >\
                                      <i class="fas fa-cart-plus fa-lg mr-2"></i>Out of Stock</div>';
                        }else{
                          if (obj.cart) {
                             html +='<div class="btn btn-primary btn-sm add-cart-btn added-cart float-right" style="margin-left: 20px;" data="'+obj.product_id+'">\
                                                  <i class="fas fa-cart-plus fa-lg mr-2"></i>Remove</div>';
                          } else {
                            html += '<div class="btn btn-primary btn-sm add-cart-btn float-right" style="margin-left: 20px;" data="'+obj.product_id+'">\
                                  <i class="fas fa-cart-plus fa-lg mr-2"></i>Add to Cart\
                                </div>';

                          }
                        }
                       
                             html += ' </a>\
                            </li>';
                             
                        // return (obj);
                }));
                process($.map(data.result_combo,function(obj){
                        // console.log(obj);
                         html += '<li>\
                              <a class="dropdown-item " href="#" role="option" ><span class="search-drop" type="product" data="'+obj.name+'">'+obj.name+'</span>';
                        if (obj.product_id==0) {
                           html +='<div class="btn btn-primary btn-sm disabled float-right" style="margin-left: 20px;" >\
                                      <i class="fas fa-cart-plus fa-lg mr-2"></i>Out of Stock</div>';
                        }else{
                          if (obj.cart) {
                             html +='<div class="btn btn-primary btn-sm add-cart-btn added-cart float-right" style="margin-left: 20px;" data="'+obj.product_id+'">\
                                                  <i class="fas fa-cart-plus fa-lg mr-2"></i>Remove</div>';
                          } else {
                            html += '<div class="btn btn-primary btn-sm add-cart-btn float-right" style="margin-left: 20px;" data="'+obj.product_id+'">\
                                  <i class="fas fa-cart-plus fa-lg mr-2"></i>Add to Cart\
                                </div>';

                          }
                        }
                       
                             html += ' </a>\
                            </li>';
                             
                        // return (obj);
                }));
                $('.typeahead').show();
                $('.typeahead').html(html);
              $(".search-drop").click(function() {
                $('#search').val($(this).attr('data'));
                if ($(this).attr('type') == 'brand') {
                  $('#search_type').val('brand');
                  window.location.href = '{{ url('') }}/brand/'+$('#search').val();
                } else {
                  $('#search_type').val('product');
                  window.location.href = '{{ url('') }}/search/'+$('#search').val();
                }

              }); 
              $(".add-cart-btn").click(function() {
                if ($(this).hasClass("added-cart")) {
                  //remove
                  cart_count -= 1;
                  $(this).removeClass("added-cart");
                  var products_array = (product_id).split(',');
                  var remove = $(this).attr('data');
                  products_array = $.grep(products_array,function(value){
                      return value != remove;
                  });
                  var new_array = '';
                  for(i = 0; i < products_array.length; i++){
                      new_array +=products_array[i]+',';
                  }
                  product_id = new_array;
                  $(this).html('<i class="fas fa-cart-plus fa-lg mr-2"></i>Add to Cart');
                }else{
                  cart_count += 1;
                  // add to cart
                  var products_array = (product_id).split(',');
                  if($.inArray($(this).attr('data'), products_array) !== -1){
                    toastr.error('already added in cart');
                  }else{
                    $(this).addClass("added-cart");
                    if (product_id == '') {
                      product_id = $(this).attr('data');
                    } else {
                      product_id += ','+$(this).attr('data');
                    }
                    $(this).html('<i class="fas fa-cart-plus fa-lg mr-2"></i>Remove');
                  }
                }
                var routess = "{{ url('add-cart') }}";
                $.get(routess, { product_id: product_id }, function (data) {
                  cart_count = data.count;
                  $('.navbar-badge').html(cart_count);
                  product_id = data.product;
                    return data;
                });
              });
            });
          }
      });
      $('#search').keyup(function(){
          if ($('#search').val()== '') {
            $('.typeahead').html('');
            $('.typeahead').hide();
          }
      });
  </script>
  @endif
<?php  if(empty(Auth::user())){ ?>
<script>

  $(function () {
    $('#myButton').on('click',function(){
        // if(window.innerHeight > window.innerWidth){
            $('.orientation-section').css("display", "none");
        // }
      
    });
    $('#myButton').floatingWhatsApp({
            phone: '919321504147',
            popupMessage: 'Namaste, what would you like to buy?',
            message: "I would like to buy ...",
            // placeholder: "I would like to buy ...",
            position: "right",
            showPopup: true,
            showOnIE: false,
            headerTitle: 'Savita’s Grocery - Online',
            headerColor: '#25d366',
            backgroundColor: 'crimson',
            buttonImage: '<img src="{{ asset('public/chat/whatsapp.svg') }}" />'
        });
    });
  </script>
<?php } ?>
<script>
  var product_id = '{{ $cart }}';
  var cart_count = parseInt('{{ $cart_count }}');
      $(".adds-cart-btn").click(function() {
        if ($(this).hasClass("added-cart")) {
            //remove

            cart_count -= 1;
          $(this).removeClass("added-cart");
          var products_array = (product_id).split(',');
          var remove = $(this).attr('data');
          products_array = $.grep(products_array,function(value){
              return value != remove;
          });
          var new_array = '';
          for(i = 0; i < products_array.length; i++){
              new_array +=products_array[i]+',';
          }
          product_id = new_array;
          $(this).html('<i class="fas fa-cart-plus fa-lg mr-2"></i>Add to Cart');
        }else{
          cart_count += 1;
          // add to cart
          var products_array = (product_id).split(',');
          if($.inArray($(this).attr('data'), products_array) !== -1){
            toastr.error('already added in cart');
          }else{
            $(this).addClass("added-cart");
            if (product_id == '') {
              product_id = $(this).attr('data');
            } else {
              product_id += ','+$(this).attr('data');
            }
            $(this).html('<i class="fas fa-cart-plus fa-lg mr-2"></i>Remove');
          }
        }
         var route = "{{ url('add-cart') }}";
         $.get(route, { product_id: product_id }, function (data) {
              cart_count = data.count;
              $('.navbar-badge').html(cart_count);
              product_id = data.product;
                return data;
            });
         
         
        
      });

  $(function () {
    var mobile_html = '';
    var desktop_html = '';
    var name = ($('#name').val()).split('[]');
    var brand_name = ($('#brand_name').val()).split('[]');
    var photo = ($('#photo').val()).split('[]');
    var mrp_price = ($('#mrp').val()).split('[]');
    var sale_price = ($('#sale_price').val()).split('[]');
    var product_id_mobile = ($('#product_id_mobile').val()).split('[]');
    var html = '';
    $.each(brand_name, function( key, values ) {
        desktop_html +=$('.desktop-'+values).html();
        mobile_html +=$('.mobile-'+values).html();
        $('.mobile-'+values).remove();
        $('.desktop-'+values).remove();
    });
    $.each(name, function( key, values ) {
      var a = '';
      offer = '';
      if(Math.ceil((parseFloat(mrp_price[key]) - parseFloat(sale_price[key]))*100/parseFloat(mrp_price[key])) != 0 && Math.ceil((parseFloat(mrp_price[key]) - parseFloat(sale_price[key]))*100/parseFloat(mrp_price[key])) != 100){
                        offer += '<span class="dis_section"> <span>\
                                '+Math.ceil((parseFloat(mrp_price[key]) - parseFloat(sale_price[key]))*100/parseFloat(mrp_price[key]))+'\
                              <span class="per_txt">%</span></span> <br> off </span>';
     }
        if(key == 0){
          a = 'active';
        }
                        var mrp = '';
                        if(mrp_price[key] != ''){
                          mrp = '<b style="font-size: 75.5%;color: black;">MRP: '+mrp_price[key]+'</b>';
                        }
                        
                        if(mrp_price[key] != '' && sale_price[key] != ''){
                          mrp += ' | ';
                        }
                        if(sale_price[key] != ''){
                          mrp += '<b style="font-size: 75.5%;color: red;">SG Price: '+sale_price[key]+'</b>';
                        }
                       
                html +='<div class="carousel-item '+a+'"> <div style="margin:5px;" class="thumbnail">@guest<a  onclick="getmsg('+"'"+values+"'"+');" style="color: black;" href="javascript:void(0);">@endguest<section class="home-section">'+offer+'\
                                    <img class="home-product" src="{{ url('storage') }}/'+photo[key]+'">\
                                    <center style="padding-top:10px;">\
                                      <label>'+values+'</label><br/>'+mrp+'\
                                    </center>\
                                  </section>\
                                  @guest\
                              </a>\
                              @endguest\
                            <center>';
                              if(product_id_mobile[key] == 0){
                                html +='<div class="btn btn-primary btn-sm disabled" >\
                                  <i class="fas fa-cart-plus fa-lg mr-2"></i>Out of Stock</div>';
                              }
                              else{
                                var products_array = (product_id).split(',');
                                if($.inArray(product_id_mobile[key], products_array) !== -1){
                                  html +='<div class="btn btn-primary btn-sm add-cart-btn added-cart" data="'+product_id_mobile[key]+'">\
                                              <i class="fas fa-cart-plus fa-lg mr-2"></i>Remove</div>';
                                }else{
                                  html +='<div class="btn btn-primary btn-sm add-cart-btn" data="'+product_id_mobile[key]+'">\
                                  <i class="fas fa-cart-plus fa-lg mr-2"></i>Add to Cart</div>';
                                }
                              }
                            html +='</center>\
                             </div></div>';
    });
    if(window.matchMedia("(max-width: 770px)").matches){
                  $('.mobile-carousel').html('');   
                  $('.mobile-carousel').html(html);  
                  $('#responsive-html').html(mobile_html);  
                  $(".add-cart-btn").click(function() {
                    if ($(this).hasClass("added-cart")) {
                        //remove
                        cart_count -= 1;
                      $(this).removeClass("added-cart");
                       var products_array = (product_id).split(',');
                      var remove = $(this).attr('data');
                      products_array = $.grep(products_array,function(value){
                          return value != remove;
                      });
                      var new_array = '';
                      for(i = 0; i < products_array.length; i++){
                          new_array +=products_array[i]+',';
                      }
                      product_id = new_array;
                      $(this).html('<i class="fas fa-cart-plus fa-lg mr-2"></i>Add to Cart');
                    }else{
                      cart_count += 1;
                      var products_array = (product_id).split(',');
                      if($.inArray($(this).attr('data'), products_array) !== -1){
                        toastr.error('already added in cart');
                      }else{
                        $(this).addClass("added-cart");
                        if (product_id == '') {
                          product_id = $(this).attr('data');
                        } else {
                          product_id += ','+$(this).attr('data');
                        }
                        $(this).html('<i class="fas fa-cart-plus fa-lg mr-2"></i>Remove');
                      }
                    }
                     var route = "{{ url('add-cart') }}";
                     $.get(route, { product_id: product_id }, function (data) {
                          cart_count = data.count;
                          $('.navbar-badge').html(cart_count);
                          product_id = data.product;
                            return data;
                        });
                     // console.log($(this).attr('data'));
                    
                    
                  });
                }else{
                  $('#responsive-html').html(desktop_html);
                  $(".add-cart-btn").click(function() {
                    if ($(this).hasClass("added-cart")) {
                        //remove
                        cart_count -= 1;
                      $(this).removeClass("added-cart");
                       var products_array = (product_id).split(',');
                      var remove = $(this).attr('data');
                      products_array = $.grep(products_array,function(value){
                          return value != remove;
                      });
                      var new_array = '';
                      for(i = 0; i < products_array.length; i++){
                          new_array +=products_array[i]+',';
                      }
                      product_id = new_array;
                      $(this).html('<i class="fas fa-cart-plus fa-lg mr-2"></i>Add to Cart');
                    }else{
                      cart_count += 1;
                      var products_array = (product_id).split(',');
                      if($.inArray($(this).attr('data'), products_array) !== -1){
                        toastr.error('already added in cart');
                      }else{
                        $(this).addClass("added-cart");
                        if (product_id == '') {
                          product_id = $(this).attr('data');
                        } else {
                          product_id += ','+$(this).attr('data');
                        }
                        $(this).html('<i class="fas fa-cart-plus fa-lg mr-2"></i>Remove');
                      }
                      // add to cart
                      
                      
                    }
                     var route = "{{ url('add-cart') }}";
                     $.get(route, { product_id: product_id }, function (data) {
                          cart_count = data.count;
                          product_id = data.product;
                          $('.navbar-badge').html(cart_count);
                            return data;
                        });
                     
                     
                    
                  });
                }

   });  

  function getmsg(product){
    var url = 'https://api.whatsapp.com/send?phone=919321504147&text=SGO - I would like to order '+product+' - Qty:';
    window.open(url, '_blank');
   }          
</script>
</body>
</html>
