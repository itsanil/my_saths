@extends('layouts1.main')
@section('title')
<?php 
$current_path = Route::getFacadeRoot()->current()->uri();
if(strpos($current_path, 'brand') !== false){
    echo "Brand";
} else{
  if(strpos($current_path, 'search') !== false){
    echo "Search Result";
  }
  if(strpos($current_path, 'Combo_Offer') !== false){
    echo "Combo Offer";
  }else{
    echo "Category";
  }
}

 ?>
 > {{ str_replace("_", " ", $name) }} 
@endsection
@section('section_page') 
<?php 
$current_path = Route::getFacadeRoot()->current()->uri();
// echo "<pre>"; print_r($current_path); echo "</pre>"; die('end of code');
if(strpos($current_path, 'brand') !== false){
    echo "Brand - ".str_replace("_", " ", $name);
} else{
  if(strpos($current_path, 'search') !== false){
    echo "Search Result";
  }
  if(strpos($current_path, 'Combo_Offer') !== false){
    echo "Combo Offer";
  }else{
    echo "Category - ".str_replace("_", " ", $name);
  }
}

 ?>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('public/chat/floating-wpp.css') }}">
<style type="text/css" media="screen">
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
.home-product{
  height: 175px;
  width:100%;
  /*width:175px;*/
}

.colss {
    -ms-flex-preferred-size: 0;
    /* flex-basis: 0; */
    -ms-flex-positive: 1;
    /* flex-grow: 1; */
    /*max-width: 100%;*/
    /*-ms-flex: 0 0 25%;*/
    flex: 0 0 25%;
    max-width: 20%;
    padding: 5px;
}

@media only screen and (max-width: 768px) {
  /* For mobile phones: */
 .desktops{
  display: none;
 }
 .mobiles{
      display: block;
    }
}

@media screen and (min-width: 768px) {
    .desktops{
      display: block;
    }

    .mobiles{
      display: none;
    }
}



/* On screens that are 992px wide or less, the background color is blue */
/*.desktops{
      display: block;
    }

    .mobiles{
      display: none;
    }

@media screen and (min-width: 768px) {
    .desktops{
      display: block;
    }

    .mobiles{
      display: none;
    }
}

@media screen and (max-width: 768px) {
    .desktops{
      display: none;
    }

    .mobiles{
      display: block;
    }
}
*/
@media only screen and (max-width: 768px) {
  /* For mobile phones: */
  .home-product{
      height: 175px;
      width:auto;
      /*width:175px;*/
    }

    .col-md-12{
    position: relative;
    width: 100%;
    padding-right: 7.5px;
    padding-left: 7.5px;
    margin-top: 10px;
  }
}

#loadMore,#mobile_loadMore {
  width: 200px;
  color: #fff;
  display: block;
  text-align: center;
  margin: 20px auto;
  padding: 10px;
  border-radius: 10px;
  border: 1px solid transparent;
  background-color: blue;
  transition: .3s;
}
#loadMore:hover {
  color: blue;
  background-color: #fff;
  border: 1px solid blue;
  text-decoration: none;
}
.noContent {
  color: #000 !important;
  background-color: transparent !important;
  pointer-events: none;
}


@guest
 .home-section{
  /*border: 2px solid black;*/
    padding: 10px;
    text-align: center;
    /*height: 100%!important;*/
}     

@else
.home-section{
  /*border: 2px solid black;*/
    padding: 10px;
    text-align: center;
    /*height: 100%!important;*/
}

