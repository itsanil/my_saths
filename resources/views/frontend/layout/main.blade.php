<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/frontend/img/favicon.png') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('public/frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/owl.carousel.min1.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/style2.css') }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/css/style1.css') }}">
    @yield('css')
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <style>
          .goog-te-gadget-simple .goog-te-menu-value span {
    text-decoration: none;
    display:none !important;
}
.footer_hr{
    border: 1px solid white;
}
.form-rounded {
border-radius: 1rem;
}
#fixed_form{
border-radius: 25px;
background-color: cadetblue;
width: 100%;
height: auto;
}

.goog-te-gadget-simple .goog-te-menu-value {
    display:none !important;
}
@media (max-width:768px){
    .reson_area .home-content img {
    width: 100%;
    height: 200px;
    border-radius: 7px;
}
}
</style>
   
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->


    <!-- header-start -->
    <header>
        <div class="header-area ">
           
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            <div class="logo">
                                <a href="{{ url('/') }}">
                                    <!-- <h2>Crowd Funding</h2> -->
                                    
                                    <span><h4><img src="{{ asset('public/frontend/img/new-logo.png') }}" alt=""> MYSAATHE</h4></span>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9">
                            <div class="main-menu">
                                 <nav>
                                    <ul id="navigation">
                                        <li><a href="{{ url('/') }}">Home</a></li>
                                        <li><a href="{{ url('/how_it_work') }}">How It Works</a></li>
                                        <li><a href="{{ url('/campaign') }}">Browse Campaign</a></li>
                                        <li><a href="{{ url('/register') }}">Sign Up</a></li>
                                        <li class="book_btn"><!-- <div class="book_btn d-none d-lg-block" style="border: 1px solid #fff; border-radius: 5px;padding: 10px;"> -->
                                        <a href="#ex1" rel="modal:open"> <i class='fa fa-arrow-right'></i> Start A Fundraiser</a>

                                        <!-- </div> --></li>
                                        <li><a href="{{ url('/login') }}">Log In</a></li>
                                        <li><a href="{{ url('/about') }}">About</a></li>
                                        <li><div id="google_translate_element">
                                           
                                                            </div>
                                        </li>
                                        
                                    </ul>
                               
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->
<!--bottom form-->
<div class="counter_area">
<div class="fixed-bottom " style="margin: 10px;" >

    <div class="container-fluid " style="background-color:#9de3c7; border-radius: 25px;" >
       
        <div class="row justify-content-center pb-2 pt-2">
            <h4>START YOUR  FUNDRAISER RIGHT AWAY</h4>
        </div>
        <div class="row justify-content-center pb-3">
            <div class="col-sm-2 ">
                <input  class="form-control form-rounded" type="text" placeholder="Your name">
            </div>
            <div class="col-sm-2 pb-1">
                <input class="form-control form-rounded" type="text" name="" id="" placeholder="Your Amount">
            </div>
            <div class="col-sm-2 pb-1">
                <input class="form-control form-rounded" type="email" name="" id="" placeholder="Your Email">
            </div>
            <div class="col-sm-2 pb-1">
                <input class="form-control form-rounded" type="email" name="" id="" placeholder="Your Phone no.">
            </div>
            <div class="col-sm-2 pb-1">
              <a href="#">  <i class="fa fa-chevron-circle-right fa-2x" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</div>
</div>

<!--bottom form-->
@yield('slider')
    <!-- slider_area_start -->
    
  

@yield('content') 




    <!-- footer_start  -->
    <footer class="footer">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                   <!--  <div class="col-xl-1 col-md-6 col-lg-1 "></div> -->
                    <!-- <div class="col-xl-4 col-md-6 col-lg-4 ">
                        <div class="footer_widget">
                            <div class="footer_logo">
                                <a href="#">
                                    <img src="img/footer_logo.png" alt="">
                                </a>
                            </div>
                            <p class="address_text">Mysaathe is a digital based crowdfunding platform. which helps to bring together
