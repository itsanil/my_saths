@extends('backend.main')
@section('title', 'Payout Settings')
@section('section_page', 'Payout Settings')
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
.panel-info > .panel-heading {
    background-color: #33415d;
    border-color: #46B8DA;
    color: #fff;
}

.panel-info>.panel-heading {
    color: #31708f;
    background-color: #d9edf7;
    border-color: #bce8f1;
}

element.style {
}
.form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
.panel-info > .panel-heading {
    background-color: #33415d;
    border-color: #46B8DA;
    color: #fff;
}

.panel-heading {
    border-bottom: 1px dotted rgba(234, 238, 241, 0.2);
    border-color: #eaeef1;
    border-radius: 2px 2px 0 0;
    padding: 10px 15px;
    color: #333;
    font-size: 14px;
    font-weight: bold;
    background-color: #f9fafc;
}
.panel-heading {
    padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
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
    <h3>Account Setting</h3>
    <ul class="breadcrumb">
        <li>
            <a href="{{ url('/dashboard') }}">Dashboard</a>
        </li>
        <li class="active">/ Profile /</li>
        <li class="active">Payout Settings</li>
    </ul>
</div>

   <div class="wrapper">
    <div class="row">
                <div class="col-md-6">
            <div class="panel panel-info portlet-item" id="banktranfer">
                <header class="panel-heading">
                   Bank Transfer
                                   </header>
                <section class="panel-body">
                                        <div class="panel panel-success hidden" id="new_bank_panel">
    <div class="panel-heading">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse" class="pull-right"><i class="glyphicon glyphicon-chevron-up"></i></a>
      <!--   <h4 class="panel-title">Details</h4> -->
    </div>
    <div id="collapse" class="panel-body panel-collapse collapse in">
        <form action="https://onlinesensor.com/user/payout-settings/bank_transfer_update" method="post" class="bank_transferfrmad" id="form_" data-id="" novalidate="novalidate">
            <input type="hidden" name="payout_type_id" value="2">
            <input type="hidden" name="id" value="">
            <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="account_nickname">Handling Currency</label>
                <div class="col-sm-6">
                    <select name="currency_id" id="" class="form-control"><option value="">Select Currency</option><option value="1">USD</option><option value="2">INR</option><option value="3">IDR</option><option value="4">MYR</option><option value="5">SGD</option><option value="6">PHP</option><option value="7">BDT</option><option value="8">CNY</option><option value="9">EUR</option><option value="10">GBP</option><option value="11">AUD</option><option value="12">THB</option><option value="13">BTC</option><option value="22">DTC</option><option value="23">LTC</option><option value="24">XRP</option><option value="25">BCH</option><option value="26">ETC</option><option value="27">USDT</option><option value="28">XMR</option><option value="29">EOS</option><option value="30">IOTA</option><option value="31">ZEC</option><option value="32">NEO</option><option value="33">ETH</option><option value="34">IND</option></select>                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#form_ #currency_id').change(function () {
                        var currency_id = $(this).val();
                        $('#form_ #ifsccode').parents('.form-group').addClass('hidden');
                        if (currency_id ==2) {
                            $('#form_ #ifsccode').parents('.form-group').removeClass('hidden');
                        }
                    });
                });
            </script>
            <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="payout_account_type">Account Type</label>
                <div class="col-sm-6">
                    <select name="payout_account_type" id="payout_account_type" class="form-control"><option value="">Select a Account Type</option><option value="1">Savings</option><option value="2">Current</option></select>                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="nick_name">Nick Name</label>
                <div class="col-sm-6">
                    <input name="nick_name" class="form-control" type="text" id="nick_name" placeholder="Enter Nick Name" value="">
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="account_name">Account Holder Name</label>
                <div class="col-sm-6">
                                        <input name="account_name" class="form-control" type="text" id="account_name" placeholder="Enter Account Holder name" value="">
                                    </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="account_no">Account Number</label>
                <div class="col-sm-6">
                    <input name="account_no" class="form-control" type="text" id="account_no" placeholder="Enter Account Number" value="">
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="bank_name">Bank Name</label>
                <div class="col-sm-6">
                    <input name="bank_name" class="form-control" type="text" id="bank_name" placeholder="Enter Bank name" value="">
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="bank_branch">Bank Branch</label>
                <div class="col-sm-6">
                    <input name="bank_branch" class="form-control" type="text" id="bank_branch" placeholder="Enter bank branch" value="">
                </div>
            </div>
            <div class="form-group col-sm-12 //{(isset($currency_id) &amp;&amp; $currency_id==Config::get('constants.INR_CURRENCY_ID'))?'':'hidden'}}">
                <label class="col-sm-6 control-label" for="ifsccode">Bank/IFSC Code</label>
                <div class="col-sm-6">
                    <input name="ifsccode" class="form-control" type="text" id="ifsccode" placeholder="Enter Bank/IFSC Code " value="">
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="status">Status</label>
                <div class="col-sm-6">
                    <select name="status" id="status" class="form-control">
                        <option value="0">In-Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>
            </div>           
            <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="tpin">Security PIN *</label>
                <div class="col-sm-6">
                    <input type="password" name="tpin" id="form__tpin" class="form-control">
                    <span id="errmsg" class="help-block"></span>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="update">&nbsp;</label>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-success" value="1">Add Now</button>
                </div>
            </div>
        </form>
    </div>
