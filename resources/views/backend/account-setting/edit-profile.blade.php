@extends('backend.main')
@section('title', 'Edit Profile')
@section('section_page', 'Edit Profile')
@section('css')

<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  /*margin: 8px 0;*/
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}
h4 {
    color: #000;
    font-size: 13px;
    font-weight: bold;
}
input[type=checkbox], input[type=radio] {
    box-sizing: border-box;
    padding: 0;
}
.form-horizontal .form-group {
    border-bottom: 1px solid #f1f1f1;
    margin-left: -15px;
    margin-right: -15px;
    padding: 0 0 16px;
    margin-bottom: 10px;
    display: flex;
}
.form-horizontal .control-label {
    font-weight: bold;
    text-align: right;
}
@media (min-width: 1200px)
.col-lg-8 {
    width: 66.66666667%;
}

.form-control-static {
    margin-bottom: 0;
}
p {
    margin: 0 0 10px;
}
.panel{
    background-color: #fefffe !important;border: 4px solid #191f80 !important;margin-bottom: 20px;
}
.panel-body{
    padding: 12px 8px !important;
}
/*div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}*/
</style>
<!-- BEGIN PAGE VENDOR CSS-->
@endsection
@section('js')
<!-- DataTables -->
<script src="{{ asset('public/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script>
    $(function () {
        $("#example1").DataTable({
          "responsive": true,
          "autoWidth": false,
        });
    });
    function Edit(id,name,status){
        // alert(name);
        // var edit_url = 'campaign-category-update?id=/'+id;
          $("#edit_title").val(name);
          $("#edit_id").val(id);
          $("#edit_status").val(status);
          // $("#editform").attr('action',edit_url);
           // $('#editform').attr('action', edit_url);
          $("#edit-modal").modal("show");
    }

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


         <div class="page-heading">
    <h3>Edit Profile</h3>
    <ul class="breadcrumb">
        <li>
            <a href="{{ url('/dashboard') }}">Dashboard</a>
        </li>
        <li class="active">/ Profile /</li>
        <li class="active">Edit Profile</li>
    </ul>
</div>
      
