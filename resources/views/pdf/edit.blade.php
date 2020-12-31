@extends('layouts1.main')
@section('title', 'Edit PDF')
@section('section_page', 'Edit PDF')
@section('css')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.css') }}">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style>

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}



li {
  display: inline-block;
}

input[type="checkbox"][id^="cb"] {
  display: none;
}

label {
  border: 1px solid #fff;
  padding: 10px;
  display: block;
  position: relative;
  margin: 10px;
  cursor: pointer;
}

label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid grey;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

label img {
  height: 100px;
  width: 100px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
}

:checked + label {
  border-color: #ddd;
}

:checked + label:before {
  content: "✓";
  background-color: grey;
  transform: scale(1);
}

:checked + label img {
  transform: scale(0.9);
  box-shadow: 0 0 5px #333;
  z-index: -1;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}
</style>
@endsection
@section('js')
<script src="{{ asset('public/adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
  $('.product-photo').hide();
  $('.product-add').hide();
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  //show product imge on store form
  

  
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  z = x[currentTab].getElementsByTagName("textarea");

    // If a field is empty...
    

    if(currentTab == 3){
      if(currentTab == 3 && z[0].value == "" || y[0].value == ""){
        z[0].className += " invalid";
        y[0].className += " invalid";
        // and set the current valid status to false
        valid = false;
  }
      // alert(document.getElementsByName("store_photo[]").length);
    switch(document.querySelectorAll('.store_img:checked').length) {
      case 4:
        break;
      case 8:
        break;
      case 12:
         break;
      default:
        toastr.error('Select a pair of 4/8/12 pics for your storefront showcase screen');
        valid = false;
          break;
    }
  }
  // A loop that checks every input field in the current tab:
  // alert(y.length);
  for (i = 0; i < y.length; i++) {
   
    // If a field is empty...
    if(currentTab == 2){
        if(currentTab == 2 && i > 1){
         // y[i].className += " valid";
        // and set the current valid status to false
        // valid = true;
      }else{

          if (y[i].value == "") {
          // add an "invalid" class to the field:
          y[i].className += " invalid";
          // and set the current valid status to false
          valid = false;
        }
      }
    }else{
       if(currentTab == 1 && i % 5 == 4 || i % 5 == 1){
           // y[i].className += " valid";
          // and set the current valid status to false
          // valid = true;
      }else{
          if (currentTab == 1 && y[i].value == "") {
          // add an "invalid" class to the field:
          y[i].className += " invalid";
          // and set the current valid status to false
          valid = false;
        }
      }
      if(currentTab == 0 && (y[i].value.length > 10 || y[i].value.length < 10) ){
        toastr.error('Enter Valid Mobile Number');
        valid = false;
      }
      if(currentTab == 1  ){
        var total_order = y.length/5;
        var dupicate_order_counter = 0;
        var order_no = $("input[name='product_order[]']").map(function(){return $(this).val();}).get();
        // alert(order_no);
        const s = new Set(order_no);
        if (order_no.length !== s.size) {
          dupicate_order_counter ++;
        } 
        $.each(order_no, function( index, value ) {
        // alert(value);
        // alert(y[index*5].value);
        //   var order_value = y[index*5].value;
           for (a = 1; a <= total_order; a++) {
              if (value == a) {
                dupicate_order_counter ++;
              }
           }
                    
        });
       
      }
    }
    

   

  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  if (valid == false) {
    toastr.error('Please Enter All The Required Field');
  }
  if(dupicate_order_counter > total_order || dupicate_order_counter == 0 || dupicate_order_counter < total_order ){
            toastr.error('Order no is invalid');
            valid = false;
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>
@endsection
@section('content')
<div class="row">
      <div class="card-body">
        <form id="regForm" action="{{ route('online-pdf.update',$pdfData->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="pdf_id" value="{{ $pdfData->id }}">
          <!--<h1 style="text-align: center;">PDF Store</h1>-->
          <!-- One "tab" for each step in the form: -->
          <div class="tab"><h3 style="text-align: center;">Enter Your WhatsApp Number on which you want to receive the order:</h3>
            <p><input type="number" maxlength="10" placeholder="WhatsApp Number..." oninput="this.className = ''" name="whatsapp_num" value="{{ $pdfData->whatsapp_no }}"></p>
          </div>
          <div class="tab">
            <div style="overflow:auto;">
              <div >
                <h4  style="float:left;">Add Product Details:<br/><code>Add minimum 4 products and multiple of 9 products for best view of your pdf.</code></h4>
              </div>
            </div>
            <div class="field_wrapper">
              <?php $product_key = 0;  ?>
              @foreach ($product->order as $key => $order)
                <?php  foreach ($product->order as $keys => $values) {
                      if($product_key == $values-1){
                          $final_key = $keys;
                      }
               }
               ?>
               @foreach ($product->product_list as $keyss => $productss)
                  @if($productss->id == $product->product_id[$key])
                    <?php 
                      $final_key = $keyss;
                     ?>
                  @endif
               @endforeach
               @if($key == 0)
                <input type="hidden" placeholder="Ex: Papad - 400g"  value="{{ $product->product_list[$final_key]->id }}" name="product_id[]" required="">
                       <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="password">Order:</label>
                              <input type="text" min="1" placeholder="sr no" value="{{ $key+1 }}" class="form-control" name="product_order[]" required="">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group text-center">
                              <label for="password">Product Name - Quantity Packaging:</label><br/>
                              <input type="hidden" class="form-control" placeholder="Ex: Papad - 400g" name="product_name[]" value="{{ $product->product_list[$final_key]->name }}" required="">
                              <span>{{ $product->product_list[$final_key]->name }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group text-center">
                              <label for="password">Product Price:</label><br/>
                              <input type="hidden" placeholder="Ex: Rs xxx/-" class="form-control" name="product_price[]" value="{{ $product->product_list[$final_key]->sale_price }}" required="">
                              <span>{{ $product->product_list[$final_key]->sale_price }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group text-center">
                              <label for="password">MRP Price:</label><br/>
                              <input type="hidden" placeholder="" class="form-control"  name="product_mrp_price[]" value="{{ $product->product_list[$final_key]->mrp }}" required="">
                              <span>{{ $product->product_list[$final_key]->mrp }}</span>
                            </div>
                          </div>
                      </div> 
                @else
                    <input type="hidden" placeholder="Ex: Papad - 400g"  value="{{ $product->product_list[$final_key]->id }}" name="product_id[]" required="">
                     <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <input type="text" min="1" placeholder="sr no" value="{{ $key+1 }}" class="form-control" name="product_order[]" required="">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group text-center">
                              <input type="hidden" class="form-control" placeholder="Ex: Papad - 400g" name="product_name[]" value="{{ $product->product_list[$final_key]->name }}" required="">
                              <span>{{ $product->product_list[$final_key]->name }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group text-center">
                              <input type="hidden" placeholder="Ex: Rs xxx/-" class="form-control" name="product_price[]" value="{{ $product->product_list[$final_key]->sale_price }}" required="">
                              <span>{{ $product->product_list[$final_key]->sale_price }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group text-center">
                              <input type="hidden" placeholder="" class="form-control"  name="product_mrp_price[]" value="{{ $product->product_list[$final_key]->mrp }}" required="">
                              <span>{{ $product->product_list[$final_key]->mrp }}</span>
                            </div>
                          </div>
                      </div> 
                @endif
                <?php $product_key ++; ?>
              @endforeach
            </div>
          </div>
          <div class="tab"><h3 style="text-align: center;">Configure your PDF Store:</h3>
            <div class="card bg-gradient-warning">
                        <div class="card-header">
                          <h3 class="card-title">Notice:</h3>
                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                            </button>
                          </div>
                          <!-- /.card-tools -->
                        </div>
                        <div class="card-body">
                          <ul>
                            <li>background image is optional and image needs to be of 800 x 1107 size.</li><br/>
                            <li>background color is optional and this is visible on all pages</li>
                          </ul>
                        </div>
                        <!-- /.card-body -->
            </div>
            <p><input placeholder="Enter store name..." oninput="this.className = ''" name="store_name" data-toggle="tooltip"
            data-html="true" title="this is Your page title field" value="{{ $pdfData->store_name }}"></p>
            <p><input placeholder="Store Contact Number..." oninput="this.className = ''" name="store_phone" data-toggle="tooltip"
            data-html="true" title="This will be visible on all the end of all pages." value="{{ $pdfData->contact_no }}" ></p>
            <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="password">Sample Backround Photo:</label><br>
                      <a class="btn btn-primary btn-sm" target="_blank" style="color:#ffff;" href="{{ asset('public/images/home_banner.jpg') }}">
                          <i class="fas fa-folder">
                          </i>
                          View Sample Backround Photo
                      </a>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="password">Page Backround Photo:</label><br>
                      <input type="file" name="background_photo" id="background_image" data-toggle="tooltip"
            data-html="true" title="This is optional, background image needs to be of xx size" value="{{ $pdfData->background_photo }}" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password">Page Backround Color:</label>
                      <input type="color" class="form-control" name="background_color" value="{{ $pdfData->background_color }}" data-toggle="tooltip"
            data-html="true" title="This is optional, background color visible on all pages.">
                    </div>
                  </div>
            </div>
          </div>
          <div class="tab"><h3 style="text-align: center;">Configure Start Page:</h3>
            <h5 >Enter Store Sub-title:</h5>
            <p><input placeholder="Enter Store Sub-title..." oninput="this.className = ''" name="sub_title" value="{{ $pdfData->sub_title }}"></p>
            <div style="overflow:auto;">
              <div >
                <h5 >Select Showcase Images [Either 4,8 or 12]:</h5>
              </div>
            </div>
            <ul id="store_photo" style="list-style-type: none;">
              @foreach ($product->product_list as $key => $value)
              <li style="display: inline-block;"><input type="checkbox" id="cb{{ $key }}" class="store_img" value="{{ $value->img }}" name="store_photo[]" />
                <label for="cb{{ $key }}"><img src="{{ url('storage/'.$value->img) }}" /></label>
              </li>
              @endforeach
            </ul>
            <h5 >Enter Store Description:</h5>
            <p><textarea required=""  placeholder="Enter Store Description in short and one line to show on first page..." class="textarea form-control" name="store_description">{{ $pdfData->store_description }}</textarea ></p>
          </div>
          <div class="tab"><h3 style="text-align: center;">Configure Store End Page:</h3>
            <p><h6>Enter Offer Details:</h6></p>
            <p><textarea placeholder="Enter Offer Details ..." class="textarea form-control" name="offer_details" required="">{{ $pdfData->offer_details }}</textarea></p>
            <p><h6>Enter delivery charges details:</h6></p>
            <p><textarea placeholder="Enter delivery charges details..." style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" class="textarea form-control" name="delivery_charge" required="">{{ $pdfData->delivery_charge }}</textarea></p>
            <h6 >Enter delivery time details:</h6>
            <p><input placeholder="Enter delivery time details..." oninput="this.className = ''" class="form-control" name="delivery_time" required="" value="{{ $pdfData->delivery_time }}" ></p>
            <h6 >Enter Pickup Address:</h6>
            <p><textarea placeholder="Enter Pickup Address..." class="form-control" name="delivery_address" required="">{{ $pdfData->delivery_address }}</textarea></p>
            <h6 >Enter holiday details:</h6>
            <p><input placeholder="Enter holiday day..." oninput="this.className = ''" name="delivery_holiday" value="{{ $pdfData->delivery_holiday }}" ></p>
          </div>
          <div style="overflow:auto;">
            <div style="float:right;">
              <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
              <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
            </div>
          </div>
          <!-- Circles which indicates the steps of the form: -->
          <div style="text-align:center;margin-top:40px;">
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
            <span class="step"></span>
          </div>
        </form>
      </div>
</div>
@endsection