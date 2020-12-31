<?php




Route::get('/',function(){
    return view('frontend.main');
});

Route::get('/how_it_work',function(){
    return view('frontend.how_it_work');
});

Route::get('/campaign',function(){
    return view('frontend.campaign');
});

Route::get('/about',function(){
    return view('frontend.about');
});




Route::post('/auth/register', ['as' => 'auth.register', 'uses' => 'MainController@Register']);
Route::post('/auth/validate', ['as' => 'auth.validate', 'uses' => 'MainController@ValidateUser']);


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    // return what you want
});

Route::get('/view-cache', function() {
    $exitCode = Artisan::call('view:clear');
    // return what you want
});

Route::get('/migrate', function() {
    $exitCode = Artisan::call('migrate');
    // return what you want
});

Route::get('login-cms', 'Auth\LoginController@showLoginForm');

Route::post('login', [
  'as' => '',
  'uses' => 'Auth\LoginController@login'
]);
Route::post('logout', [
  'as' => 'logout',
  'uses' => 'Auth\LoginController@logout'
]);

// Password Reset Routes...
Route::post('password/email', [
  'as' => 'password.email',
  'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
  'as' => 'password.request',
  'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
  'as' => 'password.update',
  'uses' => 'Auth\ResetPasswordController@reset'
]);

Route::post('pwd/reset', [
  'as' => 'pwd.update',
  'uses' => 'HomeController@reset'
]);


Route::get('password/reset/{token}', [
  'as' => 'password.reset',
  'uses' => 'Auth\ResetPasswordController@showResetForm'
]);

// Registration Routes...
Route::get('register', [
  'as' => 'register',
  'uses' => 'Auth\RegisterController@showRegistrationForm'
]);

Route::post('get_state', [
  'as' => 'get_state',
  'uses' => 'MainController@getstate'
]);



Route::post('register', [
  'as' => '',
  'uses' => 'Auth\RegisterController@register'
]);
// Auth::routes();

Route::get('/contact-us', function () {
  $brand_list = Brand::all();
    return view('contact',compact('brand_list'));
});

