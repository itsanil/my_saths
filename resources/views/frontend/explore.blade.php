@extends('frontend.layout.main')
@section('title','Explore')
@section('slider')

    <!-- header-end -->

    <!-- bradcam_area_start  -->
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Explore Campaign</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('content')
   <div class="container" id="c">
    
     <div class="c1">
        <p>Showing fundraisers for </p>
        <div class="input-group-icon mt-10 campa" style="width: 20%; ">
                                <!-- <div class="icon"><i class="fa fa-plane" aria-hidden="true"></i></div> -->
                                <div class="form-select" id="default-select" >
                                            <select >
                                                <option  value=" 1">All Categories</option>
                                    <option value="1" role="presentation" gallery-filter="houses">Education</option>
                                    <option value="1" role="presentation" gallery-filter="people">Medical</option>
                                    <option value="1">Women & Girls</option>
                                    <option value="1">Animal</option>
                                    <option value="1">Creative</option>
                                    </select>
                                </div>
                            </div>
    
     </div>

     <div class="c1">
        <p>Under  </p>
        <div class="input-group-icon mt-10 campa" style="width: 20%;">
                                <!-- <div class="icon"><i class="fa fa-plane" aria-hidden="true"></i></div> -->
                                <div class="form-select" id="default-select"">
                                            <select>
                                                <option value=" 1">Trending</option>
                                    <option value="1">Tax Benefit</option>
                                    <option value="1">Trending</option>
                                    <option value="1">Urgently Funds Required</option>
                                    <option value="1">Successfully Funded</option>
                                    </select>
                                </div>
                            </div>
     </div>


     <div class="c1">
        <p>From  </p>
        <div class="input-group-icon mt-10 campa" style="width: 20%;">
                                <!-- <div class="icon"><i class="fa fa-location" aria-hidden="true"></i></div> -->
                                <div class="form-select" id="default-select"">
                                            <select>
                                                <option value=" 1">Locations</option>
                                    <option value="1">Mumbai</option>
                                    <option value="1">Bengaluru</option>
                                    <option value="1">New Delhi</option>
                                    <option value="1">Hyderabad</option>
                                    <option value="1">Chennai</option>
                                    </select>
                                </div>
                            </div>
     </div>
     

 </div>


    <div class="container">
        <div  id="campaign">
    <div class="row">
        <div class="col-lg-4">
            <div class="image">
                <img src="{{ asset('public/frontend/img/crowdfunding.png') }}">
            </div>
            <div class="content">
                <h4>Campaign Name</h4>
                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.</p>
                <div class="donors">
                 <div class="image">
                    <center><img src="{{ asset('public/frontend/img/crowdfunding.png') }}"></center>
                 </div>
                 <div class="content">
                    <p> By Child Help Foundation</p>
                 </div>
                </div>
                <div class="fund1">
                <h4><i class="fa fa-rupee"></i> 50,000 <span>raised</span></h4>
                </div>
                <div class="fund2">
                    <div class="days1">
                    <p> 38 Days Lefts</p>
                    </div>
                    <div class="supporters">
                    <p>3508 Supporters</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="image">
                <img src="{{ asset('public/frontend/img/crowdfunding.png') }}">
            </div>
            <div class="content">
                <h4>Campaign Name</h4>
                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.</p>
                <div class="donors">
                 <div class="image">
                    <center><img src="{{ asset('public/frontend/img/crowdfunding.png') }}"></center>
                 </div>
                 <div class="content">
                    <p> By Child Help Foundation</p>
                 </div>
                </div>
                <div class="fund1">
                <h4><i class="fa fa-rupee"></i> 50,000 <span>raised</span></h4>
                </div>
                <div class="fund2">
                    <div class="days1">
                    <p> 38 Days Lefts</p>
                    </div>
                    <div class="supporters">
                    <p>3508 Supporters</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="image">
                <img src="{{ asset('public/frontend/img/crowdfunding.png') }}">
            </div>
            <div class="content">
                <h4>Campaign Name</h4>
                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.</p>
                <div class="donors">
                 <div class="image">
                    <center><img src="{{ asset('public/frontend/img/crowdfunding.png') }}"></center>
                 </div>
                 <div class="content">
                    <p> By Child Help Foundation</p>
                 </div>
                </div>
                <div class="fund1">
                <h4><i class="fa fa-rupee"></i> 50,000 <span>raised</span></h4>
                </div>
                <div class="fund2">
                    <div class="days1">
                    <p> 38 Days Lefts</p>
                    </div>
                    <div class="supporters">
                    <p>3508 Supporters</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
