@extends('auth.main')
@section('title', 'Register')
@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- Select2 -->
<!-- validate -->
<script src="{{ asset('public/adminlte/plugins/jquery-validation/jquery.validate.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    var route = "{{ url('get-building-name') }}";
    $('#search').typeahead({
        source:  function (term, process) {
        return $.get(route, { term: term }, function (data) {
                return process(data);
            });
        }
    });
</script>
<script>
  $('#india_state').hide();
  $('#Div_Pan').hide();
  $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      url: '{{ route("get_state") }}',
      data: {
        'state_code': 'country'
      },
      beforeSend: function() {
        $('.loadingoverlay').css('display', 'block');
      },
      success: function(response) {
        if ((response.success == 1)) {
          $("#M_COUNTRY").html(response.data);
        } 
      }
      
    });


  function GetPanNo(){
    if ($('#M_COUNTRY').val() == 'India') {
      $('#Div_Pan').show();
        $("#Div_Cout").html('<div class="row">\
                                               <div class="form-group col-md-12">\
                                                   <label for="State">State<span style="color:red"></span></label>'+$('#india_state').html());
    } else {
      $('#Div_Pan').hide();
      $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      url: '{{ route("get_state") }}',
      data: {
        'state_code': $('#M_COUNTRY').val()
      },
      beforeSend: function() {
        $('.loadingoverlay').css('display', 'block');
      },
      success: function(response) {
        if ((response.success == 1)) {
          $("#Div_Cout").html('<div class="row">\
                                               <div class="form-group col-md-12">\
                                                   <label for="State">State<span style="color:red"></span></label>\
                                                   <select class="form-control" id="State_select" required="" name="State">'+            response.data+'</select>');
        } else {
              $("#Div_Cout").html('<div class="row">\
                                               <div class="form-group col-md-12">\
                                                   <label for="State">State<span style="color:red"></span></label>\
                                                   <input class="form-control" id="State" name="State" placeholder="Enter State" required="" type="text" value="">\
                                               </div>\
                                           </div>');
        }
      },
      complete: function() {
        $('.loadingoverlay').css('display', 'none');
      },
    });
    }
    
    

  }
 

  // $(document).on('submit', '#submitUserForm', function() {
    $('#submitUserForm').on( "submit", function(){
      alert('sdsd');
    var formData = $('#submitUserForm').serialize();
    var status = true;
    if($('#EMail').val() != $('#ConfirmEMail').val() || $('#EMail').val() != $('#ConfirmEMail').val() || $('#EMail').val() != $('#ConfirmEMail').val()){
      status = false;
    }
    $.ajax({
      type: 'POST',
      url: '{{ route("auth.validate") }}',
      processData: false,
      contentType: false,
      data: formData,
      beforeSend: function() {
        $('.loadingoverlay').css('display', 'block');
      },
      success: function(response) {
        if ((response.success == 1)) {
          toastr.success(response.message);
          $("#otp_number").val('');
          $("#token").val('');
          $("#token").val(response.token);
          $("#OtpModal").modal("show");
          
        } else {
          // toastr.error('The mobile has already been taken.');
          // var alrtList = '<ui>';
          $.each(response.message.building_name, function( index, value ) {
            toastr.error(value);
          });
          $.each(response.message.contact_no, function( index, value ) {
            toastr.error(value);
          });
          $.each(response.message.name, function( index, value ) {
            toastr.error(value);
          });
          $.each(response.message.mobile, function( index, value ) {
            toastr.error(value);
          });
          $.each(response.message.area_id, function( index, value ) {
            toastr.error('area field is required');
          });
          // alrtList += '</ui>';
          // toastr.error(alrtList);
        }
      },
      complete: function() {
        $('.loadingoverlay').css('display', 'none');
      },
    });
  });

  $(document).on('click', '#submitOtpForm', function() {
    var formData = new FormData($('#otpForm')[0]);
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      url: '{{ route("auth.register") }}',
      data: {
        '_token': $('input[name=_token]').val()
        ,'otp_number': $('#otp_number').val()
        ,'token': $('#token').val()
        ,'name' : $("#name").val()
        ,'contact_no' : $("#contact_no").val()
        ,'city' : $("#city").val()
        ,'area_id' : $("#area_id").val()
        ,'building_name' : $("#search").val()
        ,'mobile' : $("#mobile").val()
        ,'lane' : $("#lane").val()
        ,'flat_no' : $("#flat_no").val()
      },
      beforeSend: function() {
        $('.loadingoverlay').css('display', 'block');
      },
      success: function(response) {
        if ((response.success == 1)) {
          $("#OtpModal").modal("hide");
          toastr.success(response.message);
          setTimeout(function(){
            window.location.href = 'home';
          }, 2000);
          
        } else {
         toastr.error(response.message);
        }
      },
      complete: function() {
        $('.loadingoverlay').css('display', 'none');
      },
    });
  });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();
  });
