<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed;">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="">
        <center>
            <img src="{{ asset('public/frontend/img/new-logo.png') }}" alt="sgLogo" class=""
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
                                          '.Auth::user()->username.'
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
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" >
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item ">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
            <?php
            if(!empty(Auth::user())){ ?>
            @if(Auth::user()->hasRole('admin'))
             <li class="nav-item has-treeview {{ (request()->is('account-setting*')) ? 'menu-open' : '' }} {{ (request()->is('edit-profile*')) ? 'menu-open' : '' }}  {{ (request()->is('view-profile*')) ? 'menu-open' : '' }} {{ (request()->is('change-password*')) ? 'menu-open' : '' }}  {{ (request()->is('change-mobile-or-email*')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (request()->is('account-setting*')) ? 'active' : '' }} {{ (request()->is('edit-profile*')) ? 'active' : '' }} {{ (request()->is('view-profile*')) ? 'active' : '' }} {{ (request()->is('change-password*')) ? 'active' : '' }}  {{ (request()->is('change-mobile-or-email*')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                    Account Settings
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/edit-profile') }}" class="nav-link {{ (request()->is('edit-profile*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Edit Your Profile</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/view-profile') }}" class="nav-link {{ (request()->is('view-profile*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>View Profile</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/change-mobile-or-email') }}" class="nav-link {{ (request()->is('change-mobile-or-email*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Change Password</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/campaigns') }}" class="nav-link {{ (request()->is('campaigns*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Change Email/Mobile No.</p>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="{{ url('/campaigns') }}" class="nav-link {{ (request()->is('campaigns*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Change Security PIN</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/campaigns') }}" class="nav-link {{ (request()->is('campaigns*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Assignment Settings</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/campaigns') }}" class="nav-link {{ (request()->is('campaigns*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Verify Your Identity/KYC</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ (request()->is('campaign-category*')) ? 'menu-open' : '' }} {{ (request()->is('campaigns*')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ (request()->is('campaign-category*')) ? 'active' : '' }} {{ (request()->is('campaigns*')) ? 'active' : '' }}">
                  <i class="nav-icon fas fa-heart"></i>
                  <p>
                    Campaign
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/campaign-category') }}" class="nav-link {{ (request()->is('campaign-category*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Category</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/campaigns') }}" class="nav-link {{ (request()->is('campaigns*')) ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Campaign Fundraising</p>
                    </a>
                  </li>
                </ul>
              </li>
             
            @endif
              
          <?php }
           ?>
           @guest
             
           @endguest
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
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    
  </aside>