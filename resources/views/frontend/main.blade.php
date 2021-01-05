@extends('frontend.layout.main')
@section('title','Crowd Funding')
@section('slider')
    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="single_slider  d-flex align-items-center"> <!-- overlay2 -->
            <div class="owl-carousel1 owl-theme">
        <div class="item">
            <img src="{{ asset('public/frontend/img/banner/banner.png') }}" alt="images not found">
            <div class="cover">
                <div class="container">
                    <div class="header-content">
                        <div class="line"></div>
                        <h2>Crowd Funding for Every problem Solution</h2>
                        <h1>Crowd Funding</h1>
                        <h4>Crowdfunding is a way for people, businesses and charities to raise money for their purpose.</h4>
                        <a href="{{ url('/login') }}" class="boxed-btn4">Sign In</a><a href="{{ url('/register') }}" class="boxed-btn4">Sign Up</a>
                    </div>
                </div>
             </div>
        </div>                    
        <div class="item">
            <img src="{{ asset('public/frontend/img/banner/banner1.png') }}" alt="images not found">
            <div class="cover">
                <div class="container">
                    <div class="header-content">
                        <div class="line animated bounceInLeft"></div>
                        <h2>Crowd Funding for Every problem Solution</h2>
                        <h1>Crowd Funding</h1>
                        <h4>Crowdfunding is a way for people, businesses and charities to raise money for their purpose.</h4>
                        <a href="{{ url('/login') }}" class="boxed-btn4">Sign In</a><a href="{{ url('/register') }}" class="boxed-btn4">Sign Up</a>
                    </div>
                </div>
             </div>
        </div>                
        <div class="item">
            <img src="{{ asset('public/frontend/img/banner/banner3.jpg') }}" alt="images not found">
            <div class="cover">
                <div class="container">
                    <div class="header-content">
                        <div class="line animated bounceInLeft"></div>
                        <h2>Crowd Funding for Every problem Solution</h2>
                        <h1>Crowd Funding</h1>
                        <h4>Crowdfunding is a way for people, businesses and charities to raise money for their purpose.</h4>
                        <a href="#" class="boxed-btn4">Sign In</a><a href="#" class="boxed-btn4">Sign Up</a>
                    </div>
                </div>
             </div>
        </div>
    </div>
        </div>
    </div>

@endsection
@section('content') 
<div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <h2> <center>First 0% platform fee !!</center> </h2>
            <center> <h4>Start a fundraiser for free and get maximum funds for the cause you care about</h4> </center>
            <input style="outline: none;" type="text" class="form-control mt-3"  placeholder="First name">
            <input type="number" class="form-control mt-3" style="border: 0;" placeholder="Phone">
            <input type="email" class="form-control mt-3" placeholder="Email">
            <input type="text" class="form-control mt-3" placeholder="Your City">
            <center>    <a href="#" class="boxed-btn4 mt-3">Get a Fundraiser</a></center>  
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>



<div id="ex1" class="modal" style="background-color:#9de3c7 ;">
    <h2> <center>First 0% platform fee !!</center> </h2>
    <center> <h4>Start a fundraiser for free and get maximum funds for the cause you care about</h4> </center>
    <input style="outline: none;" type="text" class="form-control mt-3"  placeholder="First name">
    <input type="number" class="form-control mt-3" style="border: 0;" placeholder="Phone">
    <input type="email" class="form-control mt-3" placeholder="Email">
    <input type="text" class="form-control mt-3" placeholder="Your City">
    <center>    <a href="#" class="boxed-btn4 mt-3">Get a Fundraiser</a></center>  
  