</div>
<style type="text/css">
    .help-block{
        color:#f56954;
    }
</style>

                </section>
            </div>
        </div>
                        <div class="col-md-6">
            <div class="panel panel-info portlet-item">
                <header class="panel-heading">
                PayPal Payment
                </header>
                <section class="panel-body">
                    <form class="form" action="https://onlinesensor.com/user/payout-settings/paypal_update" method="post" id="paypal_form" name="paypal_form" autocomplete="off" onsubmit="return false;" novalidate="novalidate">
    <input type="hidden" name="payout_type_id" value="4">
    <div class="form-group col-sm-12">
        <label class="col-sm-6 control-label" for="account_nickname">Handling Currency</label>
        <div class="col-sm-6">
            <select name="currency_id" id="currency_id" class="form-control"><option value="1">USD</option></select>        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="col-sm-6 control-label" for="account_nickname">PayPal Account ID</label>
        <div class="col-sm-6">
            <input name="account_id" class="form-control" type="text" id="account_id" placeholder="Enter Account ID" value="">
        </div>
    </div>
     <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">Account Name</label>
        <div class="col-sm-6">
            <input name="account_name" class="form-control" type="text" id="account_name" placeholder="Enter Account Name" value="">
        </div>
    </div>
     <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="status">Status</label>
                <div class="col-sm-6">
                    <select name="status" id="status" class="form-control">
                        <option value="0">In-Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>
            </div>
    
     <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="tpin">Security PIN *</label>
        <div class="col-sm-6">
            <input type="password" name="tpin" id="paypal_form_tpin" class="form-control">
            <span id="errmsg" class="help-block"></span>
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="col-sm-6 control-label" for="account_nickname">&nbsp;</label>
        <div class="col-sm-6">
            <button type="submit" class="btn btn-success" value="1">Update Now</button>
        </div>
    </div>
    </form>
                </section>
            </div>
        </div>
                        <div class="col-md-6">
            <div class="panel panel-info portlet-item">
                <header class="panel-heading">
                        Perfect Money
                </header>
                <section class="panel-body">
                    <form class="form" action="https://onlinesensor.com/user/payout-settings/perfectmoney_update" method="post" id="perfectmoney_form" name="perfectmoney_form" autocomplete="off" onsubmit="return false;" novalidate="novalidate">
    <input type="hidden" name="payout_type_id" value="5">
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="currency_id">Handling Currency</label>
        <div class="col-sm-6">
            <select name="currency_id" id="currency_id" class="form-control"><option value="">Select Currency</option><option value="1">USD</option></select>        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">Perfect Money Account ID</label>
        <div class="col-sm-6">
            <input name="account_id" class="form-control" type="text" id="account_id" placeholder="Enter Account ID" value="">
            <span>Ex:U1234567</span>
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">Account Name</label>
        <div class="col-sm-6">
            <input name="account_name" class="form-control" type="text" id="account_name" placeholder="Enter Account Name" value="">
        </div>
    </div>
        <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="status">Status</label>
                <div class="col-sm-6">
                    <select name="status" id="status" class="form-control">
                        <option value="0">In-Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>
            </div>
     
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="tpin">Security PIN *</label>
        <div class="col-sm-6">
            <input type="password" name="tpin" id="perfectmoney_form_tpin" class="form-control">
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-4" for="account_nickname"></label>
        <div class="col-sm-8">
            <button type="submit" class="btn btn-success" value="1">Update Now</button>
        </div>
    </div>
