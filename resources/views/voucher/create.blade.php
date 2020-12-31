@extends('layouts1.main')
@section('title', 'Add Voucher')
@section('section_page', 'Add Voucher')
@section('css')

@endsection
@section('js')


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
                    <form class="pl-3 pr-3" action="{{ route('voucher.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                        <div class="form-group">
                            <label for="username">Voucher Code</label>
                            <?php $code = array(); ?>
                            @foreach ($voucher_list as $key => $value)
                            <?php $code[] = $value->voucher_code; ?>
                            @endforeach
                            <?php 
                            //generate unique code
                                while (1 > 0) {
                                    $voucher_code = chr(rand(65,90)).chr(rand(65,90)).rand(1000,9999);
                                    if (in_array($voucher_code, $code)) {
                                        # code...
                                    } else {
                                        break;
                                    }
                                }
                            ?>
                            <input class="form-control" id="add_code" type="text" value="{{ $voucher_code }}" name="voucher_code" required="" placeholder="Enter Voucher Code">
                        </div>
                    
                    <div class="form-group">
                        <label for="username">Select Voucher Type</label>
                        <select name="type" class="form-control" required="">
                            <option value="">Select</option>
                            <option value="Flate">Flate</option>
                            <option value="Percentage">Percentage</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Voucher Type Value</label>
                        <input class="form-control" type="number" name="value" placeholder="Enter Voucher Type Value">
                    </div>
                    <div class="form-group">
                        <label for="username">Maximum Use Per Customer</label>
                        <input class="form-control" type="number" name="max_use" placeholder="Enter Voucher Maximum Use">
                    </div>
                    <div class="form-group">
                        <label for="username">Minimum Order Amt</label>
                        <input class="form-control" type="number" name="min_order_value" placeholder="Enter Minimum Order Amt">
                    </div>
                     <div class="form-group">
                        <label for="username">Start Date</label>
                        <input class="form-control" type="date" name="start_date" placeholder="Enter Satrt Date" required="">
                    </div>
                    <div class="form-group">
                        <label for="username">End Date</label>
                        <input class="form-control" type="date" name="end_date" placeholder="Enter End Date" required="">
                    </div>
                    <div class="form-group">
                        <label for="username">Select Status</label>
                        <select name="status"  class="form-control" required="">
                            <option value="Active">Active</option>
                            <option value="In-Active">In-Active</option>
                        </select>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
@endsection
