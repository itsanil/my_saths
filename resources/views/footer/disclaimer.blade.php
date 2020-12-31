@extends('layouts1.main')
@section('title', 'Disclaimer')
@section('section_page', 'Disclaimer')
@section('css')

@endsection

@section('content')
<div class="row">
	<div class="card">
       <div class="card-body" id="contact-us">

                      
<!-- <h2 style="text-align: center;"><b>DISCLAIMER</b></h2> -->
<p>Last updated: 2020-09-01</p>
<p><b>WEBSITE DISCLAIMER</b></p>
<p>The information provided by <b>Savita's Grocery</b> ('Company', 'we', 'our', 'us') on <b>sgonline.in</b> (the 'Site') is for general informational purposes only. All information on the Site is provided in good faith, however we make no representation or warranty of any kind, express or implied, regarding the accuracy, adequacy, validity, reliability, availability, or completeness of any information on the Site.</p>
<p>UNDER NO CIRCUMSTANCE SHALL WE HAVE ANY LIABILITY TO YOU FOR ANY LOSS OR DAMAGE OF ANY KIND INCURRED AS A RESULT OF THE USE OF THE SITE OR RELIANCE ON ANY INFORMATION PROVIDED ON THE SITE. YOUR USE OF THE SITE AND YOUR RELIANCE ON ANY INFORMATION ON THE SITE IS SOLELY AT YOUR OWN RISK.</p>
<p><b>EXTERNAL LINKS DISCLAIMER</b></p>
<p>The Site may contain (or you may be sent through the Site) links to other websites or content belonging to or originating from third parties or links to websites and features. Such external links are not investigated, monitored, or checked for accuracy, adequacy, validity, reliability, availability or completeness by us.</p>

<p>WE DO NOT WARRANT, ENDORSE, GUARANTEE, OR ASSUME RESPONSIBILITY FOR THE ACCURACY OR RELIABILITY OF ANY INFORMATION OFFERED BY THIRD-PARTY WEBSITES LINKED THROUGH THE SITE OR ANY WEBSITE OR FEATURE LINKED IN ANY BANNER OR OTHER ADVERTISING. WE WILL NOT BE A PARTY TO OR IN ANY WAY BE RESPONSIBLE FOR MONITORING ANY TRANSACTION BETWEEN YOU AND THIRD-PARTY PROVIDERS OF PRODUCTS OR SERVICES.</p>

<p><b>AFFILIATES DISCLAIMER</b></p><p>The Site may contain links to affiliate websites, and we may receive an affiliate commission for any purchases or actions made by you on the affiliate websites using such links.</p>
<p><b>TESTIMONIALS DISCLAIMER</b></p><p>The Site may contain testimonials by users of our products and/or services. These testimonials reflect the real-life experiences and opinions of such users. However, the experiences are personal to those particular users, and may not necessarily be representative of all users of our products and/or services. We do not claim, and you should not assume that all users will have the same experiences.</p> <p>YOUR INDIVIDUAL RESULTS MAY VARY.</p> <p>The testimonials on the Site are submitted in various forms such as text, audio and/or video, and are reviewed by us before being posted. They appear on the Site verbatim as given by the users, except for the correction of grammar or typing errors. Some testimonials may have been shortened for the sake of brevity, where the full testimonial contained extraneous information not relevant to the general public.</p> <p>The views and opinions contained in the testimonials belong solely to the individual user and do not reflect our views and opinions.</p>
<p><b>ERRORS AND OMISSIONS DISCLAIMER</b></p>
<p>While we have made every attempt to ensure that the information contained in this site has been obtained from reliable sources, Savita's Grocery is not responsible for any errors or omissions or for the results obtained from the use of this information. All information in this site is provided 'as is', with no guarantee of completeness, accuracy, timeliness or of the results obtained from the use of this information, and without warranty of any kind, express or implied, including, but not limited to warranties of performance, merchantability, and fitness for a particular purpose.</p> <p>In no event will Savita's Grocery, its related partnerships or corporations, or the partners, agents or employees thereof be liable to you or anyone else for any decision made or action taken in reliance on the information in this Site or for any consequential, special or similar damages, even if advised of the possibility of such damages.</p>

<p><b>LOGOS AND TRADEMARKS DISCLAIMER</b></p>
<p>All logos and trademarks of third parties referenced on sgonline.in are the trademarks and logos of their respective owners. Any inclusion of such trademarks or logos does not imply or constitute any approval, endorsement or sponsorship of Savita's Grocery by such owners.</p>
<p><b>CONTACT US</b></p>
<p>Should you have any feedback, comments, requests for technical support or other inquiries, please contact us by email: <b>support@sgonline.in</b>.</p>

                    </div>
                   </div>
</div>
  <div class="card">
            <div class="card-header bg-warning">
              <b><label class="card-title" style="color:white;">Contact Us</label></b>
            </div>
            <div class="card-body p-0">
               <div class="row" style="padding: 25px;">
                  <div class="col-md-12">
                    <span>
                      WhatsApp or Call us: <label>9321504147</label> | 10:00 AM to 7:00 PM, <label>365</label> days.<br/>
                      <a href="{{ url('terms-and-condition') }}" target="_blank" title="">Terms and Conditions</a>,
                      <a href="{{ url('privacy-policy') }}" target="_blank" title="">Privacy Policy</a>,
                      <a href="{{ url('disclaimer') }}" target="_blank" title="">Disclaimer</a>.
                    </span>
                  </div>
                </div>
            </div>
</div>
@endsection