</form>
                </section>
            </div>
        </div>
                        <div class="col-md-6">
            <div class="panel panel-info portlet-item">
                <header class="panel-heading">
                    Payza Payment
                </header>
                <section class="panel-body">
                    <form class="form" action="https://onlinesensor.com/user/payout-settings/payza_update" method="post" id="payza_form" name="payza_form" autocomplete="off" onsubmit="return false;" novalidate="novalidate">
    <input type="hidden" name="payout_type_id" value="3">
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="currency_id">Handling Currency</label>
        <div class="col-sm-6">
            <select name="currency_id" id="currency_id" class="form-control"><option value="">Select Currency</option><option value="1">USD</option></select>        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">Payza Account Email-ID</label>
        <div class="col-sm-6">
            <input name="account_id" class="form-control" type="text" id="account_id" placeholder="Enter Account ID" value="">
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">Account Name</label>
        <div class="col-sm-6">
            <input name="account_name" class="form-control" type="text" id="account_name" placeholder="Enter Account Name" value="">
        </div>
    </div>
       <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="status">Status</label>
                <div class="col-sm-6">
                    <select name="status" id="status" class="form-control">
                       <option value="0">In-Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>
            </div>
     
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="tpin">Security PIN *</label>
        <div class="col-sm-6">
            <input type="password" name="tpin" id="payza_form_tpin" class="form-control">
            <span id="errmsg" class="help-block"></span>
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-4" for="account_nickname"></label>
        <div class="col-sm-8">
            <button type="submit" class="btn btn-success" value="1">Update Now</button>
        </div>
    </div>
</form>
                </section>
            </div>
        </div>
                        <div class="col-md-6">
            <div class="panel panel-info portlet-item">
                <header class="panel-heading">
                   Skrill Payment
                </header>
                <section class="panel-body">
                    <form class="form" action="https://onlinesensor.com/user/payout-settings/skrill_update" method="post" id="skrill_form" name="skrill_form" autocomplete="off" onsubmit="return false;" novalidate="novalidate">
    <input type="hidden" name="payout_type_id" value="6">
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="currency_id">Handling Currency</label>
        <div class="col-sm-6">
            <select name="currency_id" id="currency_id" class="form-control"><option value="">Select Currency</option><option value="1">USD</option></select>        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">Skrill Account Email-ID</label>
        <div class="col-sm-6">
            <input name="account_id" class="form-control" type="text" id="account_id" placeholder="Enter Account ID" value="">
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">Account Name</label>
        <div class="col-sm-6">
            <input name="account_name" class="form-control" type="text" id="account_name" placeholder="Enter Account Name" value="">
        </div>
    </div>
     <div class="form-group col-sm-12">
               <label class="col-sm-6 control-label" for="status">Status</label>
                <div class="col-sm-6">
                    <select name="status" id="status" class="form-control">
                       <option value="0">In-Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>
            </div>
    
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="tpin">Security PIN *</label>
        <div class="col-sm-6">
            <input type="password" name="tpin" id="skrill_form_tpin" class="form-control">
            <span id="errmsg" class="help-block"></span>
        </div>
    </div>
    <div class="form-group col-sm-12 pull-right">
        <label class="control-label col-sm-4" for="account_nickname"></label>
        <div class="col-sm-8">
            <button type="submit" class="btn btn-success" value="1">Update Now</button>
        </div>
    </div>
