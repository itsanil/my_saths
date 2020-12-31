<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="">
        <center>
            <img src="{{ asset('public/images/sglogo.jpg') }}" alt="sgLogo" class=""
           style="width:175px;height:auto;padding-top: 20px;padding-bottom: 20px;">
        </center>
      
    <!--<a href="{{ url('/') }}" class="brand-link">-->
    <!--  <img src="{{ asset('public/images/logo.png') }}" alt="AdminLTE Logo" class="brand-image"-->
    <!--       style="opacity: .8">-->
      <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
       <?php 
        $login_user = '';
         ?>
        @guest
              <?php
                  
              ?>
            @if (Route::has('register'))
            <?php

              ?>
                
            @endif
            @else
            <?php 
              $login_user = '<div class="user-panel mt-3 pb-3 mb-3 d-flex">
                              <div class="info" style="margin-left: 15px;font-size: 17px;">
                                <a href="#" class="d-block text-center"> <i class="nav-icon far fa-user"></i>
                                          '.Auth::user()->name.'
                                </a>
                              </div>
                            </div>';
            ?>

        @endguest
      <?php 
      echo $login_user;
       ?>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <?php
             if(!empty(Auth::user())){ ?>
            @if(Auth::user()->hasRole('admin'))
              <li class="nav-item ">
                <a href="{{ url('/home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{ url('/manage-home') }}" class="nav-link {{ (request()->is('manage-home*')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-home"></i>
                  <p>Manage Home</p>
                </a>
              </li>
               <li class="nav-item has-treeview {{ (request()->is('area')) ? 'menu-open' : '' }} {{ (request()->is('customer')) ? 'menu-open' : '' }} {{ (request()->is('customer-wishlist')) ? 'menu-open' : '' }} {{ (request()->is('role*')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (request()->is('area')) ? 'active' : '' }} {{ (request()->is('customer')) ? 'active' : '' }} {{ (request()->is('role*')) ? 'active' : '' }} {{ (request()->is('customer-wishlist')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                    Manage Customers
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/area') }}" class="nav-link {{ (request()->is('area')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Area</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/role') }}" class="nav-link {{ (request()->is('role')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Roles
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/customer') }}" class="nav-link {{ (request()->is('customer')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Customers</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/customer-wishlist') }}" class="nav-link {{ (request()->is('customer-wishlist')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Customer Wishlist</p>
                    </a>
                  </li>
                </ul>
              </li>
             <li class="nav-item has-treeview {{ (request()->is('tag*')) ? 'menu-open' : '' }} {{ (request()->is('products*')) ? 'menu-open' : '' }} {{ (request()->is('brand*')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (request()->is('tag*')) ? 'active' : '' }} {{ (request()->is('products*')) ? 'active' : '' }} {{ (request()->is('brand*')) ? 'active' : '' }} ">
                  <i class="nav-icon fas fa-shopping-cart"></i>
                  <p>
                    Manage Products
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/tag') }}" class="nav-link {{ (request()->is('tag*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Tags/Filters</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/brand') }}" class="nav-link {{ (request()->is('brand*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Brands</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/products') }}" class="nav-link {{ (request()->is('products')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Products</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/manage-sgp') }}" class="nav-link {{ (request()->is('manage-sgp')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Manage SGP</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/products-combo') }}" class="nav-link {{ (request()->is('products-combo')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Product Combo</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item has-treeview {{ (request()->is('distributer*')) ? 'menu-open' : '' }}  {{ (request()->is('purchase*')) ? 'menu-open' : '' }} {{ (request()->is('inventory*')) ? 'menu-open' : '' }} {{ (request()->is('return-stock*')) ? 'menu-open' : '' }} {{ (request()->is('stock-log*')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (request()->is('distributer*')) ? 'active' : '' }}  {{ (request()->is('inventory*')) ? 'active' : '' }} {{ (request()->is('purchase*')) ? 'active' : '' }} {{ (request()->is('return-stock*')) ? 'active' : '' }} {{ (request()->is('stock-log')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-truck-moving"></i>
                  <p>
                    Manage Stock
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                   
                  
                  <li class="nav-item">
                    <a href="{{ url('/distributer') }}" class="nav-link {{ (request()->is('distributer*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Distributer</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/purchase') }}" class="nav-link {{ (request()->is('purchase')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Purchases</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/inventory') }}" class="nav-link {{ (request()->is('inventory*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Inventory</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/return-stock') }}" class="nav-link {{ (request()->is('return-stock*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Return Stock</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/stock-log') }}" class="nav-link {{ (request()->is('stock-log*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Return Stock Log</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ (request()->is('payment-options*')) ? 'menu-open' : '' }} {{ (request()->is('customer-orders*')) ? 'menu-open' : '' }} {{ (request()->is('refund*')) ? 'menu-open' : '' }} {{ (request()->is('voucher')) ? 'menu-open' : '' }} ">
                <a href="#" class="nav-link {{ (request()->is('payment-options*')) ? 'active' : '' }} {{ (request()->is('customer-orders*')) ? 'active' : '' }} {{ (request()->is('refund*')) ? 'active' : '' }} {{ (request()->is('voucher')) ? 'active' : '' }} ">
                  <i class="nav-icon fas fa-shopping-cart"></i>
                  <p>
                    Orders
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/voucher') }}" class="nav-link {{ (request()->is('voucher*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Voucher</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/payment-options') }}" class="nav-link {{ (request()->is('payment-options*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Payment Options</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/customer-orders') }}" class="nav-link {{ (request()->is('customer-orders*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Customer Orders</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/refund') }}" class="nav-link {{ (request()->is('refund*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Refunds</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ (request()->is('order_search*')) ? 'menu-open' : '' }} {{ (request()->is('sales*')) ? 'menu-open' : '' }} {{ (request()->is('distributor-report*')) ? 'menu-open' : '' }} ">
                <a href="#" class="nav-link {{ (request()->is('order_search*')) ? 'active' : '' }} {{ (request()->is('sales*')) ? 'active' : '' }} {{ (request()->is('distributor-report*')) ? 'active' : '' }} ">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Reports
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/sales') }}" class="nav-link {{ (request()->is('sales')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Sales</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/sales-brand') }}" class="nav-link {{ (request()->is('sales-brand')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Brand Revenue</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/sales-product') }}" class="nav-link {{ (request()->is('sales-product')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Product Revenue</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/sales-customer') }}" class="nav-link {{ (request()->is('sales-customer')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Customer Revenue</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/sales-building') }}" class="nav-link {{ (request()->is('sales-building')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Building Revenue</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/sales-product-price') }}" class="nav-link {{ (request()->is('sales-product-price')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Product Price Compare</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/distributor-report') }}" class="nav-link {{ (request()->is('distributor-report*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Distributor Report</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/stock-in-worth') }}" class="nav-link {{ (request()->is('stock-in-worth*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Stock-In Worth</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/sales-discount') }}" class="nav-link {{ (request()->is('sales-discount*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>DisCount %</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/order_search') }}" class="nav-link {{ (request()->is('order_search*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Order Search</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ (request()->is('promotions*')) ? 'menu-open' : '' }} {{ (request()->is('online-pdf*')) ? 'menu-open' : '' }} {{ (request()->is('sms*')) ? 'menu-open' : '' }}  ">
                <a href="#" class="nav-link {{ (request()->is('promotions*')) ? 'active' : '' }} {{ (request()->is('online-pdf*')) ? 'active' : '' }} {{ (request()->is('sms*')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-phone"></i>
                  <p>
                    Communications
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/sms') }}" class="nav-link {{ (request()->is('sms*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>SMS</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{ url('/promotions') }}" class="nav-link {{ (request()->is('promotions*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Promotions</p>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="{{ url('/online-pdf') }}" class="nav-link {{ (request()->is('online-pdf*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Online Pdf</p>
                    </a>
                  </li>
                </ul>
              </li>


              
            
            @endif
              
            @if(Auth::user()->hasRole('customer'))
              <li class="nav-item">
                <a href="{{ url('/home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-home"></i>
                  <p>Home</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/my-order') }}" class="nav-link {{ (request()->is('my-order*')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>My Orders</p>
                </a>
              </li>
              <?php if(isset($brand_list)){ ?>
                <li class="nav-item has-treeview {{ (request()->is('brand*')) ? 'menu-open' : '' }} ">
                <a href="#" class="nav-link {{ (request()->is('brand*')) ? 'active' : '' }} ">
                  <i class="nav-icon fas fa-bullseye"></i>
                  <p>
                    Brands
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @foreach($brand_list as $key => $brand)
                  <li class="nav-item">
                    <a href="{{ url('/brand/') }}/{{ $brand->name }}" class="nav-link {{ (request()->is('brand/'.$brand->name)) ? 'active' : '' }}">
                      <i class="fas fa-angle-right nav-icon"></i>
                      <p>{{ str_replace("_", " ", $brand->name) }}</p>
                    </a>
                  </li>
                  @endforeach
                </ul>
              </li>
              <?php } ?>
              <?php if(isset($tag_list)){ ?>
                <li class="nav-item has-treeview {{ (request()->is('category*')) ? 'menu-open' : '' }} ">
                <a href="#" class="nav-link {{ (request()->is('category*')) ? 'active' : '' }} ">
                  <i class="nav-icon fas fa-tag"></i>
                  <p>
                    Category
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @foreach($tag_list as $key => $tag)
                  <li class="nav-item">
                    <a href="{{ url('/category/') }}/{{ $tag }}" class="nav-link {{ (request()->is('category/'.$tag)) ? 'active' : '' }}">
                      <i class="fas fa-angle-right nav-icon"></i>
                      <p>{{ str_replace("_", " ", $tag) }}</p>
                    </a>
                  </li>
                  @endforeach
                </ul>
              </li>
              
              <?php } ?>
              <li class="nav-item">
                  <a href="{{ url('/combo_offer') }}" class="nav-link {{ (request()->is('combo_offer*')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-gift"></i>
                    <p>
                     Combo Offer
                    </p>
                  </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/wishlist') }}" class="nav-link {{ (request()->is('wishlist')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-heart"></i>
                  <p>
                    Wishlist
                  </p>
                </a>
              </li>
            @endif
              
          <?php }
           ?>
           @guest
                <!-- <li class="nav-item">
                  <a href="{{ route('login') }}" class="nav-link {{ (request()->is('login*')) ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                     Admin Login
                    </p>
                  </a>
                </li> -->
                
                <li class="nav-item">
                  <a href="{{ url('/') }}" class="nav-link {{ (request()->is()) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                      Home
                    </p>
                  </a>
                </li>
                <?php if(isset($brand_list)){ ?>
                <li class="nav-item has-treeview {{ (request()->is('brand*')) ? 'menu-open' : '' }} ">
                <a href="#" class="nav-link {{ (request()->is('brand*')) ? 'active' : '' }} ">
                  <i class="nav-icon fas fa-bullseye"></i>
                  <p>
                    Brands
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @foreach($brand_list as $key => $brand)
                  <li class="nav-item">
                    <a href="{{ url('/brand/') }}/{{ $brand->name }}" class="nav-link {{ (request()->is('brand/'.$brand->name)) ? 'active' : '' }}">
                      <i class="fas fa-angle-right nav-icon"></i>
                      <p>{{ str_replace("_", " ", $brand->name) }}</p>
                    </a>
                  </li>
                  @endforeach
                </ul>
              </li>
              <?php } ?>
              <?php if(isset($tag_list)){ ?>
                <li class="nav-item has-treeview {{ (request()->is('category*')) ? 'menu-open' : '' }} ">
                <a href="#" class="nav-link {{ (request()->is('category*')) ? 'active' : '' }} ">
                  <i class="nav-icon fas fa-tag"></i>
                  <p>
                    Category
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @foreach($tag_list as $key => $tag)
                  <li class="nav-item">
                    <a href="{{ url('/category/') }}/{{ $tag }}" class="nav-link {{ (request()->is('category/'.$tag)) ? 'active' : '' }}">
                      <i class="fas fa-angle-right nav-icon"></i>
                      <p>{{ str_replace("_", " ", $tag) }}</p>
                    </a>
                  </li>
                  @endforeach
                </ul>
              </li>
              <?php } ?>
                <li class="nav-item">
                  <a href="{{ url('/combo_offer') }}" class="nav-link {{ (request()->is('combo_offer*')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-gift"></i>
                    <p>
                     Combo Offer
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('/customer-login') }}" class="nav-link {{ (request()->is('customer-login*')) ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      Login
                    </p>
                  </a>
                </li>
                @if (Route::has('register'))
                <!-- <li class="nav-item">
                  <a href="{{ route('register') }}" class="nav-link {{ (request()->is('register*')) ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      Register
                    </p>
                  </a>
                </li> -->
                @endif

                @else
                @if(Auth::user()->hasRole('admin'))
                <li class="nav-item">
                  <a href="{{ url('change-password') }}" class="nav-link {{ (request()->is('change-password*')) ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      Change Password
                    </p>
                  </a>
                </li>
                @endif

                <li class="nav-item">
                <a class="nav-link {{ (request()->is('logout*')) ? 'active' : '' }}" href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      {{ __('Logout') }}
                    </p>
                 </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
              @endguest
              <!--<li class="nav-item">-->
              <!--  <a href="{{ url('/contact-us') }}" class="nav-link {{ (request()->is('contact-us*')) ? 'active' : '' }}">-->
              <!--    <i class="nav-icon fas fa-phone"></i>-->
              <!--    <p>-->
              <!--      Contact Us-->
              <!--    </p>-->
              <!--  </a>-->
              <!--</li>-->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    
  </aside>