<div class="row">
 <div class="wrapper">
    <div class="row">
        <div class="col-lg-8">
            <section class="panel" style="background-color: #fefffe !important;border: 4px solid #191f80 !important;margin-bottom: 20px;">
                <div class="panel-body" style="padding: 12px 8px !important;">
                                       
                    <div class="alert alert-success" style="display:none;">
                        <button data-dismiss="alert" class="close" type="button">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <span id="success_msg"></span>
                        <br>
                    </div>
                    <div class="alert alert-danger" style="display:none;">
                        <button data-dismiss="alert" class="close" type="button">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <span id="error_msg"></span>
                        <br>
                    </div>
                    <form method="post" class="form-horizontal" role="form" id="user_update" autocomplete="off" onsubmit="return false;" novalidate="novalidate">
                        <input type="hidden" id="district_name" value="TAHNE">
                        
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label">Signed up on:</label>
                            <div class="col-lg-8">
                                <p class="form-control-static">01-Aug-2016 02:45:42</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label">Username:</label>
                            <div class="col-lg-8">
                                <p class="form-control-static">mishika</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">Email Address:</label>
                            <div class="col-lg-8">
                                <p class="form-control-static">kiranyadav831983@gmail.com</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label">Your Inviter:</label>
                            <div class="col-lg-8">
                                <p class="form-control-static">Sambhav</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label">Inviter's Email address:</label>
                            <div class="col-lg-8">
                                <p class="form-control-static">Sambhavnp@gmail.com</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label">Promotion URL:</label>
                            <div class="col-lg-8">
                                <p class="form-control-static"><a class="btn btn-xs btn-link" href="https://onlinesensor.com/mishika">https://onlinesensor.com/mishika</a></p>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">Full Name:</label>
                            <div class="col-lg-8">
                                <input name="user[full_name]" class="form-control" type="text" id="full_name" value="KIRAN   YADAV " disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">Sex:</label>
                            <div class="col-lg-8">
                                <select name="user[sex]" class="form-control" id="sex" required="">
                                    <option value=""> Select Sex</option>
                                    <option value="1">Male</option>
                                    <option value="2" selected="selected">Female</option>
                                    <option value="3">Transgender</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">DOB:</label>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <select id="dob_year" name="dob_year" class="form-control" required=""><option value="">Select Year</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983" selected="selected">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option></select>
                                    </div>
                                    <div class="col-lg-4">
                                        <select id="dob_month" name="dob_month" class="form-control" required=""><option value="">Select Month</option><option value="1">Jan</option><option value="2">Feb</option><option value="3" selected="selected">Mar</option><option value="4">Apr</option><option value="5">May</option><option value="6">Jun</option><option value="7">Jul</option><option value="8">Aug</option><option value="9">Sept</option><option value="10">Oct</option><option value="11">Nov</option><option value="12">Dec</option></select>
                                    </div>
                                    <div class="col-lg-4">
                                        <select id="dob_day" name="dob_day" class="form-control" required=""><option value="">Select Day</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8" selected="selected">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>
                                    </div>
                                    <input type="hidden" id="dob" name="user[dob]" data-start_date="1911-01-03" data-end_date="2003-01-03" value="1983-03-08">
                                </div>
                                <div id="doberrors"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">Address:</label>
                            <div class="col-lg-8">
                                <textarea name="user[address]" class="form-control" type="text" id="address" style="width: 100%; height: 84px;">BADLAPUR</textarea>
                            </div>
                        </div>                 
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">Country:</label>
                            <div class="col-lg-8">
                                <select name="user[country]" id="country" class="form-control" style="height:40px;" disabled="">
                                    <option value="">Choose Your Country</option>
                                                                        <option value="1">Afghanistan</option>
                                                                        <option value="2">Albania</option>
                                                                        <option value="3">Algeria</option>
                                                                        <option value="4">Andorra</option>
                                                                        <option value="5">Angola</option>
                                                                        <option value="6">Antigua and barbuda</option>
                                                                        <option value="7">Argentina</option>
                                                                        <option value="8">Armenia</option>
                                                                        <option value="9">Australia</option>
                                                                        <option value="10">Austria</option>
                                                                        <option value="11">Azerbaijan</option>
                                                                        <option value="12">Bahrain</option>
                                                                        <option value="13">Bangladesh</option>
                                                                        <option value="14">Barbados</option>
                                                                        <option value="15">Belarus</option>
                                                                        <option value="16">Belgium</option>
                                                                        <option value="17">Belize</option>
                                                                        <option value="18">Benin</option>
                                                                        <option value="19">Bhutan</option>
                                                                        <option value="20">Bolivia</option>
                                                                        <option value="21">Bosnia and herzegovina</option>
                                                                        <option value="22">Botswana</option>
                                                                        <option value="23">Brazil</option>
                                                                        <option value="24">Brunei</option>
                                                                        <option value="25">Bulgaria</option>
                                                                        <option value="26">Burkina faso</option>
                                                                        <option value="27">Burma/Myanmar</option>
                                                                        <option value="28">Burundi</option>
                                                                        <option value="29">Cambodia</option>
                                                                        <option value="30">Cameroon</option>
                                                                        <option value="31">Canada</option>
                                                                        <option value="32">Cape verde</option>
                                                                        <option value="33">Central african republic</option>
                                                                        <option value="34">Chad</option>
                                                                        <option value="35">Chile</option>
                                                                        <option value="36">China</option>
                                                                        <option value="37">Colombia</option>
                                                                        <option value="38">Comores</option>
                                                                        <option value="41">Costa rica</option>
                                                                        <option value="42">Cote d ivoire</option>
                                                                        <option value="43">Croatia</option>
                                                                        <option value="44">Cuba</option>
                                                                        <option value="45">Cyprus</option>
                                                                        <option value="46">Czech republic</option>
                                                                        <option value="40">Democratic Republic of the Congo</option>
                                                                        <option value="47">Denmark</option>
                                                                        <option value="48">Djibouti</option>
                                                                        <option value="49">Dominica</option>
                                                                        <option value="50">Dominican republic</option>
                                                                        <option value="51">East Timor</option>
                                                                        <option value="52">Ecuador</option>
                                                                        <option value="53">Egypt</option>
                                                                        <option value="54">El salvador</option>
                                                                        <option value="55">Equatorial guinea</option>
                                                                        <option value="56">Eritrea</option>
                                                                        <option value="57">Estonia</option>
                                                                        <option value="58">Ethiopia</option>
                                                                        <option value="59">Fiji</option>
                                                                        <option value="60">Finland</option>
                                                                        <option value="61">France</option>
                                                                        <option value="62">Gabon</option>
                                                                        <option value="63">Gambia</option>
                                                                        <option value="64">Georgia</option>
                                                                        <option value="65">Germany</option>
                                                                        <option value="66">Ghana</option>
                                                                        <option value="67">Greece</option>
                                                                        <option value="68">Grenada</option>
                                                                        <option value="69">Guatemala</option>
                                                                        <option value="70">Guinea</option>
                                                                        <option value="71">Guinea-bissau</option>
                                                                        <option value="72">Guyana</option>
                                                                        <option value="73">Haiti</option>
                                                                        <option value="74">Honduras</option>
                                                                        <option value="194">Hong Kong</option>
                                                                        <option value="75">Hungary</option>
                                                                        <option value="76">Iceland</option>
                                                                        <option value="77" selected="selected">India</option>
                                                                        <option value="78">Indonesia</option>
                                                                        <option value="79">Iran</option>
                                                                        <option value="80">Iraq</option>
                                                                        <option value="81">Ireland</option>
                                                                        <option value="82">Israel</option>
                                                                        <option value="83">Italy</option>
                                                                        <option value="84">Jamaica</option>
                                                                        <option value="85">Japan</option>
                                                                        <option value="86">Jordan</option>
                                                                        <option value="87">Kazakhstan</option>
                                                                        <option value="88">Kenya</option>
                                                                        <option value="89">Kiribati</option>
                                                                        <option value="90">Kuwait</option>
                                                                        <option value="91">Kyrgyzstan</option>
                                                                        <option value="92">Laos</option>
                                                                        <option value="93">Latvia</option>
                                                                        <option value="94">Lebanon</option>
                                                                        <option value="95">Lesotho</option>
                                                                        <option value="96">Liberia</option>
                                                                        <option value="97">Libya</option>
                                                                        <option value="98">Liechtenstein</option>
                                                                        <option value="99">Lithuania</option>
                                                                        <option value="100">Luxembourg</option>
                                                                        <option value="101">Macedonia</option>
                                                                        <option value="102">Madagascar</option>
                                                                        <option value="103">Malawi</option>
                                                                        <option value="104">Malaysia</option>
                                                                        <option value="105">Maldives</option>
                                                                        <option value="106">Mali</option>
                                                                        <option value="107">Malta</option>
                                                                        <option value="108">Marshall islands</option>
                                                                        <option value="109">Mauritania</option>
                                                                        <option value="110">Mauritius</option>
                                                                        <option value="111">Mexico</option>
                                                                        <option value="112">Micronesia</option>
                                                                        <option value="113">Moldova</option>
                                                                        <option value="114">Monaco</option>
                                                                        <option value="115">Mongolia</option>
                                                                        <option value="116">Morocco</option>
                                                                        <option value="117">Mozambique</option>
                                                                        <option value="118">Namibia</option>
                                                                        <option value="119">Nauru</option>
                                                                        <option value="120">Nepal</option>
                                                                        <option value="121">Netherlands</option>
                                                                        <option value="122">New zealand</option>
                                                                        <option value="123">Nicaragua</option>
                                                                        <option value="124">Niger</option>
                                                                        <option value="125">Nigeria</option>
                                                                        <option value="126">North korea</option>
                                                                        <option value="127">Norway</option>
                                                                        <option value="128">Oman</option>
                                                                        <option value="129">Pakistan</option>
                                                                        <option value="130">Palau</option>
                                                                        <option value="131">Panama</option>
                                                                        <option value="132">Papua new guinea</option>
                                                                        <option value="133">Paraguay</option>
                                                                        <option value="134">Peru</option>
                                                                        <option value="135">Philippines</option>
                                                                        <option value="136">Poland</option>
                                                                        <option value="137">Portugal</option>
                                                                        <option value="138">Qatar</option>
                                                                        <option value="39">Republic of the Congo</option>
                                                                        <option value="139">Romania</option>
                                                                        <option value="140">Russia</option>
                                                                        <option value="141">Rwanda</option>
                                                                        <option value="142">Saint kitts and nevis</option>
                                                                        <option value="143">Saint lucia</option>
                                                                        <option value="144">Saint vincent and the grenadines</option>
                                                                        <option value="145">Samoa</option>
                                                                        <option value="146">San marino</option>
                                                                        <option value="147">Sao tome and principe</option>
                                                                        <option value="148">Saudi arabia</option>
                                                                        <option value="149">Senegal</option>
                                                                        <option value="150">Seychelles</option>
                                                                        <option value="151">Sierra leone</option>
                                                                        <option value="152">Singapore</option>
                                                                        <option value="153">Slovakia</option>
                                                                        <option value="154">Slovenia</option>
                                                                        <option value="155">Solomon islands</option>
                                                                        <option value="156">Somalia</option>
                                                                        <option value="157">South africa</option>
                                                                        <option value="158">South korea</option>
                                                                        <option value="159">Spain</option>
                                                                        <option value="160">Sri lanka</option>
                                                                        <option value="161">Sudan</option>
                                                                        <option value="162">Suriname</option>
                                                                        <option value="163">Swaziland</option>
                                                                        <option value="164">Sweden</option>
                                                                        <option value="165">Switzerland</option>
                                                                        <option value="166">Syria</option>
                                                                        <option value="167">Taiwan</option>
                                                                        <option value="168">Tajikistan</option>
                                                                        <option value="169">Tanzania</option>
                                                                        <option value="170">Thailand</option>
                                                                        <option value="171">The bahamas</option>
                                                                        <option value="172">Togo</option>
                                                                        <option value="173">Tonga</option>
                                                                        <option value="174">Trinidad and tobago</option>
                                                                        <option value="175">Tunisia</option>
                                                                        <option value="176">Turkey</option>
                                                                        <option value="177">Turkmenistan</option>
                                                                        <option value="178">Tuvalu</option>
                                                                        <option value="179">Uganda</option>
                                                                        <option value="180">Ukraine</option>
                                                                        <option value="181">United arab emirates</option>
                                                                        <option value="182">United kingdom</option>
                                                                        <option value="183">United states</option>
                                                                        <option value="184">Uruguay</option>
                                                                        <option value="185">Uzbekistan</option>
                                                                        <option value="186">Vanuatu</option>
                                                                        <option value="187">Vatican city</option>
                                                                        <option value="188">Venezuela</option>
                                                                        <option value="189">Vietnam</option>
                                                                        <option value="190">Yemen</option>
                                                                        <option value="191">Yugoslavia/Serbia And Montenegro</option>
                                                                        <option value="192">Zambia</option>
                                                                        <option value="193">Zimbabwe</option>
                                                                    </select>
                                <span class="validation errorcntry"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="state">State:</label>
                            <div class="col-lg-8">
                                <select name="user[state]" class="form-control" id="state" data-urlval="https://onlinesensor.com/get_district">
                                    <option value="">---Select State---</option>
                                                                                                           
                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                                                       
                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                                       
                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                                       
                                    <option value="Assam">Assam</option>
                                                                       
                                    <option value="Bihar">Bihar</option>
                                                                       
                                    <option value="Chandigarh">Chandigarh</option>
                                                                       
                                    <option value="Chhatisgarh">Chhatisgarh</option>
                                                                       
                                    <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                                                                       
                                    <option value="Daman and Diu">Daman and Diu</option>
                                                                       
                                    <option value="Delhi">Delhi</option>
                                                                       
                                    <option value="Goa">Goa</option>
                                                                       
                                    <option value="Gujarat">Gujarat</option>
                                                                       
                                    <option value="Haryana">Haryana</option>
                                                                       
                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                                       
                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                                       
                                    <option value="Jharkhand">Jharkhand</option>
                                                                       
                                    <option value="Karnataka">Karnataka</option>
                                                                       
                                    <option value="Kerala">Kerala</option>
                                                                       
                                    <option value="Lakshadweep">Lakshadweep</option>
                                                                       
                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                                       
                                    <option value="Maharashtra" selected="selected">Maharashtra</option>
                                                                       
                                    <option value="Manipur">Manipur</option>
                                                                       
                                    <option value="Meghalaya">Meghalaya</option>
                                                                       
                                    <option value="Mizoram">Mizoram</option>
                                                                       
                                    <option value="Nagaland">Nagaland</option>
                                                                       
                                    <option value="Odisha">Odisha</option>
                                                                       
                                    <option value="Puducherry">Puducherry</option>
                                                                       
                                    <option value="Punjab">Punjab</option>
                                                                       
                                    <option value="Rajasthan">Rajasthan</option>
                                                                       
                                    <option value="Sikkim">Sikkim</option>
                                                                       
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                                       
                                    <option value="Telangana">Telangana</option>
                                                                       
                                    <option value="Tripura">Tripura</option>
                                                                       
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                                       
                                    <option value="Uttarakhand">Uttarakhand</option>
                                                                       
                                    <option value="West Bengal">West Bengal</option>
                                                                                                        </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">District:</label>
                            <div class="col-lg-8">
                            <select required="" id="district" name="user[district]" class="form-control" data-urlval="https://onlinesensor.com/get_city">
                                <option value="">--Select District--</option>
                                                                                                           
                                    <option value="Ahmednagar">Ahmednagar</option>
                                                                       
                                    <option value="Akola">Akola</option>
                                                                       
                                    <option value="Amravati">Amravati</option>
                                                                       
                                    <option value="AMRAVTI">AMRAVTI</option>
                                                                       
                                    <option value="Aurangabad">Aurangabad</option>
                                                                       
                                    <option value="Beed">Beed</option>
                                                                       
                                    <option value="Bhandara">Bhandara</option>
                                                                       
                                    <option value="Buldhana">Buldhana</option>
                                                                       
                                    <option value="Chandrapur">Chandrapur</option>
                                                                       
                                    <option value="Dhule">Dhule</option>
                                                                       
                                    <option value="Gadchiroli">Gadchiroli</option>
                                                                       
                                    <option value="Gondia">Gondia</option>
                                                                       
                                    <option value="Hingoli">Hingoli</option>
                                                                       
                                    <option value="Jalgaon">Jalgaon</option>
                                                                       
                                    <option value="Jalna">Jalna</option>
                                                                       
                                    <option value="Kolhapur">Kolhapur</option>
                                                                       
                                    <option value="Latur">Latur</option>
                                                                       
                                    <option value="MUMBAI">MUMBAI</option>
                                                                       
                                    <option value="Mumbai City">Mumbai City</option>
                                                                       
                                    <option value="Mumbai Suburban">Mumbai Suburban</option>
                                                                       
                                    <option value="Nagpur">Nagpur</option>
                                                                       
                                    <option value="Nanded">Nanded</option>
                                                                       
                                    <option value="Nandurbar">Nandurbar</option>
                                                                       
                                    <option value="Nashik">Nashik</option>
                                                                       
                                    <option value="Osmanabad">Osmanabad</option>
                                                                       
                                    <option value="Palghar">Palghar</option>
                                                                       
                                    <option value="Parbhani">Parbhani</option>
                                                                       
                                    <option value="Pune">Pune</option>
                                                                       
                                    <option value="Raigad">Raigad</option>
                                                                       
                                    <option value="Ratnagiri">Ratnagiri</option>
                                                                       
                                    <option value="Sangli">Sangli</option>
                                                                       
                                    <option value="Satara">Satara</option>
                                                                       
                                    <option value="Sindhudurg">Sindhudurg</option>
                                                                       
                                    <option value="Solapur">Solapur</option>
                                                                       
                                    <option value="Thane">Thane</option>
                                                                       
                                    <option value="Wardha">Wardha</option>
                                                                       
                                    <option value="Washim">Washim</option>
                                                                       
                                    <option value="Yavatmal">Yavatmal</option>
                                                                        <option value="others">Others</option>
                                                                </select>
                            <input type="text" required="" onkeypress="return alpha_checkwithspace(event)" name="district_others" class="form-control" id="district_others" style="display:none;">
                                                           </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">City:</label>
                            <div class="col-lg-8">
                                <input name="user[city]" class="form-control" type="text" id="city" value="BADLAPUR">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">Postal Code:</label>
                            <div class="col-lg-8">
                                <input name="user[zipcode]" class="form-control" type="text" id="zipcode" value="421503">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">ISD Code:</label>
                            <div class="col-lg-8">
                                <select name="user[phonecode]" class="form-control" id="phonecode" disabled="">
                                    <option value="">--Select PhoneCode--</option>
                                                                                                            <option id="c_1" value="+93">+93</option>
                                                                        <option id="c_2" value="+355">+355</option>
                                                                        <option id="c_3" value="+213">+213</option>
                                                                        <option id="c_4" value="+376">+376</option>
                                                                        <option id="c_5" value="+244">+244</option>
                                                                        <option id="c_6" value="+1268">+1268</option>
                                                                        <option id="c_7" value="+54">+54</option>
                                                                        <option id="c_8" value="+374">+374</option>
                                                                        <option id="c_9" value="+61">+61</option>
                                                                        <option id="c_10" value="+43">+43</option>
                                                                        <option id="c_11" value="+994">+994</option>
                                                                        <option id="c_12" value="+973">+973</option>
                                                                        <option id="c_13" value="+880">+880</option>
                                                                        <option id="c_14" value="+1">+1</option>
                                                                        <option id="c_15" value="+375">+375</option>
                                                                        <option id="c_16" value="+32">+32</option>
                                                                        <option id="c_17" value="+501">+501</option>
                                                                        <option id="c_18" value="+229">+229</option>
                                                                        <option id="c_19" value="+975">+975</option>
                                                                        <option id="c_20" value="+591">+591</option>
                                                                        <option id="c_21" value="+387">+387</option>
                                                                        <option id="c_22" value="+267">+267</option>
                                                                        <option id="c_23" value="+55">+55</option>
                                                                        <option id="c_24" value="+673">+673</option>
                                                                        <option id="c_25" value="+359">+359</option>
                                                                        <option id="c_26" value="+226">+226</option>
                                                                        <option id="c_27" value="+95">+95</option>
                                                                        <option id="c_28" value="+257">+257</option>
                                                                        <option id="c_29" value="+855">+855</option>
                                                                        <option id="c_30" value="+237">+237</option>
                                                                        <option id="c_31" value="+1">+1</option>
                                                                        <option id="c_32" value="+238">+238</option>
                                                                        <option id="c_33" value="+236">+236</option>
                                                                        <option id="c_34" value="+235">+235</option>
                                                                        <option id="c_35" value="+56">+56</option>
                                                                        <option id="c_36" value="+86">+86</option>
                                                                        <option id="c_37" value="+855">+855</option>
                                                                        <option id="c_38" value="+269">+269</option>
                                                                        <option id="c_41" value="+506">+506</option>
                                                                        <option id="c_42" value="+225">+225</option>
                                                                        <option id="c_43" value="+385">+385</option>
                                                                        <option id="c_44" value="+53">+53</option>
                                                                        <option id="c_45" value="+357">+357</option>
                                                                        <option id="c_46" value="+420">+420</option>
                                                                        <option id="c_40" value="+243">+243</option>
                                                                        <option id="c_47" value="+45">+45</option>
                                                                        <option id="c_48" value="+253">+253</option>
                                                                        <option id="c_49" value="+1767">+1767</option>
                                                                        <option id="c_50" value="+1">+1</option>
                                                                        <option id="c_51" value="+670">+670</option>
                                                                        <option id="c_52" value="+593">+593</option>
                                                                        <option id="c_53" value="+20">+20</option>
                                                                        <option id="c_54" value="+503">+503</option>
                                                                        <option id="c_55" value="+240">+240</option>
                                                                        <option id="c_56" value="+291">+291</option>
                                                                        <option id="c_57" value="+372">+372</option>
                                                                        <option id="c_58" value="+251">+251</option>
                                                                        <option id="c_59" value="+679">+679</option>
                                                                        <option id="c_60" value="+358">+358</option>
                                                                        <option id="c_61" value="+33">+33</option>
                                                                        <option id="c_62" value="+241">+241</option>
                                                                        <option id="c_63" value="+220">+220</option>
                                                                        <option id="c_64" value="+995">+995</option>
                                                                        <option id="c_65" value="+49">+49</option>
                                                                        <option id="c_66" value="+233">+233</option>
                                                                        <option id="c_67" value="+30">+30</option>
                                                                        <option id="c_68" value="+1473">+1473</option>
                                                                        <option id="c_69" value="+502">+502</option>
                                                                        <option id="c_70" value="+224">+224</option>
                                                                        <option id="c_71" value="+245">+245</option>
                                                                        <option id="c_72" value="+592">+592</option>
                                                                        <option id="c_73" value="+509">+509</option>
                                                                        <option id="c_74" value="+504">+504</option>
                                                                        <option id="c_194" value="+852">+852</option>
                                                                        <option id="c_75" value="+36">+36</option>
                                                                        <option id="c_76" value="+354">+354</option>
                                                                        <option id="c_77" value="+91" selected="selected">+91</option>
                                                                        <option id="c_78" value="+62">+62</option>
                                                                        <option id="c_79" value="+98">+98</option>
                                                                        <option id="c_80" value="+964">+964</option>
                                                                        <option id="c_81" value="+353">+353</option>
                                                                        <option id="c_82" value="+972">+972</option>
                                                                        <option id="c_83" value="+39">+39</option>
                                                                        <option id="c_84" value="+1876">+1876</option>
                                                                        <option id="c_85" value="+81">+81</option>
                                                                        <option id="c_86" value="+962">+962</option>
                                                                        <option id="c_87" value="+7">+7</option>
                                                                        <option id="c_88" value="+254">+254</option>
                                                                        <option id="c_89" value="+686">+686</option>
                                                                        <option id="c_90" value="+965">+965</option>
                                                                        <option id="c_91" value="+996">+996</option>
                                                                        <option id="c_92" value="+856">+856</option>
                                                                        <option id="c_93" value="+371">+371</option>
                                                                        <option id="c_94" value="+961">+961</option>
                                                                        <option id="c_95" value="+266">+266</option>
                                                                        <option id="c_96" value="+231">+231</option>
                                                                        <option id="c_97" value="+218">+218</option>
                                                                        <option id="c_98" value="+423">+423</option>
                                                                        <option id="c_99" value="+370">+370</option>
                                                                        <option id="c_100" value="+352">+352</option>
                                                                        <option id="c_101" value="+389">+389</option>
                                                                        <option id="c_102" value="+261">+261</option>
                                                                        <option id="c_103" value="+265">+265</option>
                                                                        <option id="c_104" value="+60">+60</option>
                                                                        <option id="c_105" value="+960">+960</option>
                                                                        <option id="c_106" value="+223">+223</option>
                                                                        <option id="c_107" value="+356">+356</option>
                                                                        <option id="c_108" value="+692">+692</option>
                                                                        <option id="c_109" value="+222">+222</option>
                                                                        <option id="c_110" value="+230">+230</option>
                                                                        <option id="c_111" value="+52">+52</option>
                                                                        <option id="c_112" value="+691">+691</option>
                                                                        <option id="c_113" value="+373">+373</option>
                                                                        <option id="c_114" value="+377">+377</option>
                                                                        <option id="c_115" value="+976">+976</option>
                                                                        <option id="c_116" value="+212">+212</option>
                                                                        <option id="c_117" value="+258">+258</option>
                                                                        <option id="c_118" value="+264">+264</option>
                                                                        <option id="c_119" value="+674">+674</option>
                                                                        <option id="c_120" value="+977">+977</option>
                                                                        <option id="c_121" value="+31">+31</option>
                                                                        <option id="c_122" value="+64">+64</option>
                                                                        <option id="c_123" value="+505">+505</option>
                                                                        <option id="c_124" value="+227">+227</option>
                                                                        <option id="c_125" value="+234">+234</option>
                                                                        <option id="c_126" value="+850">+850</option>
                                                                        <option id="c_127" value="+47">+47</option>
                                                                        <option id="c_128" value="+968">+968</option>
                                                                        <option id="c_129" value="+92">+92</option>
                                                                        <option id="c_130" value="+680">+680</option>
                                                                        <option id="c_131" value="+507">+507</option>
                                                                        <option id="c_132" value="+675">+675</option>
                                                                        <option id="c_133" value="+595">+595</option>
                                                                        <option id="c_134" value="+51">+51</option>
                                                                        <option id="c_135" value="+63">+63</option>
                                                                        <option id="c_136" value="+48">+48</option>
                                                                        <option id="c_137" value="+351">+351</option>
                                                                        <option id="c_138" value="+974">+974</option>
                                                                        <option id="c_39" value="+242">+242</option>
                                                                        <option id="c_139" value="+40">+40</option>
                                                                        <option id="c_140" value="+7">+7</option>
                                                                        <option id="c_141" value="+250">+250</option>
                                                                        <option id="c_142" value="+1">+1</option>
                                                                        <option id="c_143" value="+1">+1</option>
                                                                        <option id="c_144" value="+1">+1</option>
                                                                        <option id="c_145" value="+685">+685</option>
                                                                        <option id="c_146" value="+378">+378</option>
                                                                        <option id="c_147" value="+239">+239</option>
                                                                        <option id="c_148" value="+966">+966</option>
                                                                        <option id="c_149" value="+221">+221</option>
                                                                        <option id="c_150" value="+248">+248</option>
                                                                        <option id="c_151" value="+232">+232</option>
                                                                        <option id="c_152" value="+65">+65</option>
                                                                        <option id="c_153" value="+421">+421</option>
                                                                        <option id="c_154" value="+386">+386</option>
                                                                        <option id="c_155" value="+677">+677</option>
                                                                        <option id="c_156" value="+252">+252</option>
                                                                        <option id="c_157" value="+27">+27</option>
                                                                        <option id="c_158" value="+82">+82</option>
                                                                        <option id="c_159" value="+34">+34</option>
                                                                        <option id="c_160" value="+94">+94</option>
                                                                        <option id="c_161" value="+249">+249</option>
                                                                        <option id="c_162" value="+597">+597</option>
                                                                        <option id="c_163" value="+268">+268</option>
                                                                        <option id="c_164" value="+46">+46</option>
                                                                        <option id="c_165" value="+41">+41</option>
                                                                        <option id="c_166" value="+963">+963</option>
                                                                        <option id="c_167" value="+886">+886</option>
                                                                        <option id="c_168" value="+992">+992</option>
                                                                        <option id="c_169" value="+255">+255</option>
                                                                        <option id="c_170" value="+66">+66</option>
                                                                        <option id="c_171" value="+1">+1</option>
                                                                        <option id="c_172" value="+228">+228</option>
                                                                        <option id="c_173" value="+676">+676</option>
                                                                        <option id="c_174" value="+1">+1</option>
                                                                        <option id="c_175" value="+216">+216</option>
                                                                        <option id="c_176" value="+90">+90</option>
                                                                        <option id="c_177" value="+993">+993</option>
                                                                        <option id="c_178" value="+688">+688</option>
                                                                        <option id="c_179" value="+256">+256</option>
                                                                        <option id="c_180" value="+380">+380</option>
                                                                        <option id="c_181" value="+971">+971</option>
                                                                        <option id="c_182" value="+44">+44</option>
                                                                        <option id="c_183" value="+1">+1</option>
                                                                        <option id="c_184" value="+598">+598</option>
                                                                        <option id="c_185" value="+998">+998</option>
                                                                        <option id="c_186" value="+678">+678</option>
                                                                        <option id="c_187" value="+379">+379</option>
                                                                        <option id="c_188" value="+58">+58</option>
                                                                        <option id="c_189" value="+84">+84</option>
                                                                        <option id="c_190" value="+967">+967</option>
                                                                        <option id="c_191" value="+381">+381</option>
                                                                        <option id="c_192" value="+260">+260</option>
                                                                        <option id="c_193" value="+263">+263</option>
                                                                                                        </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">Mobile No:</label>
                            <div class="col-lg-8">
                                <input name="user[mobile]" class="form-control" type="text" maxlength="10" id="mobile" value="7410153442" disabled="disabled">
                                <span id="errmsg" class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="example-text-input">My Campaign Category:</label>
                            <div class="col-lg-8">
                                <select class="form-control" name="user[project]" id="project" disabled="">
                                    <option value=""></option>
                                                                                                            <option value="1">Adoption