</div>
  <!--modal-->




      <!-- counter_area_start  -->
    <div class="counter_area">
        <div class="container-fluid">
            <div class="counter_bg overlay">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="flaticon-calendar"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">1,180</h3>
                                <p>TOTAL JOINING</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="flaticon-heart-beat"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">373</h3>
                                <p>TOTAL FUND RAISED</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="flaticon-in-love"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">1</h3>
                                <p>TOTAL DONORS</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="flaticon-hug"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">1</h3>
                                <p>TOTAL ACTIVE CAMPAIGN</p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 col-md-6">
                        <div class="single_counter d-flex align-items-center justify-content-center">
                            <div class="icon">
                                <i class="flaticon-hug"></i>
                            </div>
                            <div class="events">
                                <h3 class="counter">120</h3>
                                <p>Finished Event</p>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- counter_area_end  -->




    <!-- reson_area_start  -->
    
   <div class="reson_area section_padding">
       <div class="container-fluid">
        <div class="row justify-content-center" id="fund">
            <div class="col-lg-12 ">
                <div class="section_title text-center mb-55">
                    <h3><span>START YOUR FREE ONLINE FUNDRAISER</span></h3>
                    <p>Raise money for a variety of humanitarian causes. Choose the one that is most important to you.</p>
                </div>
            </div>
        </div>
        <center><h3><span style="font-family: Yeseva One", cursive;">CAMPAIGN CATEGORY</span></h3><div class="line"></div></center><br/>
    <div class="row">
        <div class="owl-carousel owl-theme">
            @foreach ($category as $key => $value)
            @if($key < 18)
            <div class="item" onclick="campaignpage('{{ $value->id }}');"> 
                <div class="home-content">
                <img src="{{ url('storage/') }}/{{ $value->photo }}" alt="{{ $value->title }}" style="height: 150px" >
                <div class="content">
                    <h4>{{ $value->title }}</h4>
                </div>
                 <!-- <center><i class="fas fa-hippo"></i>
                    <h4>Animals</h4></center> -->
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="owl-carousel owl-theme">
            @foreach ($category as $key => $value)
            @if($key >= 18)
            <div class="item" onclick="campaignpage('{{ $value->id }}');"> 
                <div class="home-content">
                <img src="{{ url('storage/') }}/{{ $value->photo }}" alt="{{ $value->title }}" style="height: 150px" >
                <div class="content">
                    <h4>{{ $value->title }}</h4>
                </div>
                 <!-- <center><i class="fas fa-hippo"></i>
                    <h4>Animals</h4></center> -->
                </div>
            </div>
            @endif
            @endforeach

        </div>
    </div>
       </div>
   </div>
      


    <!-- popular_causes_area_start  -->
    <div class="popular_causes_area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>I'M RAISING FUNDS FOR...</span></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="causes_active owl-carousel">
                        <div class="single_cause">
                            <div class="thumb">
                                <img src="{{ asset('public/frontend/img/home/individual.png') }}" alt="">
                            </div>
                            <div class="causes_content">
                                <!-- <div class="custom_progress_bar">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                            <span class="progres_count">
                                                30%
                                            </span>
                                        </div>
                                      </div>
                                </div> -->
                                <!-- <div class="balance d-flex justify-content-between align-items-center">
                                    <span>Raised: $5000.00 </span>
                                    <span>Goal: $9000.00 </span>
                                </div> -->
                                <h4>For Individual</h4>
                                <p>My Saathe helps empower your creative, entrepreneurial,and passion projects.</p>
                                 <h6 style="font-weight: bold;visibility: hidden;">start start star Start from 3% platform fee ?</h6>
                                <!-- <a class="read_more" href="cause_details.html">Read More</a> -->
                            </div>
                        </div>
                        <div class="single_cause">
                            <div class="thumb">
                                <img src="{{ asset('public/frontend/img/home/charity.png') }}" alt="">
                            </div>
                            <div class="causes_content">
                                <!-- <div class="custom_progress_bar">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                            <span class="progres_count">
                                                30%
                                            </span>
                                        </div>
                                      </div>
                                </div>
                                <div class="balance d-flex justify-content-between align-items-center">
                                    <span>Raised: $5000.00 </span>
                                    <span>Goal: $9000.00 </span>
                                </div> -->
                                <h4>For Social cause<br/><span style="font-size: 12px;">NGO , Charity , Non-profit</span></h4>
                                
                                <p>Fundraising, powered by My Saathe, offers fundraising for personal and nonprofit causes.</p>
                                <!-- <h6 style="font-weight: bold;">Start from 0% platform fee?</h6> -->
                                <!-- <a class="read_more" href="cause_details.html">Read More</a> -->
                            </div>
                        </div>
                        <div class="single_cause">
                            <div class="thumb">
                                <img src="{{ asset('public/frontend/img/home/volunteers.png') }}" alt="">
                            </div>
                            <div class="causes_content">
                                <!-- <div class="custom_progress_bar">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                            <span class="progres_count">
                                                30%
                                            </span>
                                        </div>
                                      </div>
                                </div>
                                <div class="balance d-flex justify-content-between align-items-center">
                                    <span>Raised: $5000.00 </span>
                                    <span>Goal: $9000.00 </span>
                                </div> -->
                                <h4>Volunteer A Campaign</h4>
                                <p>My Saathe helps campaigners with their supporters to make support campaign or volunteer a their campaign to support their achievements</p>
                                    
                               <!--  <a class="read_more" href="cause_details.html">Read More</a> -->
                            </div>
                        </div>
                        <!-- <div class="single_cause">
                            <div class="thumb">
                                <img src="{{ asset('public/frontend/img/causes/1.png') }}" alt="">
                            </div>
                            <div class="causes_content">
                                <div class="custom_progress_bar">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                            <span class="progres_count">
                                                30%
                                            </span>
                                        </div>
                                      </div>
                                </div>
                                <div class="balance d-flex justify-content-between align-items-center">
                                    <span>Raised: $5000.00 </span>
                                    <span>Goal: $9000.00 </span>
                                </div>
                                <h4>Help us to Send Food</h4>
                                <p>The passage is attributed to an 
                                    unknown typesetter in the century 
                                    who is thought</p>
                                <a class="read_more" href="cause_details.html">Read More</a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- popular_causes_area_end  -->


     <!-- counter_area_start  -->
   
    <!-- counter_area_end  -->





   <div class="container">
        <div  id="campaign">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb-55">
                        <h3><span>TRENDING FUNDRAISERS</span></h3>
                    </div>
                </div>
            </div>
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

@section('js')

    <script type="text/javascript">
        $('.owl-carousel1').owlCarousel({
    loop:true,
    margin:10,
    dots:false,
    nav:true,
    mouseDrag:false,
    autoplay:true,
    animateOut: 'slideOutUp',
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }

});
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    dots:false,
    nav:false,
    autoplay:true,
    autoplayTimeout:1000,
    
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
});

function campaignpage(id){
    window.location.replace('campaign-list?id='+id);
}
    </script>

    @endsection