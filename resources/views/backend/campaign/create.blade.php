@extends('backend.main')
@section('title', 'Campaign-Create')
@section('section_page', 'Campaign-Create')
@section('css')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.css') }}">
 <!-- Select2 -->
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')

<script src="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote();
        $("#someone_else").css("display", "none");
        $("#a_business").css("display", "none");
    $('#option1').on('click',function(){
        $("#someone_else").css("display", "none");
        $("#a_business").css("display", "none");
    });
    $('#option2').on('click',function(){
        $("#someone_else").css("display", "block");
        $("#a_business").css("display", "none");
    });
    $('#option3').on('click',function(){
        $("#someone_else").css("display", "none");
        $("#a_business").css("display", "block");
    });
    $('#option4').on('click',function(){
        $("#someone_else").css("display", "none");
        $("#a_business").css("display", "none");
    });
  })

        </script>
@endsection
@section('content')
		@if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                <ul>
                        <li>{{ session()->get('success') }}</li>
                </ul>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger">
                <ul>
                        <li>{{ session()->get('error') }}</li>
                </ul>
            </div>
        @endif
<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">

                <form class="pl-3 pr-3 form-horizontal" action="{{ route('campaigns.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                    <div class="card-header">
                        <label for="">Recipient</label>
                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                          <label class="btn bg-olive active">
                            <input type="radio" name="recipient_type" id="option1" autocomplete="off" value="me" checked=""> Me
                          </label>
                          <label class="btn bg-olive">
                            <input type="radio" name="recipient_type" id="option2" value="someone_else" autocomplete="off"> Someone Else
                          </label>
                          <label class="btn bg-olive">
                            <input type="radio" name="recipient_type" id="option3" value="a_business" autocomplete="off"> A Business
                          </label>
                          <label class="btn bg-olive">
                            <input type="radio" name="recipient_type" id="option4" value="a_charity" autocomplete="off"> A Charity
                          </label>
                    </div>
                    
                    </div>
                    <div id="someone_else" class="recepient_details" style="display: block;">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Recipient's Full Name</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><input type="text" class="form-control" name="recipient_first_name" id="recipient_first_name" value=""></p>
                                <span id="recipient_first_name_err" class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Recipient's Last Name</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><input type="text" class="form-control" name="recipient_last_name" id="recipient_last_name" value=""></p>
                                <span id="recipient_last_name_err" class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div id="a_business" class="recepient_details" >
                        <div class="form-group">
                            <label class="control-label col-sm-3">Recipient Business Name</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><input type="text" class="form-control" name="recipient_business_name" id="recipient_business_name" value=""></p>
                                <span id="recipient_business_name_err" class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Legal Representative First Name</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><input type="text" class="form-control" name="legal_recipient_first_name" id="legal_recipient_first_name" value=""></p>
                                <span id="legal_recipient_first_name_err" class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Legal Representative Last Name</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><input type="text" class="form-control" name="legal_recipient_last_name" id="legal_recipient_last_name" value=""></p>
                                <span id="legal_recipient_last_name_err" class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="added_by" value="{{ Auth::User()->id }}">
                    <div class="card-header">
                        <h4>Full Name: {{ Auth::User()->firstname }} {{ Auth::User()->lastname }}</h4>
                        <h4>Email Address: {{ Auth::User()->email }} </h4>
                        <h4>State: {{ Auth::User()->state }} </h4>
                        <h4>Country: {{ Auth::User()->country }} </h4>
                    </div>
                    <div class="form-group">
                        <label for="username">My Campaign Category </label>
                        <select name="category_id" class="form-control" required="">
                          @foreach($data as $key => $value)
                            <option value="{{ $value->id }}" selected="">{{ $value->title }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Title of your Campaign </label>
                        <input class="form-control" type="name" id="title" name="title" required="" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="username">My Fundraising Target </label>
                        <div class="input-group">
                                                    <span class="input-group-addon select">
                                                        <select name="project[currency]" class="form-control valid" id="currency">
                                                                                                                                                                                    <option value="2" data-minigoal="50000" selected="selected">INR ₹</option>
                                                                                                                        <option value="1" data-minigoal="1000">USD $</option>
                                                                                                                        <option value="9" data-minigoal="1000">EUR €</option>
                                                                                                                        <option value="10" data-minigoal="1000">GBP £</option>
                                                                                                                        <option value="13" data-minigoal="1">BTC ฿</option>
                                                                                                                                                                                </select>
                                                    </span>
                                                    <input type="number" class="form-control valid" min="50000" max="99999999" name="project[needed_amount]" id="needed_amount" value="0" data-isdecimal="no">
                                                </div>
                    </div>
                    <div class="form-group sel-product">
                        <label for="username">Story of the Project/Campaign:</label>
                        <textarea  class="textarea" name="description" required="">
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label for="username">Upload your campaign image</label>
                        <input class="form-control" type="file" name="photo" required="" >
                    </div>
                    <div class="alert alert-info alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <h5><i class="icon fas fa-info"></i> Alert!</h5>
                      TIP Project image needs to be at least 1200px by 650px. We suggest using a photograph with a clean and simple design.<br/>
                    File dimensions : at least 1200px (wide) by 650px (high) - Max file size : 5MB - Accepted file formats : JPG, PNG or GIF.
                    </div>
                    <div class="form-group sel-product">
                        <label for="username">Campaign Video:</label>
                        <div class="row">
                                                    <div class="col-sm-6">
                                                        <label  class="js_video_span1" for="video1">Vimeo Video</label>
                                                        <div class="input-group col-sm-12">
                                                            <span class="input-group-addon"><input type="radio" value="1" name="video_type" id="video1" class="js_v_radio"></span>
                                                            <span class="input-group-addon">http://www.vimeo.com/</span>
                                                            <input  class="cp3_edit_txt js_video1 form-control" id="js_v_txt1" name="video_1" value="" >
                                                        </div>
                                                        <div id="js_v_txt1_err" class="help-block"></div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label  class="js_video_span2" for="video2">YouTube Video</label>
                                                        <div class="input-group col-sm-12">
                                                            <span class="input-group-addon"><input type="radio" value="2" name="video_type" class="js_v_radio" id="video2"></span>
                                                            <span class="input-group-addon">http://www.youtube.com/watch?v=</span>
                                                            <input  class="js_video2 cp3_edit_txt form-control" id="js_v_txt2" name="video_2" value="">
                                                        </div>
                                                        <div id="js_v_txt2_err" class="help-block"></div>
                                                    </div>
                                                </div>
                    </div>
                    <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status" class="form-control" required="">
                            <option value="Active" >Active</option>
                            <option value="In-Active" >In-Active</option>
                        </select>
                    </div>
                    <div class="alert alert-info alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <h5><i class="icon fas fa-info"></i> Alert!</h5>
                      <div class="cp3_images_icon">
                                                    <em>TIP</em>
                                                    <ul>
                                                        <li>Simply upload your video to <a target="_blank" href="http://www.vimeo.com">vimeo.com</a> and type in your video's URL here - it's completely free. <br><b>For example:</b> if your video's URL was www.vimeo.com/123456, you'd just need to type in 123456.<br><b>Note:</b> if your video is set to private, you will need to have a pro account.</li>
                                                        <li>We can also embed your project video from YouTube. Simply upload your video to youtube.com and enter your video url code here. <br><b>Note:</b> You should only include the letters and numbers between "watch?v=" and "&amp;feature=youtu.be". <br><b>For example:</b> if your URL is "www.youtube.com/watch?v=87ObToBepkM&amp;feature=youtu.be" or "https://youtu.be/87ObToBepkM", enter 87ObToBepkM only.</li>
                                                    </ul>
                                                </div>


                    </div>
                    <div class="form-group row">
                        
                        <div class="col-sm-6">
                            <label class="col-sm-3 control-label" for="website_url">Your Website URL</label>
                            <input type="text" class="form-control" name="project[website_url]" placeholder="https://mysath.com" id="website_url" value="">
                            <span id="website_url_err" class="help-block"></span>
                        </div>
                        
                        <div class="col-sm-6">
                            <label class="col-sm-3 control-label" for="linkedin_url">Your LinkedIn URL</label>
                            <input type="text" class="form-control" name="project[linkedin_url]" placeholder="https://mysath.com" id="linkedin_url" value="">
                            <span id="linkedin_url_err" class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                        <label class="col-sm-3 control-label" for="facebook_url">Your Facebook URL</label>

                            <input type="text" class="form-control" name="project[facebook_url]" placeholder="https://mysath.com" id="facebook_url" value="">
                            <span id="facebook_url_err" class="help-block"></span>
                        </div>
                        <div class="col-sm-6">
                        <label class="col-sm-3 control-label" for="twitter_url">Your Twitter URL</label>

                            <input type="text" class="form-control" name="project[twitter_url]" placeholder="https://mysath.com" id="twitter_url" value="">
                            <span id="twitter_url_err" class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <h4>I have read and agree to the Terms &amp; Conditions.</h4>
                            <div class="checkbox">
                                <label class="text-justify"><input type="checkbox" class="simple" required="" name="" id="terms_condition1">I hereby confirm and agree with the company's terms and policies and declare that I have understood all the terms carefully. I also agree that I am creating my own campaign and all the contents, facts, figures, circumstances, rewards and promises that I might have published in my campaign, are the sole responsibility of me myself and company does not have any role to play in that. Content of my campaign cannot be held against the company in any situation whatsoever.</label>
                            </div>
                            <div class="checkbox">
                                <label class="text-justify"><input type="checkbox" class="simple" required="" name="" id="terms_condition2">I also agree and understand that OnlineSensor is not any kind of business opportunity and I have signed up on this platform to raise funds for my campaigns/projects and that I have signed up after carefully understanding the entire business model. I clearly understand that there are no investment or returns involved on this platform and I may or may not be able to raise money.</label>
                            </div>
                        </div>
                    </div>
                    <div class="cp3_images_icon">
                        <div class="cp3_feedcon shadow_fff">
                            <h4>Review/Feedback</h4>
                            <p>Once you submit your campaigns/projects for review, we sometimes offer tips and advice to help give it the best chance of succeeding. When we provide the review/feedback, you'll find it here.</p>
                                                                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div> <!-- end card body-->
            </div>
        </div>
    </div>
@endsection
