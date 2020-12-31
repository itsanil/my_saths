<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
     <ul class="nav navbar-nav navbar-center" style="position: absolute;left: 50%;
    transform: translatex(-50%);">
            <!-- <li class="text-center"><img src="{{ asset('public/images/store.png') }}" style="width: 263px;" alt=""></li> -->
            <li><label style="font-size:22px;">Savita's Grocery</label></li>

            
        </ul>
    
@if(!empty(Auth::user()) && Auth::user()->hasRole('admin'))
@else
<ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a href="{{ url('my-order/create') }}" style="color: white;">
        <div class="btn btn-primary btn-sm">
          <i class="fas fa-cart-plus fa-lg mr-2"></i> 
          Cart
          <span class="badge count-cart badge-danger navbar-badge" style="top: -12px;font-size: 13px;"><?php if (isset($cart_product_id_array) && $cart_product_id_array[0] != '') {
            echo count($cart_product_id_array);
          } else {
            echo '0';
          }
           ?></span>
        </div>
       </a>
       <!--  <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-cart-plus fa-lg mr-2"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a> -->
    </ul>
@endif
</nav>