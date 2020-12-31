@extends('frontend.layout.main')
@section('title','How It Work')
@section('slider')

 <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center" style="background-image: url({{ asset('public/frontend/img/banner/how-it-work.png') }});">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>How It Work</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
<div class="container" id="about" style="margin-bottom: 50px;">
    <div class="row">
        <div class="col-lg-12">
            
        
             <center><h2>How It Work</h2>
           <p>Crowdfunding is a way for people, businesses and charities to raise money for their purpose. It works through individuals or organisations who invest in (or donate to) crowdfunding projects can return for a potential reward program also Donation is this way where no liabilities or risk involved, so make sure you know what you're doing. </p></center>
        </div>
    </div>
   </div> 


 <section class="cd-timeline js-cd-timeline">
    <div class="container max-width-lg cd-timeline__container">

      <div class="cd-timeline__block">
        <div class="cd-timeline__img cd-timeline__img--picture">
            <h2 style="color: #fff;">1</h2>
        </div> <!-- cd-timeline__img -->

        <div class="cd-timeline__content text-component">
            <img src="{{ asset('public/frontend/img/steps/Step-1.png') }}" alt="Picture" style="">
          <h2>Sign Up & Create An Campaign Instantly</h2>
          <p class="color-contrast-medium" style="color: #0A297A;font-weight: bold;">Sign-up & You can create a campaign Instant identify the purpose problems & goal of the campaign amount to be raised , target audience, attitude or behavior that you are trying to change, and intended outcome for your campaign goals.</p>

          <div class="flex justify-between items-center">
            <span class="cd-timeline__date">Step</span>
           <!--  <a href="#0" class="btn btn--subtle">Read more</a> -->
          </div>
        </div> <!-- cd-timeline__content -->
      </div> <!-- cd-timeline__block -->

      <div class="cd-timeline__block">
        <div class="cd-timeline__img cd-timeline__img--movie">
            <h2 style="color: #fff;">2</h2>
        </div> <!-- cd-timeline__img -->

        <div class="cd-timeline__content text-component">
            <img src="{{ asset('public/frontend/img/steps/Step-2.png') }}" alt="Picture" style="float: left; margin-right: 10px;">
          <h2>Share Your Campaign Online Digitally</h2>
          <p class="color-contrast-medium" style="color: #0A297A;font-weight: bold;">Share your own campaign to your Network ,Family Friends or Subscribers . Your first step is to share your promotion with the people who are most likely to take actions. digitally on facebook, whatsapp ,twitter linkedin or social media so on....</p>
          
          <div class="flex justify-between items-center">
            <span class="cd-timeline__date">Step</span>
           <!--  <a href="#0" class="btn btn--subtle">Read more</a> -->
          </div>
        </div> <!-- cd-timeline__content -->
      </div> <!-- cd-timeline__block -->

      <div class="cd-timeline__block">
        <div class="cd-timeline__img cd-timeline__img--picture">
            <h2 style="color: #fff;">3</h2>
        </div> <!-- cd-timeline__img -->

        <div class="cd-timeline__content text-component">
            <img src="{{ asset('public/frontend/img/steps/Step-3.png') }}" alt="Picture" style="float: left; margin-right: 10px;">
          <h2>Receive Donation From All Over  </h2>
          <p class="color-contrast-medium" style="color: #0A297A;font-weight: bold;">You can receive donation from all over the world in any currencies in your campaign 
</p>

          <div class="flex justify-between items-center">
            <span class="cd-timeline__date">Step</span>
            <!-- <a href="#0" class="btn btn--subtle">Read more</a> -->
          </div>
        </div> <!-- cd-timeline__content -->
      </div> <!-- cd-timeline__block -->

      <div class="cd-timeline__block">
        <div class="cd-timeline__img cd-timeline__img--location">
            <h2 style="color: #fff;">4</h2>
        </div> <!-- cd-timeline__img -->

        <div class="cd-timeline__content text-component">
            <img src="{{ asset('public/frontend/img/steps/Step-4.png') }}" alt="Picture" style="float: left; margin-right: 10px;">
          <h2>Transfer Your Funds To Your Bank Account </h2>
          <p class="color-contrast-medium" style="color: #0A297A;font-weight: bold;">Transfer your campaign funds that your had raised into your registered bank account.</p>

          <div class="flex justify-between items-center">
            <span class="cd-timeline__date">Step</span>
            <!-- <a href="#0" class="btn btn--subtle">Read more</a> -->
          </div>
        </div> <!-- cd-timeline__content -->
      </div> <!-- cd-timeline__block -->

     

      
    </div>
  </section> <!-- cd-timeline -->

  @endsection