</script>
    State_name
@endsection
@section('content')
<div id="india_state">
  <select id="state" class="form-control" name="State"><option value="Andhra Pradesh">Andhra Pradesh</option><option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option><option value="Arunachal Pradesh">Arunachal Pradesh</option><option value="Assam">Assam</option><option value="Bihar">Bihar</option><option value="Chandigarh">Chandigarh</option><option value="Chhattisgarh">Chhattisgarh</option><option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option><option value="Daman and Diu">Daman and Diu</option><option value="Delhi">Delhi</option><option value="Lakshadweep">Lakshadweep</option><option value="Puducherry">Puducherry</option><option value="Goa">Goa</option><option value="Gujarat">Gujarat</option><option value="Haryana">Haryana</option><option value="Himachal Pradesh">Himachal Pradesh</option><option value="Jammu and Kashmir">Jammu and Kashmir</option><option value="Jharkhand">Jharkhand</option><option value="Karnataka">Karnataka</option><option value="Kerala">Kerala</option><option value="Madhya Pradesh">Madhya Pradesh</option><option value="Maharashtra">Maharashtra</option><option value="Manipur">Manipur</option><option value="Meghalaya">Meghalaya</option><option value="Mizoram">Mizoram</option><option value="Nagaland">Nagaland</option><option value="Odisha">Odisha</option><option value="Punjab">Punjab</option><option value="Rajasthan">Rajasthan</option><option value="Sikkim">Sikkim</option><option value="Tamil Nadu">Tamil Nadu</option><option value="Telangana">Telangana</option><option value="Tripura">Tripura</option><option value="Uttar Pradesh">Uttar Pradesh</option><option value="Uttarakhand">Uttarakhand</option><option value="West Bengal">West Bengal</option></select>
  
</div>
<section>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8" style="border: 2px solid #3c2f24;background: #00a4ef;color: #fff;">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4" style="margin-bottom:20px;">
                            <h3 class="text-center">Sign Up</h3>
                        
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p class="text-center">We'll never post anything without your permission. And you can choose to stay anonymous!</p>
                    </div>
                <form id="submitUserForm" method="POST">  
                                          <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="form_username_email">USER TYPE<span style="color:red">*</span></label>
                                <select class="form-control custom-select" id="USERTYPE" name="USERTYPE" required=""><option value="NONNGO">I AM INDIVIDUAL</option>
                                <option value="NGO">I  AM AN NGO</option>
                                </select>
                            </div>
                        </div>


                      <div class="col-md-6">
                            <div class="form-group ">
                                <label for="form_password">User Name<span style="color:red">*</span></label>
                                <input class="form-control" data-val="true" data-val-regex="Enter Valid User ID" data-val-regex-pattern="^[A-Z0-9a-z]+$" data-val-required="User ID is required" id="username" maxlength="18" name="username" placeholder="Your Name*" required="" type="text" value="">
                                <span class="field-validation-valid" data-valmsg-for="username" data-valmsg-replace="true"></span>
                            </div>
                        </div>
                           </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label for="form_username_email">First Name<span style="color:red">*</span></label>
                                        <input class="form-control" id="MembName_F" maxlength="25" name="MembName_F" placeholder="First Name*" required="" type="text" value="">
                                        <span class="field-validation-valid" data-valmsg-for="MembName_F" data-valmsg-replace="true"></span>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="MembName_L">Last Name<span style="color:red">*</span></label>
                                        <input class="form-control" id="MembName_L" maxlength="50" name="MembName_L" placeholder="Last Name" required="" type="text" value="">
                                        <span class="field-validation-valid" data-valmsg-for="MembName_L" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="DOB">DOB<span style="color:red">*</span></label>
                                        <input class="form-control" id="DOB" name="DOB" required="" type="date" value="">
                                        <span class="field-validation-valid" data-valmsg-for="DOB" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="Gender">Gender<span style="color:red">*</span></label>
                                    <select class="form-control" id="Gender" name="Gender"><option value="Male">Male</option>