@endguest

 .count-cart{
    position: relative;
    top: -12px;
    font-size: 13px;
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

    
  </style>
@endsection
@section('js')

<script type="text/javascript" src="{{ asset('public/chat/floating-wpp.js') }}"></script>
<script>
  var desktop_html = $('.desktops').html();
  var mobile_html = $('.mobiles').html();
  var product_id = '{{ $cart }}';
  var cart_count = parseInt('{{ $cart_count }}');
      $(".add-cart-btn").click(function() {
        console.log($(this).hasClass("added-cart"));
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
              product_id = data.product;
              $('.navbar-badge').html(cart_count);
                return data;
            });
         // console.log($(this).attr('data'));
         
        
      });
      $(".filter-tag").click(function() {
        $(".filter-tag").removeClass("active");
        if ($(this).hasClass("active")) {
            //all tag
          $(this).removeClass("active");
        }else{
          // apply tag
          $(this).addClass("active");
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ route("tag.product") }}',
            data: {
              '_token': $('input[name=_token]').val()
              ,'tag': $(this).attr('data')
              ,'brand': $(this).attr('brand')
            },
            success: function(response) {
              $('.desktops').html('');
              $('.mobiles').html('');
              var html1 = '<div class="card"><div class="card-body">';
              var html = html1;
              var mobile_html = html1;
              if ((response.success)) {
                $.each(response.data, function( key, values ) {
                        if(key%5 == 0){
                          html += '<div class="row" style="padding: 25px;">';
                          mobile_html += '<div class="row" style="padding: 25px;">';
                        }
                        offer = '';
                        if(Math.ceil((parseFloat(values.mrp) - parseFloat(values.sale_price))*100/parseFloat(values.mrp)) != 0 && Math.ceil((parseFloat(values.mrp) - parseFloat(values.sale_price))*100/parseFloat(values.mrp)) != 100){
                                          offer += '<span class="dis_section"> <span>\
                                                  '+Math.ceil((parseFloat(values.mrp) - parseFloat(values.sale_price))*100/parseFloat(values.mrp))+'\
                                                <span class="per_txt">%</span></span> <br> off </span>';
                       }
                          html += '<div class="col" style="max-width: 20%;">\
                                    <div class="thumbnail">\
                                      @guest\
                                        <a  onclick="getmsg('+values.name+');" style="color: black;" href="javascript:void(0);">\
                                      @endguest\
                                      <section class="home-section">'+offer+'\
                                        <img class="home-product" src="{{ url('storage') }}/'+values.photo+'">\
                                        <center style="padding-top:10px;">\
                                          <label>'+values.name+'</label><br/>';
                                         if(values.mrp){
                                            html += '<b style="font-size: 75.5%;color: black;">MRP: '+values.mrp+'</b>';
                                         }
                                         if(values.mrp && values.sale_price){
                                          html += ' | ';
                                         }
                                         if(values.sale_price){
                                            html += '<b style="font-size: 75.5%; color: red;">SG Price: '+values.sale_price+'</b>';
                                         }
                                         html += '</center>\
                                      </section>\
                                      @guest\
                                        </a>\
                                     @endguest\
                                      <center>';
                                        if(values.product_id == 0){
                                             html +='<div class="btn btn-primary btn-sm disabled" >\
                                            <i class="fas fa-cart-plus fa-lg mr-2"></i>Out of Stock</div>';
                                        }else{
                                          var products_array = (product_id).split(',');
                                          var status = false;
                                          $.each(products_array, function( index, value ) {
                                              if(value == values.product_id){
                                                 status = true; 
                                              }
                                          });
                                          if (status) {
                                            html +='<div class="btn btn-primary btn-sm add-cart-btn added-cart" data="'+values.product_id+'">\
                                          <i class="fas fa-cart-plus fa-lg mr-2"></i>Remove</div>';
                                          } else {
                                            html +='<div class="btn btn-primary btn-sm add-cart-btn" data="'+values.product_id+'">\
                                          <i class="fas fa-cart-plus fa-lg mr-2"></i>Add to Cart</div>';
                                          }
                                          
                                        }
                                      html +='</center>\
                                            </div>\
                                          </div>';
                            mobile_html += '<div class="col-md-12">\
                                    <div class="thumbnail">\
                                      <section class="home-sections">\
                                        <div class="row">\
                                        <div class="col">';
                                        if(Math.ceil((parseFloat(values.mrp) - parseFloat(values.sale_price))*100/parseFloat(values.mrp)) != 0 && Math.ceil((parseFloat(values.mrp) - parseFloat(values.sale_price))*100/parseFloat(values.mrp)) != 100){
                                          mobile_html += '<span class="dis_section"> <span>\
                                                  '+Math.ceil((parseFloat(values.mrp) - parseFloat(values.sale_price))*100/parseFloat(values.mrp))+'\
                                                <span class="per_txt">%</span></span> <br> off </span>';
                                        }
                                        mobile_html += '@guest\
                                          <a  onclick="getmsg('+values.name+');" style="color: black;" href="javascript:void(0);">\
                                        @endguest\
                                          <img class="home-product" src="{{ url('storage') }}/'+values.photo+'">\
                                        @guest\
                                          </a>\
                                        @endguest\
                                        </div>\
                                        <div class="col"> @guest\
                                          <ul class="list-unstyled" style="text-align: left;font-weight: bold;padding-top: 30px;">\
                                              @else\
                                              <ul class="list-unstyled" style="text-align: left;font-weight: bold;padding-top: 5px;">\
                                          @endguest\
                                            <li><u>'+values.name+'</u></li><br/>\
                                            <li>MRP: '+values.mrp+'</li>\
                                            <li style="color: red;">SG Price: '+values.sale_price+'</li>\
                                          </ul>';
                                         mobile_html +='';
                                          if(values.product_id == 0){
                                      mobile_html +='<div class="btn btn-primary btn-sm disabled" >\
                                            <i class="fas fa-cart-plus fa-lg mr-2"></i>Out of Stock</div>';
                                        }else{
                                          var products_array = (product_id).split(',');
                                          var status = false;
                                          $.each(products_array, function( index, value ) {
                                              if(value == values.product_id){
                                                 status = true; 
                                              }
                                          });
                                          if (status) {
                                            mobile_html +='<div class="btn btn-primary btn-sm add-cart-btn added-cart" data="'+values.product_id+'">\
                                          <i class="fas fa-cart-plus fa-lg mr-2"></i>Remove</div>';
                                          } else {
                                            mobile_html +='<div class="btn btn-primary btn-sm add-cart-btn" data="'+values.product_id+'">\
                                          <i class="fas fa-cart-plus fa-lg mr-2"></i>Add to Cart</div>';
                                          }
                                        }
                                      mobile_html +='</div>\
                                      </div>\
                                      </section>\
                                    </div>\
                                  </div>';
                        if(key%5 == 4){
                          html += '</div>';
                          mobile_html += '</div>';
                        }
                });
                $('.desktops').html(html);
                $('.mobiles').html(mobile_html);
              } else {
                html += '<center><label>No Data Found</label></center></div>';
                mobile_html += '<center><label>No Data Found</label></center></div>';
               $('.desktops').html(html);
               $('.mobiles').html(mobile_html);
               
              }
               if(window.matchMedia("(max-width: 768px)").matches){
                 // $('#responsive').html(mobile_html);  
                 $('.desktops').html('');
                 $(".desktop-flex").hide();
               }else{
                 $('.mobiles').html('');
                 // $('#responsive').html(desktop_html);  
               }
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
                  product_id = data.product;
                  $('.navbar-badge').html(cart_count);
                    return data;
                });
                
              });
            },


          });
        }
        //  console.log($(this).attr('data'));
         
        
      });
        if(window.matchMedia("(max-width: 768px)").matches){
          // $('#responsive').html(mobile_html);  
          $('.desktops').remove();
        }else{
          $('.mobiles').html('');
          // $('#responsive').html(desktop_html);  
        }
   function getmsg(product){
    var url = 'https://api.whatsapp.com/send?phone=919321504147&text=SGO - I would like to order '+product+' - Qty:';
    window.open(url, '_blank');
   } 
