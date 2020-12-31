@extends('frontend.layout.main')
@section('title','Campaign')
@section('slider')

  <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center" style="background-image: url({{ asset('public/frontend/img/banner/fundraising.png') }});">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Campaign</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('content')
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
                                
                                <h4>For Individual</h4>
                                <p>My Saathe helps empower your creative, entrepreneurial,and passion projects.</p>
                                 <h6 style="font-weight: bold;visibility: hidden;">Start from 3% platform fee ?</h6>
                            </div>
                        </div>
                        <div class="single_cause">
                            <div class="thumb">
                                <img src="{{ asset('public/frontend/img/home/charity.png') }}" alt="">
                            </div>
                            <div class="causes_content">
                               
                                <h4>For Social cause<br/><span style="font-size: 12px;">NGO , Charity , Non-profit</span></h4>
                                
                                <p>Fundraising, powered by My Saathe, offers fundraising for personal and nonprofit causes.</p>
                            </div>
                        </div>
                        <div class="single_cause">
                            <div class="thumb">
                                <img src="{{ asset('public/frontend/img/home/volunteers.png') }}" alt="">
                            </div>
                            <div class="causes_content">
                               
                                <h4>Volunteer A Campaign</h4>
                                <p>My Saathe helps campaigners with their supporters to make support campaign or volunteer a their campaign to support their achievements</p>
                                    
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- cd-timeline -->

  @endsection