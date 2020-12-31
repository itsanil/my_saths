@extends('layouts1.main')
@section('title', 'Contact-us')
@section('section_page', 'Contact-us')
@section('css')
<style>
    .form-gradient .header {
    border-top-left-radius: .3rem;
    border-top-right-radius: .3rem;
}

.peach-gradient {
    background: linear-gradient(40deg,#ffd86f,#fc6262) !important;
}

.white-text{
    color:#ffff;
}
    
  </style>
@endsection

@section('content')
<div class="row">
       <div class="card" id="contact-us">

                        <!--Header-->
                        <div class="header pt-3 peach-gradient">

                            <div class="row d-flex justify-content-center">
                                <h1 class="white-text mb-3 pt-3 font-weight-bold">Contact Us</h1>
                            </div>

                            <div class="justify-content-center">
                            <!-- <div class="row mt-2 mb-3 d-flex justify-content-center"> -->
                                <!--Facebook-->
                                <h2 class="white-text text-center font-weight-bold">Have Questions? reach us at:</h2>
                            </div>

                        </div>
                        <!--Header-->

                        <div class="card-body mx-4 mt-4">

                            <!--Body-->
                            <div class="row mt-2 mb-3 d-flex justify-content-center">
                                <h2 class="mb-3 pt-3 font-weight-bold">Sanchit Software & Solutions Pvt. Ltd.</h2>
                            </div>
                            <div class="row mt-2 mb-3 d-flex justify-content-center">
                                <p class="mb-3 pt-3 font-weight-bold" style="font-size: 20px;">601-A/2, Shubham Centre,
                                    Cardinal Gracious Road, Opp. Holy Family Church,
                                    Andheri East, Mumbai 400 099,
                                    Maharashtra, India.<br/>
                                    Contact No: +91 95940 88815, (022) 2389 2772
                                </p>
                            </div>
                            <!--Grid row-->
                        </div>

                    </div>
</div>
 
@endsection