$(document).ready(function(){
  $(".releted-product").hide();
  $(".releted-product").slice(0, 1).show();
  $("#loadMore").on("click", function(e){
    e.preventDefault();
    $(".releted-product:hidden").slice(0, 1).slideDown();
    if($(".releted-product:hidden").length == 0) {
      $("#loadMore").hide();
    }
  });

  $(".mobile-releted-products").hide();
  $(".mobile-releted-products").slice(0, 4).show();
  $("#mobile_loadMore").on("click", function(e){
    e.preventDefault();
    $(".mobile-releted-products:hidden").slice(0, 4).slideDown();
    if($(".mobile-releted-products:hidden").length == 0) {
      $("#mobile_loadMore").hide();
    }
  });
  
})

</script>

@endsection
@section('content')

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
    <section class="content">
      @if($name == 'All')
        <div class="card">
          <div class="card-body p-0">
            @foreach($tag_data as $keys => $value)

              @if($keys%4 == 0)
                  <div class="row" style="padding: 5px;">
              @endif
                <div class="col-md-3">
                  <a  style="color: black;" href="{{ url('tag') }}/{{ $value->name }}">
                    <div class="thumbnail">
                       <center>
                        <img class="home-product" src="{{ url('storage') }}/{{ $value->photo }}"><br/>
                        <label for="">{{ str_replace("_", " ", $value->name) }}</label>
                      </center>
                    </div>
                  </a>
                </div>
                @if($keys > 0 && $keys%3 == 0)
                  </div>
                @endif
              @endforeach
            </div>
        </div>
      @else
      <?php if(isset($tag_list) && (request()->is('brand*'))){ ?>
            <div class="card-header">
              <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-10">
                  <button type="button" data-toggle="dropdown" href="#" aria-expanded="false"  class="btn btn-success float-right nav-link dropdown-toggle">
                      <span>View Category</span> <span class="caret"></span>
                  </button>
                  <div class="dropdown-menu" style="">
                    <a class="dropdown-item filter-tag" data="all" brand="{{ $name }}" tabindex="-1" href="#">All</a>
                    @foreach($brand_tag as $key => $value)
                    <a class="dropdown-item filter-tag" data="{{ $value }}" brand="{{ $name }}" tabindex="-1" href="#">{{ str_replace("_", " ", $value) }}</a>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
      <section class="mobiles">
        <div class="card">
          @if((request()->is('search*')))
            <div class="card-header" style="background-color: #184cd8;">
                <b><label class="card-title" style="color:white;">You searched for : <?php echo str_replace("_", " ", $name); ?></label></b>
            </div>
          @endif 
          
          <div class="card-body p-0">
            <div class="row" style="padding: 25px;">
            @if(isset($combo_product_list))
              @foreach($combo_product_list as $keys => $value)
                  <div class="col-md-12">
                    <div class="thumbnail">
                       <section class="home-sections">
                         
                        <div class="row">
                          <div class="col">
                             @if(!empty($value->mrp) && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 0 && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 100)
                              <span class="dis_section"> <span>
                                {{ ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) }}
                              <span class="per_txt">%</span></span> <br> off </span> 
                              @endif
                            @guest
                              <a  onclick="getmsg('{{ $value->name }}');" style="color: black;" href="javascript:void(0);">
                            @endguest
                                <img class="home-product" src="{{ url('storage') }}/{{ $value->photo }}">
                            @guest
                              </a>
                            @endguest
                          </div>
                          <div class="col">
                            <ul class="list-unstyled" style="text-align: left;font-weight: bold;padding-top: 5px;">
                              <li><u>{{ $value->name }}</u></li><br/>
                              <li>MRP: {{ $value->mrp }}</li>
                              <li style="color: red;">SG Price: {{ $value->sale_price }}</li>
                            </ul>
                                @if($value->product_id == 0)
                                  <div class="btn btn-primary btn-sm disabled" >
                                    <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                    Out of Stock
                                  </div>
                                @else
                                  @if(in_array($value->product_id,$cart_product_id_array))
                                    <div class="btn btn-primary btn-sm add-cart-btn added-cart" data="{{ $value->product_id }}">
                                      <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                      Remove
                                    </div>
                                  @else
                                    <div class="btn btn-primary btn-sm add-cart-btn" data="{{ $value->product_id }}">
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
            @endif
              @foreach($product_list as $keys => $value)
                  <div class="col-md-12">
                    <div class="thumbnail">
                       <section class="home-sections">
                         
                        <div class="row">
                          <div class="col">
                             @if(!empty($value->mrp) && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 0 && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 100)
                              <span class="dis_section"> <span>
                                {{ ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) }}
                              <span class="per_txt">%</span></span> <br> off </span> 
                              @endif
                            @guest
                              <a  onclick="getmsg('{{ $value->name }}');" style="color: black;" href="javascript:void(0);">
                            @endguest
                                <img class="home-product" src="{{ url('storage') }}/{{ $value->photo }}">
                            @guest
                              </a>
                            @endguest
                          </div>
                          <div class="col">
                            <ul class="list-unstyled" style="text-align: left;font-weight: bold;padding-top: 5px;">
                              <li><u>{{ $value->name }}</u></li><br/>
                              <li>MRP: {{ $value->mrp }}</li>
                              <li style="color: red;">SG Price: {{ $value->sale_price }}</li>
                            </ul>
                                @if($value->product_id == 0)
                                  <div class="btn btn-primary btn-sm disabled" >
                                    <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                    Out of Stock
                                  </div>
                                @else
                                  @if(in_array($value->product_id,$cart_product_id_array))
                                    <div class="btn btn-primary btn-sm add-cart-btn added-cart" data="{{ $value->product_id }}">
                                      <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                      Remove
                                    </div>
                                  @else
                                    <div class="btn btn-primary btn-sm add-cart-btn" data="{{ $value->product_id }}">
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

        
          @if(isset($releted_product_list) && !empty($releted_product_list) &&  (request()->is('search*')))
          <div class="card">
            <div class="card-header" style="background-color: #184cd8;">
                <b><label class="card-title" style="color:white;">Related Products</label></b>
            </div>
            <div class="flex">
                <div class="card-body p-0">
                @foreach($product_list as $keys => $value)
                @if($keys%5 == 0)
                    <div class="row" style="padding-left: 25px;padding-right: 25px;">
                @endif
                  <div class="col-md-12">
                    <div class="thumbnail mobile-releted-products">
                       <section class="home-sections">
                       
                        <div class="row ">
                          <div class="col">
                            @if(!empty($value->mrp) && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 0 && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 100)
                              <span class="dis_section"> <span>
                                {{ ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) }}
                              <span class="per_txt">%</span></span> <br> off </span> 
                              @endif
                            @guest
                              <a  onclick="getmsg('{{ $value->name }}');" style="color: black;" href="javascript:void(0);">
                            @endguest
                            <img class="home-product" src="{{ url('storage') }}/{{ $value->photo }}">
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
                              <li><u>{{ $value->name }}</u></li><br/>
                              <li>MRP: {{ $value->mrp }}</li>
                              <li style="color: red;">SG Price: {{ $value->sale_price }}</li>
                            </ul>
                            <div class="ribbon bg-danger" style="margin-bottom: 5px;">
                              Discount : 
                              @if($value->mrp)
                              {{ ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) }} %
                              @else
                              0 %
                              @endif
                            </div>
                                @if($value->product_id == 0)
                                  <div class="btn btn-primary btn-sm disabled" >
                                    <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                    Out of Stock
                                  </div>
                                @else
                                   @if(in_array($value->product_id,$cart_product_id_array))
                                    <div class="btn btn-primary btn-sm add-cart-btn added-cart" data="{{ $value->product_id }}">
                                    <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                                    Remove
                                   </div>
                                  @else
                                  <div class="btn btn-primary btn-sm add-cart-btn" data="{{ $value->product_id }}">
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
                @if($keys%5 == 4)
                    </div>
                @endif
                @endforeach
                </div>
                </div>
                <a href="#" id="mobile_loadMore">Load More</a>
               </div>
          @endif
      </section>
      <section class="desktops">
        <div class="card">
          @if((request()->is('search*')))
            <div class="card-header" style="background-color: #184cd8;">
                <b><label class="card-title" style="color:white;">You searched for : <?php echo str_replace("_", " ", $name); ?></label></b>
            </div>
          @endif 
          
          <div class="card-body p-0">
            <div class="row" style="padding: 25px;">
              @if(isset($combo_product_list))
              @foreach($combo_product_list as $keys => $value)
                    <div class="colss" style="max-width: 20%;">
                      <div class="thumbnail">
                        @guest
                          <a  onclick="getmsg('{{ $value->name }}');" style="color: black;" href="javascript:void(0);">
                        @endguest
                        <section class="home-section">
                            @if(!empty($value->mrp) && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 0 && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 100)
                            <span class="dis_section"> <span>
                              {{ ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) }}
                            <span class="per_txt">%</span></span> <br> off </span> 
                            @endif
                          <img class="home-product" src="{{ url('storage') }}/{{ $value->photo }}">
                          <center style="padding-top:10px;">
                            <label>{{ $value->name }}</label><br/>
                                  @if($value->mrp)
                                  <b style="font-size: 75.5%;color: black;">MRP: {{ $value->mrp }}</b>@endif
                                   @if($value->mrp && $value->sale_price)
                                  |
                                   @endif
                                   @if($value->sale_price)<b style="font-size: 75.5%; color: red;">SG Price: {{ $value->sale_price }}</b>
                                  @endif
                          </center>
                        </section>
                        @guest
                          </a>
                        @endguest
                        <center>
                          @if($value->product_id == 0)
                            <div class="btn btn-primary btn-sm disabled" >
                              <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                              Out of Stock
                            </div>
                          @else
                             @if(in_array($value->product_id,$cart_product_id_array))
                              <div class="btn btn-primary btn-sm add-cart-btn added-cart" data="{{ $value->product_id }}">
                              <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                              Remove
                             </div>
                            @else
                            <div class="btn btn-primary btn-sm add-cart-btn" data="{{ $value->product_id }}">
                              <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                              Add to Cart
                            </div>
                           @endif
                          @endif
                        </center>
                      </div>
                    </div>
                 
              @endforeach
              @endif
              @foreach($product_list as $keys => $value)
                <div class="colss" style="max-width: 20%;">
                  <div class="thumbnail">
                    @guest
                      <a  onclick="getmsg('{{ $value->name }}');" style="color: black;" href="javascript:void(0);">
                    @endguest
                    <section class="home-section">
                        @if(!empty($value->mrp) && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 0 && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 100)
                        <span class="dis_section"> <span>
                          {{ ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) }}
                        <span class="per_txt">%</span></span> <br> off </span> 
                        @endif
                      <img class="home-product" src="{{ url('storage') }}/{{ $value->photo }}">
                      <center style="padding-top:10px;">
                        <label>{{ $value->name }}</label><br/>
                              @if($value->mrp)
                              <b style="font-size: 75.5%;color: black;">MRP: {{ $value->mrp }}</b>@endif
                               @if($value->mrp && $value->sale_price)
                              |
                               @endif
                               @if($value->sale_price)<b style="font-size: 75.5%; color: red;">SG Price: {{ $value->sale_price }}</b>
                              @endif
                      </center>
                    </section>
                    @guest
                      </a>
                    @endguest
                    <center>
                      @if($value->product_id == 0)
                        <div class="btn btn-primary btn-sm disabled" >
                          <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                          Out of Stock
                        </div>
                      @else
                         @if(in_array($value->product_id,$cart_product_id_array))
                          <div class="btn btn-primary btn-sm add-cart-btn added-cart" data="{{ $value->product_id }}">
                          <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                          Remove
                         </div>
                        @else
                        <div class="btn btn-primary btn-sm add-cart-btn" data="{{ $value->product_id }}">
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
        @if(isset($releted_product_list) && !empty($releted_product_list) &&  (request()->is('search*')))
          <div class="card desktops desktop-flex">
                <div class="card-header" style="background-color: #184cd8;">
                    <b><label class="card-title" style="color:white;">Related Products</label></b>
                </div>
                <div class="flex">
                  <div class="card-body p-0">
                  @foreach($releted_product_list as $keys => $value)
                  @if($keys%5 == 0)
                      <div class="row releted-product" style="padding: 25px;">
                  @endif
                    <div class="col" style="max-width: 20%;">
                      <div class="thumbnail">
                       @guest
                            <a  onclick="getmsg('{{ $value->name }}');" style="color: black;" href="javascript:void(0);">
                            @endguest
                         <section class="home-section">
                          @if(!empty($value->mrp) && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 0 && ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) != 100)
                          <span class="dis_section"> <span>
                            {{ ceil(((float)$value->mrp - (float)$value->sale_price)*100/(float)$value->mrp) }}
                          <span class="per_txt">%</span></span> <br> off </span> 
                          @endif
                        <img class="home-product" src="{{ url('storage') }}/{{ $value->photo }}">
                        <center style="padding-top:10px;">
                          <label>{{ $value->name }}</label><br/>
                         @if($value->mrp)
                                <b style="font-size: 75.5%;color: black;">MRP: {{ $value->mrp }}</b>@endif
                                 @if($value->mrp && $value->sale_price)
                                |
                                 @endif
                                 @if($value->sale_price)<b style="font-size: 75.5%; color: red;">SG Price: {{ $value->sale_price }}</b>
                                @endif
                        </center>
                      </section>
                      </a>
                      <center>
                        @if($value->product_id == 0)
                          <div class="btn btn-primary btn-sm disabled" >
                            <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                            Out of Stock
                          </div>
                        @else
                           @if(in_array($value->product_id,$cart_product_id_array))
                            <div class="btn btn-primary btn-sm add-cart-btn added-cart" data="{{ $value->product_id }}">
                            <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                            Remove
                           </div>
                          @else
                          <div class="btn btn-primary btn-sm add-cart-btn" data="{{ $value->product_id }}">
                            <i class="fas fa-cart-plus fa-lg mr-2"></i> 
                            Add to Cart
                          </div>
                         @endif
                        @endif
                      </center>
                      </div>
                      </div>
                  @if($keys%5 == 4)
                      </div>
                  @endif
                  @endforeach
                  @if($releted_product_list->count()%5 != 4)
                    </div>
                  @endif
                </div>
                <a href="#" id="loadMore">Load More</a>
          </div>
        @endif
      <!-- </div> -->
      </section>
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
@endsection
