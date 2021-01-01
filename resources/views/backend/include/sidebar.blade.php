<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
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
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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