Route::get('/login', function () {
    return redirect('/');
})->name('login');

Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'role:admin'], function() {
        //user
    Route::resource('role','UserController');
    // Route::get('/teacher-delete', 'TeacherController@destroy');
    Route::post('/role-edit', 'UserController@update')->name('role.edit');

    Route::post('/get_dashboard_data', 'StockController@getDashboardData')->name('get_dashboard_data');

    Route::get('/stock-worth-report', ['as' => 'stock-worth-report', 'uses' => 'ReportController@stockworthReport']);

    Route::resource('area','AreaController');
    Route::post('/update-area', 'AreaController@update');

    Route::resource('brand','BrandController');
    Route::post('/update-brand', 'BrandController@update');

    Route::resource('products','ProductMasterController');
    Route::post('/update-products', 'ProductMasterController@update');

    Route::resource('customer','CustomerController');
    Route::get('/customer-delete', 'CustomerController@destroy');
    Route::get('/customer/order-list/{id}', 'CustomerController@customerOrderList');
    

    Route::resource('distributer','ProductSourceController');
    Route::post('/update-distributer', 'ProductSourceController@update');
    Route::get('/distributer-delete', 'ProductSourceController@destroy');

    Route::resource('purchase','ProductsController');
    Route::get('/purchase-delete', 'ProductsController@delete');

    Route::resource('return-stock','ReturnStockController');
    Route::post('/update-return-stock', 'ReturnStockController@update');
    Route::get('/stock-log', 'ReturnStockController@stocklog');


    Route::resource('payment-options','PaymentTypeController');
    Route::post('/update-payment-options', 'PaymentTypeController@update');
    
    Route::resource('inventory','StockController');
    Route::get('/sales', 'StockController@report');

    


    Route::get('/sales-discount', 'ReportController@discountReport');

    Route::get('/order_search', 'ReportController@orderSearch');
    Route::post('/order-search/data', ['as' => 'order-search.data', 'uses' => 'ReportController@orderSearchData']);

    Route::get('/sales-building', 'ReportController@buildingreport');
    Route::post('/building-sales/data', ['as' => 'building-sales.data', 'uses' => 'ReportController@buildingData']);

    Route::post('/get_report_data', 'ReportController@getreportData')->name('get_report_data');
    Route::post('/get_purchase_report_data', 'ReportController@getPurchasereportData')->name('get_purchase_report_data');

    Route::get('/sales-product-price', 'ReportController@productPricereport');
    Route::post('/get_product_price_data', 'ReportController@ProductPriceData')->name('get_product_price_data');

    Route::get('/distributor-report', 'ReportController@distributerReport');
    Route::post('get_distributor_data', ['as' => 'get_distributor_data', 'uses' => 'ReportController@distributerData']);
    Route::get('/distributor-report/{id}', 'ReportController@getDistributerData');

    Route::get('/stock-in-worth', 'ReportController@stockInWorth');


    Route::resource('customer-orders','OrderController');

    Route::resource('tag','TagController');
    Route::post('/update-tag', 'TagController@update');
    
    
    Route::get('/order/customer', 'OrderController@orderCustomer');
    // Route::get('/order/order-list', 'OrderController@OrderList');

    // Route::get('/sales', 'OrderController@sale');

    Route::resource('online-pdf','PdfController');

    Route::resource('manage-home','HomeProductController');
    Route::post('/update-manage-home', 'HomeProductController@update');

    Route::resource('refund','RefundController');
    Route::post('/refund/data', ['as' => 'refund.data', 'uses' => 'RefundController@data']);
    Route::post('/refund/order', ['as' => 'refund.order', 'uses' => 'RefundController@orderdata']);
    Route::post('/refund/product', ['as' => 'refund.product', 'uses' => 'RefundController@refundproduct']);
    Route::get('/refund-delete', 'RefundController@destroy');

    Route::post('/stock/data', ['as' => 'stock-report.data', 'uses' => 'StockController@data']);
    Route::post('/sales/data', ['as' => 'sales-report.data', 'uses' => 'OrderController@data']);
    
    Route::post('/product/data', ['as' => 'product.data', 'uses' => 'ProductsController@data']);
    Route::post('/customer/data', ['as' => 'customer.data', 'uses' => 'CustomerController@data']);

    
    
    Route::post('/customer/Customerdata', ['as' => 'customer.Customerdata', 'uses' => 'CustomerController@Customerdata']);
    Route::post('/source/data', ['as' => 'Product-source.data', 'uses' => 'ProductSourceController@data']);

    Route::resource('promotions','PromotionController');
    Route::post('/update-promotions', 'PromotionController@update');

    Route::get('/change-password', 'HomeController@changepswd');

    Route::resource('sms','SmsController');
    Route::post('/sms/data', ['as' => 'sms.data', 'uses' => 'SmsController@data']);

    Route::get('/customer-wishlist', 'WishlistController@view');
    Route::post('/get_wishlist_data', 'WishlistController@getData')->name('get_wishlist_data');

    Route::resource('voucher','VoucherController');

    Route::get('manage-sgp','ProductsController@sgp');
    Route::post('/sgp/store', ['as' => 'sgp.store', 'uses' => 'ProductsController@sgpstore']);

    Route::resource('products-combo','ProductComboController');

});


Route::get('/getinvoice', 'AreaController@getinvoice');


Route::group(['middleware' => 'role:customer|admin'], function() {
    Route::post('/order/data', ['as' => 'order.data', 'uses' => 'OrderController@orderdata']);
    Route::get('/customer-orders/details/{id}', ['as' => 'customer-orders.details', 'uses' => 'OrderController@orderdetails']);
    Route::get('/customer-orders-delete', 'OrderController@destroy');
    Route::resource('wishlist','WishlistController');
    Route::post('/validate_voucher', 'VoucherController@validateVoucher')->name('validate_voucher');
    Route::post('/validate_edit_voucher', 'VoucherController@validateVoucher')->name('validate_edit_voucher');
});

Route::get('/my-order/create', ['as' => 'my-order.create', 'uses' => 'OrderController@create']);

Route::group(['middleware' => 'role:customer'], function() {
    Route::get('/my-order', 'CustomerController@MyOrder');
    
    Route::post('/my-order/store', ['as' => 'my-order.store', 'uses' => 'OrderController@store']);
    Route::post('/my-order/update', ['as' => 'my-order.update', 'uses' => 'OrderController@update']);
    // Route::get('/my-order/edit/{id}', ['as' => 'my-order.edit', 'uses' => 'OrderController@edit']);
});