<option value="Female">Female</option>
<option value="TRANSGENDER">TRANSGENDER</option>
</select>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label for="form_password">Email Address<span style="color:red">*</span></label>
                                        <input class="form-control" data-val="true" data-val-regex="Enter Valid Email ID" data-val-regex-pattern="^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z\-])+\.)+([a-zA-Z]{2,6})$" data-val-required="Please Enter Email ID" id="EMail" maxlength="50" name="EMail" placeholder="Email Address*" required="" type="email" value="">
                                        <span class="field-validation-valid" data-valmsg-for="EMail" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="form_password">Confirm Email Address<span style="color:red">*</span></label>
                                        <input class="form-control" data-val="true" data-val-regex="Enter Valid Email ID" data-val-regex-pattern="^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z\-])+\.)+([a-zA-Z]{2,6})$" data-val-required="Please Enter Email ID" id="ConfirmEMail" maxlength="50" name="ConfirmEMail" placeholder="Confirm Email Address*" required="" type="text" value="">
                                        <span class="field-validation-valid" data-valmsg-for="ConfirmEMail" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label for="form_username_email">Password<span style="color:red">*</span></label>
                                        <input class="form-control" data-val="true" data-val-required="Password is required" id="mpwd" maxlength="25" name="mpwd"  placeholder="Password*" required="" type="password">
                                        <span class="field-validation-valid" data-valmsg-for="mpwd" data-valmsg-replace="true"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="form_username_email">Verify Password<span style="color:red">*</span></label>
                                        <input class="form-control" data-val="true" data-val-equalto="The password and confirmation password do not match." data-val-equalto-other="*.mpwd" data-val-required="Confirm Password is required" id="ConfirmPass" maxlength="25" name="ConfirmPass"  placeholder="Verify Password*" required="" type="password">
                                        <span class="field-validation-valid" data-valmsg-for="ConfirmPass" data-valmsg-replace="true"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label for="form_username_email">Security Pin<span style="color:red">*</span></label>
                                        <input class="form-control" data-val="true" data-val-regex="Enter Valid Confirm Pin ID" data-val-regex-pattern="^([0-9]{4})$" data-val-required="Please Enter Confirm Pin ID" id="Confirmpin" max="9999" maxlength="4" min="-999" name="Confirmpin"  placeholder="Security Pin*" required="" type="password">
                                        <span class="field-validation-valid" data-valmsg-for="Confirmpin" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="form_username_email">Verify Security Pin<span style="color:red">*</span></label>
                                        <input class="form-control" data-val="true" data-val-regex="Enter Valid Pin ID" data-val-regex-pattern="^([0-9]{4})$" data-val-required="Please Enter Pin ID" id="pin" maxlength="4" name="pin"  placeholder="Verify Security Pin*" required="" type="password">
                                        <span class="field-validation-valid" data-valmsg-for="pin" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                                   <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="campaign">Address</label>

                                            


                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                        </div>
                                    </div>
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="row">
                                               <div class="form-group col-md-12">
                                                   <label for="form_password">Country<span style="color:red"></span></label>
                                                   <select class="form-control" id="M_COUNTRY" name="M_COUNTRY" onchange="GetPanNo();">
                                                    </select>
                                               </div>
                                           </div>
                                       </div>
                                       <div id="Div_Cout" class="col-md-6">
                                           <div class="row">
                                               <div class="form-group col-md-12">
                                                   <label for="State">State<span style="color:red"></span></label>
                                                   <select class="form-control" id="State_select" name="State"><option value="">Select State</option>
