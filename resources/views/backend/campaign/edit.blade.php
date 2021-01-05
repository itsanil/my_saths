@extends('backend.main')
@section('title', 'Campaign-Edit')
@section('section_page', 'Campaign-Edit')
@section('css')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.css') }}">
 <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')

<script src="{{ asset('public/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
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
          $("#country_name").html(response.data);
        } 
      }
      
    });
</script>
@if(!empty($perk_data))
<script>
  $(function () {
    $('#perk_type').val('{{ $perk_data->perk_type  }}');
    $('#perk_title').val('{{ $perk_data->perk_title  }}');
    $('#perk_description').val('{{ $perk_data->perk_description  }}');
    $('#amount').val('{{ $perk_data->amount  }}');
    $('#max_perks').val('{{ $perk_data->max_perks  }}');
    $('#estimated_date').val('{{ $perk_data->estimated_date  }}');
    $('#perk_description').val('{{ $perk_data->perk_description  }}');
    $('#country_name').val('{{ json_decode($perk_data->shipping_address)->address  }}');
    $('#shipping_perk_fees').val('{{ json_decode($perk_data->shipping_address)->fees  }}');
  })
</script>
@endif
<script>
    $(function () {
        $("#example1").DataTable({
          "responsive": true,
          "autoWidth": false,
        });

        $("#example2").DataTable({
          "responsive": true,
          "autoWidth": false,
        });

    

        $('#shipping_address').hide();
        $('#vert-tabs-profile-tab').on('click',function(){
        $('#shipping_address_status').on('change',function(){
            if($('#shipping_address_status:checked').length == '1'){
                $('#shipping_address').show();
            }else{
                $('#shipping_address').hide();
            }
        });
        });

        $('#shipping_address_status').on('change',function(){

            if($('#shipping_address_status:checked').length == '1'){
                $('#shipping_address').show();
            }else{
                $('#shipping_address').hide();
            }
        });

        var perk_html = $('.panel-body').html();

        $('#perk_btn').on('click',function(){
            if($('#perk_btn').html() == 'Cancel'){
                $('.panel-body').html('');
                $('#perk_btn').html('ADD');
            }else{
                $('.panel-body').html(perk_html);
                $('#perk_btn').html('Cancel')

            }
            
        });

    });
  $(function () {
    // Summernote
    $('.textarea').summernote();
    $('#category_id').val('{{ $campaign->category_id  }}');
    $('#edit_status').val('{{ $campaign->status  }}');
    $('#currency').val('{{ json_decode($campaign->project)->currency  }}');
    $('#needed_amount').val('{{ json_decode($campaign->project)->needed_amount  }}');

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
        <form class="pl-3 pr-3" action="{{ route('campaigns.update',$campaign->id) }}" method="POST" enctype="multipart/form-data">
                  @method('PUT')
                  @csrf
        <div class="card card-primary card-outline">
          <div class="card-body">
            <div class="row">
              <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#campaign" role="tab" aria-controls="vert-tabs-home" aria-selected="false">Edit/Update Your Campaign</a>
                  <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#campaign-perk" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Campaign Perk</a>
                  <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#campaign-imgs" role="tab" aria-controls="vert-tabs-messages" aria-selected="false"> Campaign Additional Images</a>
                  <a class="nav-link " id="vert-tabs-settings-tab" data-toggle="pill" href="#campaign-comment" role="tab" aria-controls="vert-tabs-settings" aria-selected="true">Campaign Comment</a>
                  <a class="nav-link " id="vert-tabs-settings-tab" data-toggle="pill" href="#campaign-subscribers" role="tab" aria-controls="vert-tabs-settings" aria-selected="true">Campaign Subscribers</a>
                </div>
              </div>
              <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                  <div class="tab-pane text-left fade active show" id="campaign" role="tabpanel" aria-labelledby="campaign-tab">
                     <div class="row">
                        <div class="col-12">
                            <div class="card">
                              <div class="card-body">
                                    <div class="card-header">
                                        <label for="">Recipient</label>
                                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                          <label class="btn bg-olive active">
                                            <input type="radio" name="recipient_type" id="option1" autocomplete="off" value="me" <?php if($campaign->recipient_type == 'me'){ echo "checked"; } ?> checked=""> Me
                                          </label>
                                          <label class="btn bg-olive">
                                            <input type="radio" name="recipient_type" id="option2" value="someone_else" autocomplete="off" <?php if($campaign->recipient_type == 'someone_else'){ echo "checked"; } ?>> Someone Else
                                          </label>
                                          <label class="btn bg-olive">
                                            <input type="radio" name="recipient_type" id="option3" value="a_business" autocomplete="off" <?php if($campaign->recipient_type == 'a_business'){ echo "checked"; } ?>> A Business
                                          </label>
                                          <label class="btn bg-olive">
                                            <input type="radio" name="recipient_type" id="option4" value="a_charity" autocomplete="off" <?php if($campaign->recipient_type == 'a_charity'){ echo "checked"; } ?>> A Charity
                                          </label>
                                    </div>
                                    
                                    </div>
                                    <div id="someone_else" class="recepient_details" style="display: block;">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Recipient's Full Name</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><input type="text" class="form-control" name="recipient_first_name" id="recipient_first_name" value="{{ $campaign->recipient_first_name  }}"></p>
                                                <span id="recipient_first_name_err" class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Recipient's Last Name</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><input type="text" class="form-control" name="recipient_last_name" id="recipient_last_name" value="{{ $campaign->recipient_last_name  }}"></p>
                                                <span id="recipient_last_name_err" class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="a_business" class="recepient_details" >
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Recipient Business Name</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><input type="text" class="form-control" name="recipient_business_name" id="recipient_business_name" value="{{ $campaign->recipient_business_name  }}"></p>
                                                <span id="recipient_business_name_err" class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Legal Representative First Name</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><input type="text" class="form-control" name="legal_recipient_first_name" id="legal_recipient_first_name" value="{{ $campaign->legal_recipient_first_name  }}"></p>
                                                <span id="legal_recipient_first_name_err" class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Legal Representative Last Name</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><input type="text" class="form-control" name="legal_recipient_last_name" id="legal_recipient_last_name" value="{{ $campaign->legal_recipient_last_name  }}"></p>
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
                                        <select name="category_id" id="category_id" class="form-control" required="">
                                          @foreach($data as $key => $value)
                                            <option value="{{ $value->id }}" selected="">{{ $value->title }}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Title of your Campaign </label>
                                        <input class="form-control" type="name" id="title" name="title" required="" placeholder="Enter title" value="{{ $campaign->title }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">My Fundraising Target </label>
                                        <div class="input-group">
                                            <span class="input-group-addon select">
                                                <select name="project[currency]" class="form-control valid" id="currency">                                                                                                                                                  <option value="2" data-minigoal="50000" selected="selected">INR ₹</option>
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
                                        <textarea  class="textarea" name="description" required="">{{ $campaign->discription  }}
                                        </textarea>
                                    </div>
                                    @if($campaign->photo !='')
                                        <center>
                                            <img src="{{ url('storage') }}/{{ $campaign->photo }}" alt="">
                                        </center>
                                    @endif
                                    <div class="form-group">
                                        <label for="username">Upload your campaign image</label>
                                        <input class="form-control" type="file" name="photo"  >
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
                                                                            <span class="input-group-addon"><input type="radio" value="1" name="video_type" id="video1" class="js_v_radio" <?php if($campaign->video_type == 1){ echo "checked"; } ?> ></span>
                                                                            <span class="input-group-addon">http://www.vimeo.com/</span>
                                                                            <input  class="cp3_edit_txt js_video1 form-control" id="js_v_txt1" name="video_1" value="{{ $campaign->video_1 }}" >
                                                                        </div>
                                                                        <div id="js_v_txt1_err" class="help-block"></div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <label  class="js_video_span2" for="video2">YouTube Video</label>
                                                                        <div class="input-group col-sm-12">
                                                                            <span class="input-group-addon"><input type="radio" value="2" name="video_type" class="js_v_radio" id="video2" <?php if($campaign->video_type == 2){ echo "checked"; } ?> ></span>
                                                                            <span class="input-group-addon">http://www.youtube.com/watch?v=</span>
                                                                            <input  class="js_video2 cp3_edit_txt form-control" id="js_v_txt2" name="video_2" value="{{ $campaign->video_2 }}">
                                                                        </div>
                                                                        <div id="js_v_txt2_err" class="help-block"></div>
                                                                    </div>
                                                                </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Select Status</label>
                                        <select name="status" id="edit_status" class="form-control" required="">
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
                                            <input type="text" class="form-control" name="project[website_url]" placeholder="https://mysath.com" id="website_url" value="{{json_decode($campaign->project)->website_url}}">
                                            <span id="website_url_err" class="help-block"></span>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <label class="col-sm-3 control-label" for="linkedin_url">Your LinkedIn URL</label>
                                            <input type="text" class="form-control" name="project[linkedin_url]" placeholder="https://mysath.com" id="linkedin_url" value="{{json_decode($campaign->project)->linkedin_url}}">
                                            <span id="linkedin_url_err" class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                        <label class="col-sm-3 control-label" for="facebook_url">Your Facebook URL</label>

                                            <input type="text" class="form-control" name="project[facebook_url]" placeholder="https://mysath.com" id="facebook_url" value="{{json_decode($campaign->project)->facebook_url}}">
                                            <span id="facebook_url_err" class="help-block"></span>
                                        </div>
                                        <div class="col-sm-6">
                                        <label class="col-sm-3 control-label" for="twitter_url">Your Twitter URL</label>

                                            <input type="text" class="form-control" name="project[twitter_url]" placeholder="https://mysath.com" id="twitter_url" value="{{json_decode($campaign->project)->twitter_url}}">
                                            <span id="twitter_url_err" class="help-block"></span>
                                        </div>
                                    </div>
                                    
                                    
                            </div> <!-- end card body-->
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="campaign-perk" role="tabpanel" aria-labelledby="campaign-perk-tab">
                    <div class="panel-heading">
                        @if(empty($perk_data))
                        <a href="#" id="perk_btn" class="btn btn-danger btn-xs cancel float-right">Cancel</a>
                        <h4 class="panel-title">Perks Details</h4>
                        @endif
                    </div>
                    <div class="panel-body">
                        <input type="hidden" class="form-control" name="perk[project_id]" id="project_id" value="{{ $campaign->id }}">
                        <input type="hidden" class="form-control" name="campaign_perk_id" id="campaign_perk_id" value="">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4">Perk Type</label>
                            <div class="col-sm-8">
                                <select name="perk[perk_type]" class="form-control" id="perk_type" required="">
                                    <option value="1">Product</option>
                                    <option value="2">Service</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4">Perk Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="perk[perk_title]" required="" id="perk_title" value="">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4">Perk Description:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="perk[perk_description]" required="" id="perk_description"></textarea>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4">Perk Image:</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="file" name="perk[image]"  id="perk_image">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4">Contribution Amount:</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon">INR</span>
                                    <input type="number" class="form-control" name="perk[amount]" required="" id="amount" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4">Number Available</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="perk[max_perks]" required="" id="max_perks" value="">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label class="col-sm-4">Estimated Delivery Date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control datepicker" name="perk[estimated_date]" id="estimated_date" value="{{ date('Y-m-d') }}" readonly="readonly">
                            </div>
                        </div>
                        <div id="shipping">
                            <div class="form-group col-sm-12">
                                <label class="col-sm-4">Shipping Location</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" name="perk[shipping_address_status]" id="shipping_address_status" >
                                </div>
                            </div>
                            <div class="form-group col-sm-12" id="shipping_address">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="col-sm-5">Shipping Address</label>
                                        <label class="col-sm-5">Shipping Fee</label>
                                        <label class="col-sm-2"></label>
                                        <input type="hidden" id="shipping_address_count" value="2">
                                    </div>
                                </div>
                                <div id="addresses" class="well">
                                    <div id="shipping_address_0" class="form-group">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <select name="shipping_address[address]" class="form-control valid" id="country_name" >
                                                </select>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <span class="input-group-addon" >INR</span>
                                                    <input type="number" name="shipping_address[fees]" id="shipping_perk_fees" min="0" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12">
                                    <button type="button" id="add_shipping_address" class="btn btn-xs btn-primary">Add a Location</button>
                                </div> -->
                            </div>
                        </div>
                    </div>
                  </div>
                <div class="tab-pane fade" id="campaign-imgs" role="tabpanel" aria-labelledby="campaign-imgs-tab">
                    <div class="form-group">
                        <label for="username">Photo 1</label>
                        <input class="form-control" type="file" name="add_photo[]"  >
                    </div> 
                    <div class="form-group">
                        <label for="username">Photo 2</label>
                        <input class="form-control" type="file" name="add_photo[]"  >
                    </div>
                    <div class="form-group">
                        <label for="username">Photo 3</label>
                        <input class="form-control" type="file" name="add_photo[]"  >
                    </div>
                     <div class="form-group">
                        <label for="username">Photo 4</label>
                        <input class="form-control" type="file" name="add_photo[]"  >
                    </div>
                    <div class="form-group">
                        <label for="username">Photo 5</label>
                        <input class="form-control" type="file" name="add_photo[]"  >
                    </div>
                </div>
                <div class="tab-pane fade" id="campaign-comment" role="tabpanel" aria-labelledby="campaign-comment-tab">
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Name</th>
                                    <th>Email Id</th>
                                    <th>Comment</th>
                                    <th>Created on</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div> <!-- end card body-->
                </div>
                <div class="tab-pane fade" id="campaign-subscribers" role="tabpanel" aria-labelledby="campaign-subscribers-tab">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Name</th>
                                    <th>Email Id</th>
                                    <th>Created on</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div> <!-- end card body-->
                </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>

        <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>


@endsection
