@extends('frontend.layout.main')
@section('title','Report')
@section('slider')
    <div class="bradcam_area breadcam_bg overlay d-flex align-items-center justify-content-center" style="background-image: url(img/banner/policy.png);">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>REPORT ABUSE</h3>
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
            <!-- <img src="img/reportabusebutton.png"> -->
        
            <center><h2>REPORT ABUSE</h2>
            <div class="line"></div>
             <p>Mysaathe is not a place for abuse, hatred, discrimination, disrespect, harassment, or spam. We are extremely thankful to you for reporting abusive content on our website. Please fill in the form below.</p></center>
        </div>
    </div>
    <br/><br/>
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <hr/><br/><br/>
             <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                            <div class="row">
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="Enter First name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Enter Last name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control valid" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="Enter Fundraiser URL">
                                    </div>
                                </div>
                                
                                <!-- <div class="col-12">
                                    <div class="form-group">
                                        <input class="form-control" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder="Enter Subject">
                                    </div>
                                </div> -->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Content Description'" placeholder=" Enter Content Description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="button button-contactForm boxed-btn">Send</button>
                            </div>
                        </form>
        </div>
    </div>
    </div>
 @endsection