</select>
                                               </div>
                                           </div>
                                       </div>

                                       <div id="Div_Cout1" hidden="" class="col-md-6">
                                           <div class="row">
                                               <div class="form-group col-md-12">
                                                   <label for="State">State<span style="color:red"></span></label>
                                                   <input class="form-control" id="State" name="State_name" placeholder="State"  type="text" value="">
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="District">District<span style="color:red"></span></label>
                                            <input class="form-control" id="District" name="District" placeholder="District" required="" type="text" value="">
                                            <span class="field-validation-valid" data-valmsg-for="District" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="form_username_email">City<span style="color:red"></span></label>
                                            <input class="form-control" id="City" name="City" placeholder="City" required="" type="text" value="">
                                            <span class="field-validation-valid" data-valmsg-for="City" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="form_username_email">Pin Code<span style="color:red">*</span></label>
                                            <input class="form-control" id="pinno" name="pinno" placeholder="Pin Code" required="" type="text" value="">
                                            <span class="field-validation-valid" data-valmsg-for="pinno" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="form-group col-md-12" for="form_password">Mobile Number<span style="color:red">*</span></label>
                                        <div class="row" style="padding-right:15px;padding-left:15px;">
                                            <div class="col-md-4 col-xs-4" style="padding-right:0px;">
                                                <select class="form-control" id="phonecode" name="phonecode" style="display:inline-block"><option value="+91">+91</option>
