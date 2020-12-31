 $(function () {
    //Initialize Select2 Elements
    var price = '';
    var available_qty = '';
    $('.select2').select2();
    $('#price_type').on('change',function(){
        var product_id_array = $("input[name='product_id[]']").map(function(){return $(this).val();}).get();
        var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
        $('#order_amount').val('');
        price = '';
        available_qty = '';
        var product_array = $('#product_select2').val();
        if($('#price_type').val() == 'Sale Price'){
                 var price_type = 3;
            }else{
                var price_type = 2;
            }
        var product_html = '';
        $.each(product_array, function( index, value ) {
                if(index != 0){
                    price += ',';
                    available_qty += ',';
                }
                var data = (value).split(',');
                price += data[price_type];
                available_qty += data[4];
                if (price_type == 3) {
                    var product_price = data[3];
                } else {
                    var product_price = data[2]
                }
                var order_product_qty = '';
                $.each(product_id_array, function( key, values ) {
                    if(data[0] == values){
                        order_product_qty = product_qty_array[key];
                    }
                });
                product_html += '<div class="row">\
                <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="" >\
                    <div class="col-md-3">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Product Name :</label>\
                            <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="" ><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                    </div>\
                    <div class="col-md-3">\
                        <div class="form-group text-center"><label for="exampleInputEmail1">Price :</label>\
                            <h5  >'+product_price+'</h5></div>\
                    </div>\
                    <div class="col-md-3">\
                    <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Available Qty</label>\
                            <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly=""><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                        </div>\
                    <div class="col-md-3">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Enter Product Qty</label>\
                            <input type="text" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" required="" value="'+order_product_qty+'">\
                        </div>\
                    </div>\
                </div>';
        });
        $('#product_html').html(product_html);
        
    });
    $('#product_select2').on('change',function(){
        var product_id_array = $("input[name='product_id[]']").map(function(){return $(this).val();}).get();
        var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
        $('#order_amount').val('');
        price = '';
        available_qty = '';
        var product_array = $('#product_select2').val();
        if($('#price_type').val() == 'Sale Price'){
                 var price_type = 3;
            }else{
                var price_type = 2;
            }
        var product_html = '';
        $.each(product_array, function( index, value ) {
                if(index != 0){
                    price += ',';
                    available_qty += ',';
                }
                var data = (value).split(',');
                price += data[price_type];
                available_qty += data[4];
                if (price_type == 3) {
                    var product_price = data[3];
                } else {
                    var product_price = data[2];
                }
                var order_product_qty = '';
                $.each(product_id_array, function( key, values ) {
                    if(data[0] == values){
                        order_product_qty = product_qty_array[key];
                    }
                });
                product_html += '<div class="row">\
                <input type="hidden" class="form-control" name="product_id[]" id="exampleInputEmail1" value="'+data[0]+'" readonly="" >\
                    <div class="col-md-3">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Product Name :</label>\
                            <input type="hidden" class="form-control" name="product_name[]" id="exampleInputEmail1" value="'+data[1]+'" readonly="" ><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                    </div>\
                    <div class="col-md-3">\
                        <div class="form-group text-center"><label for="exampleInputEmail1">Price :</label>\
                            <h5  >'+product_price+'</h5></div>\
                    </div>\
                    <div class="col-md-3">\
                    <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Available Qty</label>\
                            <input type="hidden" class="form-control" name="available_qty[]" id="exampleInputEmail1" value="'+data[4]+'" readonly=""><h5 class="" >&nbsp;'+data[1]+'</h5>\
                        </div>\
                        </div>\
                    <div class="col-md-3">\
                        <div class="form-group text-center">\
                            <label for="exampleInputEmail1">Enter Product Qty</label>\
                            <input type="text" class="form-control order_qty" name="product_qty[]" id="exampleInputEmail1" placeholder="Enter Product Qty" required="" value="'+order_product_qty+'">\
                        </div>\
                    </div>\
                </div>';
        });
        $('#product_html').html(product_html);
        
    });
        $('#cal_order_amount').on('click',function(){
            var status = true;
            var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
            var available_qty_array = $("input[name='available_qty[]']").map(function(){return $(this).val();}).get();
            $.each(product_qty_array, function( index, value ) {
                    if(parseInt(value) > parseInt(available_qty_array[index])){
                        toastr.error('Order quantity can not be greater than available quantity');
                        status = false;
                        return false; 
                    }
            });
            $('#order_amount').val('');
            var price_array = (price).split(',');
            var available_qty_array = (available_qty).split(',');
            // console.log(price_array);
            var order_amount = 0;
            if($('#product_qty').val() == ''){
                $('#order_amount').val('');
            }
            if($('#product_qty').val() != ''){
                var product_qty_array = $("input[name='product_qty[]']").map(function(){return $(this).val();}).get();
                $.each(product_qty_array, function( index, value ) {
                    if(value != ''){
                       order_amount += price_array[index]*value; 
                    }else{
                        toastr.error('fill quantity corresponding to product');
                        status = false;
                        return false;
                    }
                });
                if(status == true){
                    if($('#delivery_amount').val() && $('#discount_amount').val()){
                        $('#order_amount').val(order_amount+parseInt($('#delivery_amount').val()) - parseInt($('#discount_amount').val()));
                    }else{
                        toastr.error('please fill all Amount field');
                        // status = false;
                        return false;
                    }
                    
                }
            }
        });


    });