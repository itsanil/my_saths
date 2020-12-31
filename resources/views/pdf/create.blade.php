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
  if(currentTab == 1){
    k = 0;
     for (i = 0; i < y.length; i++) {
        if (i%5 == 1) {
          readURL(y[i],(i - 4*k)-1);
          k += 1;
      }

    }
  }


  
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


    if(currentTab == 3){
      if(currentTab == 3 && z[0].value == "" || y[0].value == ""){
        z[0].className += " invalid";
        y[0].className += " invalid";
        // and set the current valid status to false
        valid = false;
  }
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
        if(currentTab == 2 && i == 2){
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
       
      if(currentTab == 0 && (y[i].value.length > 10 || y[i].value.length < 10) ){
        toastr.error('Enter Valid Mobile Number');
        valid = false;
      }
      if(currentTab == 1  ){
        // alert(y.length);
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
<script type="text/javascript">
$(document).ready(function(){
    var maxField = 500; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
     
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            var fieldHTML = '<div class="row">\
                        <div class="col-md-1">\
                          <div class="form-group">\
                             <a href="javascript:void(0);" style="border: none;background-color: #f4f6f9;" class="remove_button form-control" title="Add field"><img src="{{ asset('public/images/remove-icon.png') }}"/></a>\
                          </div>\
                        </div>\
                        <div class="col-md-1">\
                          <div class="form-group">\
                            <input type="number" min="1" placeholder="sr no" value="'+x+'" class="form-control" name="product_order[]" required="">\
                          </div>\
                        </div>\
                        <div class="col-md-2">\
                          <div class="form-group">\
                            <input type="file" class="form-control imgInp" name="product_photo[]" required="">\
                          </div>\
                        </div>\
                        <div class="col-md-4">\
                          <div class="form-group">\
                            <input type="text" class="form-control" placeholder="Ex: Papad - 400g" name="product_name[]" required="">\
                          </div>\
                        </div>\
                        <div class="col-md-2">\
                          <div class="form-group">\
                            <input type="text" class="form-control" placeholder="Ex. Rs  xxx/-" name="product_price[]" required="">\
                          </div>\
                        </div>\
                        <div class="col-md-2">\
                          <div class="form-group">\
                            <input type="number" placeholder="" class="form-control"  name="product_mrp_price[]" required="">\
                          </div>\
                        </div>\
                    </div>'; //New input field html
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove(); //Remove field html
        // x--; //Decrement field counter
    });
});

// $(".imgInp").change(function() {
//   alert('anil');
//   readURL(this);
// });

function readURL(input,product_index) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
    
      $('#store_photo').append('<li><input type="checkbox" id="cb'+product_index+'" value="'+product_index+'" name="store_photo[]" />\
        <label for="cb'+product_index+'"><img src="'+e.target.result+'" /></label>\
      </li>\
      ');
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}
</script>
@endsection
@section('content')
<div class="row">
  <div class="card-body">
    <form id="regForm"  action="{{ route('online-pdf.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
      <!--<h1 style="text-align: center;  ">PDF Store</h1>-->
      <!-- One "tab" for each step in the form: -->
      <div class="tab"><h3 style="text-align: center;">Enter Your WhatsApp Number on which you want to receive the order:</h3>
        <p><input type="number" maxlength="10" placeholder="WhatsApp Number..." oninput="this.className = ''" name="whatsapp_num"></p>
      </div>
      <div class="tab">
        <div style="overflow:auto;">
           <div >
              <h4  style="float:left;">Add Product Details:<br/><code>Add minimum 4 products and multiple of 9 products for best view of your pdf.</code></h4>
            </div>
        </div>
        <?php $c = 1; ?>
        @foreach ($product_list as $key => $value) 

        @if($key == 0)
          <input type="hidden" placeholder="Ex: Papad - 400g"  value="{{ $value->id }}" name="product_id[]" required="">
          <div class="field_wrapper">
            <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="password">Order:</label>
                    <input type="number" min="1" placeholder="sr no"  class="form-control" value="{{ $c }}" name="product_order[]" required="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group text-center">
                    <label for="password">Product Name - Quantity Packaging:</label><br/>
                    <input type="hidden" placeholder="Ex: Papad - 400g"  value="{{ $value->name }}" name="product_name[]" required="">
                    <span class="text-center">{{ $value->name }}</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group text-center">
                    <label for="password">Product Price:</label><br/>
                    <input type="hidden" placeholder="Ex. Rs  xxx/-"  value="{{ $value->sale_price }}" name="product_price[]" required="">
                    <span class="text-center">{{ $value->sale_price }}</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group text-center">
                    <label for="password">MRP Price:</label><br/>
                    <input type="hidden" value="{{ $value->mrp }}"  name="product_mrp_price[]" required="">
                    <span class="text-center">{{ $value->mrp }}</span>
                  </div>
                </div>
            </div>
          </div>
        @else
          <input type="hidden" placeholder="Ex: Papad - 400g"  value="{{ $value->id }}" name="product_id[]" required="">
          <div class="field_wrapper">
            <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <input type="number" min="1" placeholder="sr no"  class="form-control" value="{{ $c }}" name="product_order[]" required="">
                  </div>
                </div>
                <div class="col-md-6 text-center">
                  <div class="form-group">
                    <input type="hidden" placeholder="Ex: Papad - 400g"  value="{{ $value->name }}" name="product_name[]" required="">
                    <span for="password">{{ $value->name }}</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group text-center">
                    <input type="hidden" placeholder="Ex. Rs  xxx/-"  value="{{ $value->sale_price }}" name="product_price[]" required="">
                    <span for="password">{{ $value->sale_price }}</span>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group text-center">
                    <input type="hidden" value="{{ $value->mrp }}"  name="product_mrp_price[]" required="">
                    <span for="password">{{ $value->mrp }}</span>
                  </div>
                </div>
            </div>
          </div>
        @endif
        <?php $c ++; ?>
        @endforeach
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
        data-html="true" title="this is Your page title field"></p>
        <p><input placeholder="Store Contact Number..." oninput="this.className = ''" name="store_phone" data-toggle="tooltip"
        data-html="true" title="This will be visible on all the end of all pages."></p>
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
        data-html="true" title="This is optional, background image needs to be of 800 x 1107 size">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="password">Page Backround Color:</label>
                  <input type="color" class="form-control" name="background_color" value="#FFFFFF" data-toggle="tooltip"
        data-html="true" title="This is optional, background color visible on all pages.">
                </div>
              </div>
        </div>
      </div>
      <div class="tab"><h3 style="text-align: center;">Configure Start Page:</h3>
        <p><input placeholder="Enter Store Sub-title..." oninput="this.className = ''" name="sub_title"></p>
        <div style="overflow:auto;">
          <div >
            <h5  style="float:left;">Select Showcase Images [Either 4,8 or 12]:</h5>
          </div>
        </div>
        <ul id="store_photo" style=" list-style-type: none;">
          @foreach ($product_list as $key => $value) 
              <li style="display: inline-block;"><input type="checkbox" id="cb{{ $key }}" class="store_img" value="{{ $value->img }}" name="store_photo[]" />
                <label for="cb{{ $key }}"><img src="{{ url('storage/'.$value->img) }}" /></label>
              </li>
          @endforeach
        </ul>
        <h5 >Enter Store Description:</h5>
        <p><textarea placeholder="Enter Store Description in short and one line to show on first page..." class="textarea form-control" name="store_description"></textarea required=""></p>
      </div>
      <div class="tab"><h3 style="text-align: center;">Configure Store End Page:</h3>
        <h5 >Enter Offer Details:</h5>
        <p><textarea placeholder="Enter Offer Details ..." class="textarea form-control" name="offer_details" required=""></textarea></p>
        <h5 >Enter  delivery charges details:</h5>
        <p><textarea placeholder="Enter delivery charges details..." class="textarea form-control" name="delivery_charge" required=""></textarea></p>
        <p><input placeholder="Enter delivery time details..." oninput="this.className = ''" class="form-control" name="delivery_time" required=""></p>
        <h5 >Enter Pickup Address:</h5>
        <p><textarea placeholder="Enter Pickup Address..." class="textarea form-control" name="delivery_address" required=""></textarea></p>
        <p><input placeholder="Enter holiday day..." oninput="this.className = ''" name="delivery_holiday"></p>
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