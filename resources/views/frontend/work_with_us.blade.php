@extends('frontend.layout.main')
@section('title','Work With Us')
@section('slider')
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center" style="background-image: url(public/frontend/img/banner/workwithus.png);">

        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>Work With Us</h3>
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
            <img src="{{ asset('public/frontend/img/work-with-us.jpeg') }}" style="margin-right: 100px;">
        
            <h2>Work With Us</h2>
             <p class="para_1">Technological Innovations are indeed important for economic growth and enhancement of
human possibilities - Leon Kass</p>
  <p>A business without innovation is no business at all and we say this because for every business
that is successful there are thousands, doing the same repeated things but end up being
unsuccessful. Baring the new innovations, businesses would not grow the way they have

grown in last 10 years.
                        </p>
                        <br/>
                        <ul class="policy">
<li>We have awesome perks &amp; benefits, beyond just feeling great about your work.</li>
<li>We meet many talented &amp; interesting individuals who are trying to shape the world and do
something different. Gender, race, origin, age, culture, education do not matter to us. We
believe in making a difference and impacting lives.</li>
<li>We have openings in marketing, business development, technology.</li>
                        </ul>
                        <br/>
                        <h4>Ready to work with us?</h4>

                        <p>To apply please send your resume to: <a href="mailto:mysaathe@gmail.com?Subject=Hello%20again" target="_top">mysaathe@gmail.com</a></p>
        </div>
         <div class="col-lg-12">
         </div>


         

  
    </div>
    </div>



  @endsection