<option value="+93">+93</option>
<option value="+355">+355</option>
<option value="+213">+213</option>
<option value="+376">+376</option>
<option value="+244">+244</option>
<option value="+1-268">+1-268</option>
<option value="+54">+54</option>
<option value="+374">+374</option>
<option value="+297">+297</option>
<option value="+1-684">+1-684</option>
<option value="+61">+61</option>
<option value="+43">+43</option>
<option value="+994">+994</option>
<option value="+1-242">+1-242</option>
<option value="+880">+880</option>
<option value="+1-246">+1-246</option>
<option value="+257">+257</option>
<option value="+32">+32</option>
<option value="+  229">+  229</option>
<option value="+1-441">+1-441</option>
<option value="+975">+975</option>
<option value="+387">+387</option>
<option value="+501">+501</option>
<option value="+375">+375</option>
<option value="+591">+591</option>
<option value="+267">+267</option>
<option value="+55">+55</option>
<option value="+973">+973</option>
<option value="+673">+673</option>
<option value="+359">+359</option>
<option value="+226">+226</option>
<option value="236">236</option>
<option value="+855">+855</option>
<option value="+1">+1</option>
<option value="+1-345">+1-345</option>
<option value="+242">+242</option>
<option value="+235">+235</option>
<option value="+56">+56</option>
<option value="+86">+86</option>
<option value="Cote d'Ivoire">Cote d'Ivoire</option>
<option value="+237">+237</option>
<option value="+243">+243</option>
<option value="+682">+682</option>
<option value="+57">+57</option>
<option value="+269">+269</option>
<option value="+238">+238</option>
<option value="+506">+506</option>
<option value="+385">+385</option>
<option value="+53">+53</option>
<option value="+357">+357</option>
<option value="+420">+420</option>
<option value="+45">+45</option>
<option value="+253">+253</option>
<option value="+1 767">+1 767</option>
<option value="+1 809">+1 809</option>
<option value="+593">+593</option>
<option value="+20">+20</option>
<option value="+291">+291</option>
<option value="+503">+503</option>
<option value="+34">+34</option>
<option value="+372">+372</option>
<option value="+251">+251</option>
<option value="+679">+679</option>
<option value="+358">+358</option>
<option value="+33">+33</option>
<option value="+691">+691</option>
<option value="+241">+241</option>
<option value="+220">+220</option>
<option value="+44">+44</option>
<option value="+245">+245</option>
<option value="+995">+995</option>
<option value="+240">+240</option>
<option value="+49">+49</option>
<option value="+233">+233</option>
<option value="+30">+30</option>
<option value="+1 473">+1 473</option>
<option value="+502">+502</option>
<option value="+224">+224</option>
<option value="+1 671">+1 671</option>
<option value="+592">+592</option>
<option value="+509">+509</option>
<option value="+852">+852</option>
<option value="+504">+504</option>
<option value="+36">+36</option>
<option value="+62">+62</option>
<option value="+98">+98</option>
<option value="+353">+353</option>
<option value="+964">+964</option>
<option value="+354">+354</option>
<option value="+972">+972</option>
<option value="+00 1">+00 1</option>
<option value="+39">+39</option>
<option value="+1 284">+1 284</option>
<option value="+1 876">+1 876</option>
<option value="+962">+962</option>
<option value="+81">+81</option>
<option value="+7 6">+7 6</option>
<option value="+254">+254</option>
<option value="+996">+996</option>
<option value="+686">+686</option>
<option value="+82">+82</option>
<option value="+383">+383</option>
<option value="+966">+966</option>
<option value="+965">+965</option>
<option value="+856">+856</option>
<option value="+371">+371</option>
<option value="+218">+218</option>
<option value="+231">+231</option>
<option value="+1 758">+1 758</option>
<option value="+266">+266</option>
<option value="+961">+961</option>
<option value="+423">+423</option>
<option value="+370">+370</option>
<option value="+352">+352</option>
<option value="+261">+261</option>
<option value="+212">+212</option>
<option value="+60">+60</option>
<option value="+265">+265</option>
<option value="+373">+373</option>
<option value="+960">+960</option>
<option value="+52">+52</option>
<option value="+976">+976</option>
<option value="+692">+692</option>
<option value="+389">+389</option>
<option value="+223">+223</option>
<option value="+356">+356</option>
<option value="+382">+382</option>
<option value="+377">+377</option>
<option value="+258">+258</option>
<option value="+230">+230</option>
<option value="+222">+222</option>
<option value="+95">+95</option>
<option value="+264">+264</option>
<option value="+505">+505</option>
<option value="+31">+31</option>
<option value="+977">+977</option>
<option value="+234">+234</option>
<option value="+227">+227</option>
<option value="+47">+47</option>
<option value="+674">+674</option>
<option value="+64">+64</option>
<option value="+968">+968</option>
<option value="+92">+92</option>
<option value="+507">+507</option>
<option value="+595">+595</option>
<option value="+51">+51</option>
<option value="+63">+63</option>
<option value="+970">+970</option>
<option value="+680">+680</option>
<option value="+675">+675</option>
<option value="+48">+48</option>
<option value="+351">+351</option>
<option value="+850">+850</option>
<option value="+1 787">+1 787</option>
<option value="+974">+974</option>
<option value="+40">+40</option>
<option value="+27">+27</option>
<option value="+7">+7</option>
<option value="+250">+250</option>
<option value="+685">+685</option>
<option value="+221">+221</option>
<option value="+248">+248</option>
<option value="+65">+65</option>
<option value="+1 869">+1 869</option>
<option value="+232">+232</option>
<option value="+386">+386</option>
<option value="+378">+378</option>
<option value="+677">+677</option>
<option value="+252">+252</option>
<option value="+381">+381</option>
<option value="+94">+94</option>
<option value="+211">+211</option>
<option value="+239">+239</option>
<option value="+249">+249</option>
<option value="+41">+41</option>
<option value="+597">+597</option>
<option value="+421">+421</option>
<option value="+46">+46</option>
<option value="+268">+268</option>
<option value="+963">+963</option>
<option value="+255">+255</option>
<option value="+676">+676</option>
<option value="+66">+66</option>
<option value="+992">+992</option>
<option value="+993">+993</option>
<option value="+670">+670</option>
<option value="+228">+228</option>
<option value="+886">+886</option>
<option value="+1 868">+1 868</option>
<option value="+216">+216</option>
<option value="+90">+90</option>
<option value="+688">+688</option>
<option value="+971">+971</option>
<option value="+256">+256</option>
<option value="+380">+380</option>
<option value="+598">+598</option>
<option value="+998">+998</option>
<option value="+678">+678</option>
<option value="+58">+58</option>
<option value="+84">+84</option>
<option value="+1 784">+1 784</option>
<option value="+967">+967</option>
<option value="+260">+260</option>
<option value="+255 24">+255 24</option>
<option value="+263">+263</option>
</select>

                                            </div>

                                            <div class="col-md-8 col-xs-8" style="padding-left:0px;">
                                                <input class="form-control" id="Mobile_No" maxlength="30" name="Mobile_No" placeholder="MOBILE NUMBER" required="" type="number" value="">
                                                <span class="field-validation-valid" data-valmsg-for="Mobile_No" data-valmsg-replace="true"></span>
                                                
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="form_username_email"><span></span></label>
                                            
                                        </div>
                                    </div>
                                </div>

                                
                                
                                <div class="col-md-6">
                                    <div class="row" id="Div_Pan">
                                        <div class="form-group col-md-12">
                                            <label for="PanNo">PAN/AADHAR NUMBER<span style="color:red"></span></label>
                                            <input class="form-control" id="PanNo" maxlength="50" name="PanNo" placeholder="PAN/AADHAR NUMBER" type="text"  value="">
                                            <span class="field-validation-valid" data-valmsg-for="PanNo" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="campaign">Select Campaign Category</label>




                                            <select class="form-control" id="campaign" required="" name="campaign"><option value="Select Campaign Category">Select Campaign Category</option>