</form>
                </section>
            </div>
        </div>
                        <div class="col-md-6">
            <div class="panel panel-info portlet-item">
                <header class="panel-heading">
            BKash Payment
                </header>
                <section class="panel-body">
                    <form class="form" action="https://onlinesensor.com/user/payout-settings/bkash_update" method="post" id="bkash_form" name="bkash_form" autocomplete="off" onsubmit="return false;" novalidate="novalidate">
    <input type="hidden" name="payout_type_id" value="7">
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="currency_id">Handling Currency</label>
        <div class="col-sm-6">
            <select name="currency_id" id="currency_id" class="form-control"><option value="">Select Currency</option><option value="7">BDT</option></select>        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">BKash Account Number</label>
        <div class="col-sm-6">
            <input name="account_id" class="form-control" type="text" id="account_id" placeholder="Enter Account Number" value="">
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">Account Name</label>
        <div class="col-sm-6">
            <input name="account_name" class="form-control" type="text" id="account_name" placeholder="Enter Account Name" value="">
        </div>
    </div>
     <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="status">Status</label>
                <div class="col-sm-6">
                    <select name="status" id="status" class="form-control">
                       <option value="0">In-Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>
            </div>
    
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="tpin">Security PIN *</label>
        <div class="col-sm-6">
            <input type="password" name="tpin" id="bkash_form_tpin" class="form-control">
            <span id="errmsg" class="help-block"></span>
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname"></label>
        <div class="col-sm-6">
            <button type="submit" class="btn btn-success" value="1">Update Now</button>
        </div>
    </div>
</form>
                </section>
            </div>
        </div>
                        <div class="col-md-6">
            <div class="panel panel-info portlet-item">
                <header class="panel-heading">
                     Solid Trust Payment
                </header>
                <section class="panel-body">
                    <form class="form" action="https://onlinesensor.com/user/payout-settings/solid_trust_pay_update" method="post" id="solid_trust_pay_form" name="solid_trust_pay_form" autocomplete="off" onsubmit="return false;" novalidate="novalidate">
    <input type="hidden" name="payout_type_id" value="8">
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="currency_id">Handling Currency</label>
        <div class="col-sm-6">
            <select name="currency_id" id="currency_id" class="form-control"><option value="">Select Currency</option><option value="1">USD</option></select>        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">Solid Trust Pay Account User Name</label>
        <div class="col-sm-6">
            <input name="account_id" class="form-control" type="text" id="account_id" placeholder="Enter Account User Name" value="">
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname">Account Name</label>
        <div class="col-sm-6">
            <input name="account_name" class="form-control" type="text" id="account_name" placeholder="Enter Account Name" value="">
        </div>
    </div>
    <div class="form-group col-sm-12">
                <label class="col-sm-6 control-label" for="status">Status</label>
                <div class="col-sm-6">
                    <select name="status" id="status" class="form-control">
                       <option value="0">In-Active</option>
                        <option value="1">Active</option>
                    </select>
                </div>
            </div>
    
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="tpin">Security PIN *</label>
        <div class="col-sm-6">
            <input type="password" name="tpin" id="solid_trust_pay_form_tpin" class="form-control">
            <span id="errmsg" class="help-block"></span>
        </div>
    </div>
    <div class="form-group col-sm-12">
        <label class="control-label col-sm-6" for="account_nickname"></label>
        <div class="col-sm-6">
            <button type="submit" class="btn btn-success" value="1">Update Now</button>
        </div>
    </div>
</form>
                </section>
            </div>
        </div>
            </div>
</div>
@endsection