</option>
                                                                        <option value="2">Animals
</option>
                                                                        <option value="3">Art
</option>
                                                                        <option value="8" selected="">Organizations</option>
                                                                        <option value="9">Community
</option>
                                                                        <option value="11">Creative Projects
</option>
                                                                        <option value="12">Dance
</option>
                                                                        <option value="15">Develop a Software</option>
                                                                        <option value="16">Education
</option>
                                                                        <option value="17">Emergencies
</option>
                                                                        <option value="18">Events
</option>
                                                                        <option value="19">Family
</option>
                                                                        <option value="20">Fashion
</option>
                                                                        <option value="21">Film/Video
</option>
                                                                        <option value="22">Food
</option>
                                                                        <option value="29">Holidays
</option>
                                                                        <option value="30">Medical &amp; Health
</option>
                                                                        <option value="31">Memorials &amp; Funerals
</option>
                                                                        <option value="32">Military &amp; Veterans
</option>
                                                                        <option value="34">Nonprofits &amp; Charity
</option>
                                                                        <option value="35">Pets
</option>
                                                                        <option value="37">Publish a Book
</option>
                                                                        <option value="39">Run/Walk/Rides
</option>
                                                                        <option value="41">Sports
</option>
                                                                        <option value="45">Trip</option>
                                                                                                        </select>
                                <span id="errmsg" class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                           <label class="col-lg-4 col-sm-2 control-label" for="skype_id">Skype ID:</label>
                            <div class="col-lg-8">
                                <input name="user[skype_id]" class="form-control" type="text" maxlength="100" id="skype_id" value="">
                                <span id="errmsg" class="help-block"></span>
                            </div>
                        </div>
                         <div class="form-group">
                             <label class="col-lg-4 col-sm-2 control-label" for="skype_id"></label>
                            <div class="col-lg-12">
                                <p>
                                    <input type="checkbox" name="user[anonymous]" id="user[anonymous]" value="1" style="float:left;margin: 6px 2px;"><span style="float:left;">Hide my name, comment from everyone and contribute anonymously</span>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="pan_no">PAN No:</label>
                            <div class="col-lg-8">
                                <input name="user[pan_no]" class="form-control" type="text" disabled="disabled" id="pan_no" value="AEFPY0133D">
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-lg-12" style="margin-left: 11px;">
                                <h4 style="font-size: 16px;font-weight: 800;">Reward Based Contributions (Coming Soon)</h4>
                                <input type="checkbox" class="simple" name="rewards" value="1" id="project_rewards">
                                <span style="font-size: 15px;font-style: italic;">I agree to be a part of the OnlineSensor Reward Fixed Amount Fundraising option and also agree to spend 2/3rd of the funds raised, towards giving rewards to the contributors. I give this right to the company to use 2/3rd of the funds raised by me towards providing rewards to the contributors from any of the third parties associated with the company, as per the terms and policies.</span> 
                               
                                <span id="project_rewards_err" class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 col-sm-2 control-label" for="tpin">Security PIN *</label>
                            <div class="col-lg-8">
                                <input type="password" name="tpin" id="tpin" class="form-control">
                                <span id="errmsg" class="help-block">(To save changes, you must enter your personal pin here)</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-4 col-lg-8">
                                <button name="update" type="submit" id="update" class="btn btn-success">Save Account Information</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
</div>

@endsection