individuals or any organisation to raise funds for their causes digitally.
                            </p>
                            <div class="socail_links">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i class="ti-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="ti-twitter-alt"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-dribbble"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div> -->
                    <div class="col-xl-2 col-md-6 col-lg-2">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Fundraising
                            </h3>
                            <ul class="links">
                                <li><a href="{{ url('/campaign') }}">Start Campaign</a></li>
                                <li><a href="{{ url('/explore') }}">Explore Campaign</a></li>
                                 <li><a href="{{ url('/real-estate-and-business-crowdfunding') }}">Real Estate &amp; Business</a></li>
                                <li><a href="{{ url('/fundresingcost') }}">Fundraising Cost</a></li>
                                <li><a href="{{ url('/fundraisingideas') }}">Fundraising Ideas</a></li>
                                <li><a href="{{ url('/terms') }}">Terms of Use</a></li>
                                <li><a href="{{ url('/policy_and_procedure') }}">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                     <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Useful Links
                            </h3>
                            <ul class="links">
                                <li><a href="{{ url('/what-is-crowdfunding') }}">What Is My Saathe</a></li>
                                <li><a href="{{ url('/work_with_us') }}">Work With Us</a></li>
                                <li><a href="{{ url('/partner_with_us') }}">Partner With Us</a></li>
                                <li><a href="{{ url('/pricing') }}">Plans &amp; Pricing</a></li>
                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Help Center
                            </h3>
                            <ul class="links">
                                <li><a href="{{ url('/how_it_work') }}">How It Work</a></li>
                                <li><a href="{{ url('/faq') }}">Common Questions</a></li>
                                <li><a href="{{ url('/guidelines') }}">Guidelines For Fundraisers</a></li>
                                <li><a href="{{ url('/report') }}">Report Abuse</a></li>
                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 col-lg-2">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Campaign
                            </h3>
                            <ul class="links">
                                <li><a href="{{ url('/promotion') }}">Promotion Rules</a></li>
                                <li><a href="{{ url('/projectrules') }}">Project Rules</a></li>
                                <li><a href="#">Campaign Articles</a></li>
                                
                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 col-lg-2">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Support
                            </h3>
                            <ul class="links">
                                <li><a href="{{ url('/trust_and_safety') }}">Trust &amp; Safety</a></li>
                                <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                                <li><a href="{{ url('/mediacontact') }}">Media Contact</a></li>
                                <li><a href="{{ asset('public/pdf/legal-document.pdf') }}" target="_blank">Legal Document</a></li>
                                
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Contacts
                            </h3>
                            <div class="contacts">
                                <p>+2(305) 587-3407 <br>
                                    info@loveuscharity.com <br>
                                    Flat 20, Reynolds Neck, North
                                    Helenaville, FV77 8WS
                                </p>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Top News
                            </h3>
                            <ul class="news_links">
                                <li>
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="img/news/news_1.png" alt="">
                                        </a>
                                    </div>
                                    <div class="info">
                                        <a href="#">
                                            <h4>School for African 
                                                Childrens</h4>
                                        </a>
                                        <span>Jun 12, 2019</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="thumb">
                                        <a href="#">
                                            <img src="img/news/news_2.png" alt="">
                                        </a>
                                    </div>
                                    <div class="info">
                                        <a href="#">
                                            <h4>School for African 
                                                Childrens</h4>
                                        </a>
                                        <span>Jun 12, 2019</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="copy-right_text">
            <div class="container">
                <div class="row">
                    <div class="bordered_1px "></div>
                    <div class="col-xl-12">
                        <p class="copy_right">
                            
  Copyright ©<script>document.write(new Date().getFullYear());</script>2020 All rights reserved | <a href="https://accunityservices.com" target="_blank">Accunity Services</a>
  
                        </p>
                        <div class="icons">
                            <a href="tel://+918291007286" target="_blank"><i class="fa fa-phone" aria-hidden="true"></i></a> 
  <a href="https://api.whatsapp.com/send?phone=+918291007286&amp;text=Hi, I contacted you Through your website." target="_blank" class="whatsapp"><i class="fab fa-whatsapp" aria-hidden="true"></i></a> 
  <a href="https://www.linkedin.com/in/mysaathe-in-6400131a9"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
  <a href="https://twitter.com/"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer_end  -->

    <!-- link that opens popup -->

    <!-- JS here -->
  
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="{{ asset('public/frontend/js/index.js') }}"></script> -->
    <script src="{{ asset('public/frontend/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/owl.carousel.min1.js') }}"></script>
    <script src="{{ asset('public/frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/ajax-form.js') }}"></script>
    <script src="{{ asset('public/frontend/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/scrollIt.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/nice-select.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('public/frontend/js/gijgo.min.js') }}"></script>
    <!--contact js-->
    <script src="{{ asset('public/frontend/js/contact.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.form.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/mail-script.js') }}"></script>
  
     <script src="{{ asset('public/frontend/js/main.js') }}"></script>
    
   
     @yield('js')

    <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



</body>

</html>