<br/>


    <div class="row">
        <div class="col-lg-4">
            <div class="image">
                <img src="{{ asset('public/frontend/img/crowdfunding.png') }}">
            </div>
            <div class="content">
                <h4>Campaign Name</h4>
                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.</p>
                <div class="donors">
                 <div class="image">
                    <center><img src="{{ asset('public/frontend/img/crowdfunding.png') }}"></center>
                 </div>
                 <div class="content">
                    <p> By Child Help Foundation</p>
                 </div>
                </div>
                <div class="fund1">
                <h4><i class="fa fa-rupee"></i> 50,000 <span>raised</span></h4>
                </div>
                <div class="fund2">
                    <div class="days1">
                    <p> 38 Days Lefts</p>
                    </div>
                    <div class="supporters">
                    <p>3508 Supporters</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="image">
                <img src="{{ asset('public/frontend/img/crowdfunding.png') }}">
            </div>
            <div class="content">
                <h4>Campaign Name</h4>
                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.</p>
                <div class="donors">
                 <div class="image">
                    <center><img src="{{ asset('public/frontend/img/crowdfunding.png') }}"></center>
                 </div>
                 <div class="content">
                    <p> By Child Help Foundation</p>
                 </div>
                </div>
                <div class="fund1">
                <h4><i class="fa fa-rupee"></i> 50,000 <span>raised</span></h4>
                </div>
                <div class="fund2">
                    <div class="days1">
                    <p> 38 Days Lefts</p>
                    </div>
                    <div class="supporters">
                    <p>3508 Supporters</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="image">
                <img src="{{ asset('public/frontend/img/crowdfunding.png') }}">
            </div>
            <div class="content">
                <h4>Campaign Name</h4>
                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.</p>
                <div class="donors">
                 <div class="image">
                    <center><img src="{{ asset('public/frontend/img/crowdfunding.png') }}"></center>
                 </div>
                 <div class="content">
                    <p> By Child Help Foundation</p>
                 </div>
                </div>
                <div class="fund1">
                <h4><i class="fa fa-rupee"></i> 50,000 <span>raised</span></h4>
                </div>
                <div class="fund2">
                    <div class="days1">
                    <p> 38 Days Lefts</p>
                    </div>
                    <div class="supporters">
                    <p>3508 Supporters</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
<br/>


    <div class="row">
        <div class="col-lg-4">
            <div class="image">
                <img src="{{ asset('public/frontend/img/crowdfunding.png') }}">
            </div>
            <div class="content">
                <h4>Campaign Name</h4>
                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.</p>
                <div class="donors">
                 <div class="image">
                    <center><img src="{{ asset('public/frontend/img/crowdfunding.png') }}"></center>
                 </div>
                 <div class="content">
                    <p> By Child Help Foundation</p>
                 </div>
                </div>
                <div class="fund1">
                <h4><i class="fa fa-rupee"></i> 50,000 <span>raised</span></h4>
                </div>
                <div class="fund2">
                    <div class="days1">
                    <p> 38 Days Lefts</p>
                    </div>
                    <div class="supporters">
                    <p>3508 Supporters</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="image">
                <img src="{{ asset('public/frontend/img/crowdfunding.png') }}">
            </div>
            <div class="content">
                <h4>Campaign Name</h4>
                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.</p>
                <div class="donors">
                 <div class="image">
                    <center><img src="{{ asset('public/frontend/img/crowdfunding.png') }}"></center>
                 </div>
                 <div class="content">
                    <p> By Child Help Foundation</p>
                 </div>
                </div>
                <div class="fund1">
                <h4><i class="fa fa-rupee"></i> 50,000 <span>raised</span></h4>
                </div>
                <div class="fund2">
                    <div class="days1">
                    <p> 38 Days Lefts</p>
                    </div>
                    <div class="supporters">
                    <p>3508 Supporters</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="image">
                <img src="{{ asset('public/frontend/img/crowdfunding.png') }}">
            </div>
            <div class="content">
                <h4>Campaign Name</h4>
                <p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print.</p>
                <div class="donors">
                 <div class="image">
                    <center><img src="{{ asset('public/frontend/img/crowdfunding.png') }}"></center>
                 </div>
                 <div class="content">
                    <p> By Child Help Foundation</p>
                 </div>
                </div>
                <div class="fund1">
                <h4><i class="fa fa-rupee"></i> 50,000 <span>raised</span></h4>
                </div>
                <div class="fund2">
                    <div class="days1">
                    <p> 38 Days Lefts</p>
                    </div>
                    <div class="supporters">
                    <p>3508 Supporters</p>
                    </div>
                </div>
            </div>

        </div>
    </div>


    </div>
</div>


  @endsection


    

    <!-- footer_start  -->
   