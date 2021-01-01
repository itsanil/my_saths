@extends('frontend.layout.main')
@section('title','Pricing')
@section('slider')
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center" style="background-image: url(img/banner/plans.png);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Pricing</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
     @endsection
     @section('content')
    
    <div class="container" id="about">
    <div class="row">
        <div class="col-lg-12">
            
        
            <h2>Pricing</h2>
             <p class="para_1">We charge a fee from the money you raise, which means we get paid only when you succeed. Its a win-win situation.</p>
                   
                   <hr/>
                   <br/><br/>    
                   <p>Mysaathe will deduct a fee from each donation that you receive. Since our fee is deducted automatically, you'll never need to worry about being billed or owing us any money. </p>
        </div>
    </div>
    



<br/><br/>
<div class="container" id="fundraising-ideas">
<div class="row">
    <div class="col-lg-4">
        <div class="content">
            <center><img src="{{ asset('public/frontend/img/gallery/capture1.png') }}"></center>
            <center><h2>SELF-DRIVEN</h2>
            <div class="line"></div>
            <p>Fundraise by yourself</p>
            <h3 style="color: #5c5c5c;">0%</h3>
            <p>+ 3% Payment Gateway Fees</p>
            <p>Start Your Fundraiser</p></center><br/><br/>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content">
            <center><img src="{{ asset('public/frontend/img/gallery/capture1.png') }}"></center>
            <center><h2>COLLABORATE</h2>
            <div class="line"></div>
            <p>We strategize, you execute</p>
            <h3 style="color: #5c5c5c;">3%</h3>
            <p>+ 3% Payment Gateway Fees</p>
            <p>Get In Touch</p></center><br/><br/>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content">
            <center><img src="{{ asset('public/frontend/img/gallery/capture2.png') }}"></center>
            <center><h2>ACCELERATE</h2>
            <div class="line"></div>
            <p>Boost your fundraising with our help</p>
            <h3 style="color: #5c5c5c;">10%</h3>
            <p>+ 3% Payment Gateway Fees</p>
            <p>+ Marketing Costs*</p>
            <p>Get In Touch</p></center><br/>
        </div>
    </div>
</div>
<br/>
<br/>
<ul class="policy">
    <li>*Taxes on fees applicable for certain countries</li>
<li>**Withdrawal charges applicable 5-10% depends on the mode of withdrawal.</li>
<li> ***Accelerated Fundraising eligible for the campaign owners who has donated an equal contribution and raised minimum 20 USD.</li>
<li>****Fees has to pay upfront for the people want to transact directly with the contributor.</li>
 <li>Mysaathe's seamless social media integration makes it so easy to showcase your fundraising cause on social networks, like Facebook, Google Plus and Twitter etc. You reach your friends' networks and networks of your donors. You cause gets maximum visibility and gets funded faster, that easily makes up for the fee.</li>
 <li>Be cautious of other crowdfunding sites that say they are "100% free" – they actually charge your donors instead without you knowing it! Mysaathe will never charge your donors for their generosity.</li>
</ul>


</div>



    </div>
 @endsection