<option value="ADOPTION">ADOPTION</option>
<option value="ANIMALS PROTECTIONS">ANIMALS PROTECTIONS</option>
<option value="ART &amp; CRAFTS">ART &amp; CRAFTS</option>
<option value="BUY A HOME">BUY A HOME</option>
<option value="BUILDING &amp; CONSTRUCTION">BUILDING &amp; CONSTRUCTION</option>
<option value="COMMUNITY &amp; SOCIETY">COMMUNITY &amp; SOCIETY</option>
<option value="CREATIVE PROJECTS">CREATIVE PROJECTS</option>
<option value="DANCE">DANCE</option>
<option value="DEVELOP A SOFTWARE">DEVELOP A SOFTWARE</option>
<option value="EDUCATIONS">EDUCATIONS</option>
<option value="EMERGENCIES">EMERGENCIES</option>
<option value="ENERGY &amp; ENVIRONMENTS">ENERGY &amp; ENVIRONMENTS</option>
<option value="EVENTS">EVENTS</option>
<option value="FAMILY">FAMILY</option>
<option value="FILMS/VIDEO">FILMS/VIDEO</option>
<option value="FOOD">FOOD</option>
<option value="GET OUT OF DEBTS">GET OUT OF DEBTS</option>
<option value="HOLIDAYS">HOLIDAYS</option>
<option value="MEDICAL &amp; HEALTH">MEDICAL &amp; HEALTH</option>
<option value="MEMORIALS &amp; FUNERALS">MEMORIALS &amp; FUNERALS</option>
<option value="MILITARY &amp; VETERANS">MILITARY &amp; VETERANS</option>
<option value="NON PROFITS &amp; CHARITY">NON PROFITS &amp; CHARITY</option>
<option value="ORGANISATIONS">ORGANISATIONS</option>
<option value="PETS">PETS</option>
<option value="PUBLISH A BOOK">PUBLISH A BOOK</option>
<option value="REPAY A LOAN">REPAY A LOAN</option>
<option value="SPORTS">SPORTS</option>
<option value="SPECIAL OCCASIONS">SPECIAL OCCASIONS</option>
<option value="TO START/FUND BUSINESS">TO START/FUND BUSINESS</option>
<option value="TRAVEL/TRIPS">TRAVEL/TRIPS</option>
</select>
                                        </div>
                                    </div>
                                </div>







                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox pull-left mt-15" style="padding-left:17px;">
                                            <label for="form_checkbox">
                                                <input id="form_checkbox" name="form_checkbox" type="checkbox" required="">
                                                I agree to the Terms of Use, Privacy Policy and Policies &amp; Procedures.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox pull-left mt-15" style="padding-left: 17px;">
                                            <label for="form_checkbox">
                                                <input id="form_checkbox" name="form_checkbox" type="checkbox" required="">
                                                I declare under penalty of perjury that I am the person enrolling above or have the legal authority to enroll the person above and that all the information stated above (including the email address) is correct
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox pull-left mt-15" style="padding-left: 17px;">
                                            <label for="form_checkbox">
                                                <input id="form_checkbox" name="form_checkbox" type="checkbox" required="">
                                                I've read the DISCLAIMER, now aware fully of the risks and consider to participate in the Mycrowdfunding  , being of sound memory and mind
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <p>() - This is your IP Address and will be used to prosecute criminal behavior.</p>
                                </div>
                                {{ csrf_field() }}
                                <div class="col-md-12">
                                    <div class="form-group text-center mt-10">
                                        <button type="submit" class="btn btn-dark btn-sm">Submit</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-center mt-10">
                                        <p>Have An Account ? <a href="{{ url('/login') }}" style="color:#fff !important;">LOGIN</a> </p>
                                    </div>
                                </div>
                            </div>
</form>                            </div>
            </div>
        </div>
    </section>
<!-- OPT MODAL END -->
@endsection
