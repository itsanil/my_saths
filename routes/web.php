<?php

use App\CampaignCategory;




Route::get('/',function(){
    $category = CampaignCategory::where('status','Active')->get();
    return view('frontend.main',compact('category'));
});

Route::get('/how_it_work',function(){
    return view('frontend.how_it_work');
});

Route::get('/campaign',function(){
    return view('frontend.campaign');
});
Route::get('/explore',function(){
    return view('frontend.explore');
});


Route::get('/real-estate-and-business-crowdfunding',function(){
    return view('frontend.real-estate-and-business-crowdfunding');
});

Route::get('/fundresingcost',function(){
    return view('frontend.fundresingcost');
});
Route::get('/fundraisingideas',function(){
    return view('frontend.fundraisingideas');
});
Route::get('/terms',function(){
    return view('frontend.terms');
});
Route::get('/policy_and_procedure',function(){
    return view('frontend.policy_and_procedure');
});
Route::get('/what-is-crowdfunding',function(){
    return view('frontend.what-is-crowdfunding');
});
Route::get('/work_with_us',function(){
    return view('frontend.work_with_us');
});
Route::get('/partner_with_us',function(){
    return view('frontend.partner_with_us');
});
Route::get('/pricing',function(){
    return view('frontend.pricing');
});
Route::get('/faq',function(){
    return view('frontend.faq');
});
Route::get('/guidelines',function(){
    return view('frontend.guidelines');
});
Route::get('/report',function(){
    return view('frontend.report');
});
Route::get('/promotion',function(){
    return view('frontend.promotion');
});
Route::get('/projectrules',function(){
    return view('frontend.projectrules');
});
Route::get('/trust_and_safety',function(){
    return view('frontend.trust_and_safety');
});
Route::get('/mediacontact',function(){
    return view('frontend.mediacontact');
});

Route::get('/contact',function(){
    return view('frontend.contact');
});



Route::get('/campaign-view/{id}', 'CampaignController@campaignview')->name('campaign-view');

Route::get('/contribute-now/{id}', 'CampaignController@contributenow')->name('contribute-now');

Route::get('/campaign-list', 'CampaignController@campaignlist')->name('campaign-list');








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

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');

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

// Route::get('/login', function () {
//     return redirect('/');
// })->name('login');

Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'role:admin'], function() {
        Route::resource('campaigns','CampaignController');
        Route::resource('campaign-category','CampaignCategoryController');

        Route::post('campaign-category-update', [
          'as' => 'campaign-category-update',
          'uses' => 'CampaignCategoryController@categoryupdate'
        ]);
        //account
        Route::resource('account-setting','AccountSettingController');
        Route::get('/edit-profile', 'AccountSettingController@editProfile')->name('edit-profile');
        Route::get('/view-profile', 'AccountSettingController@viewProfile')->name('view-profile');
        Route::get('/change-password', 'AccountSettingController@changePassword')->name('change-password');
         Route::get('/change-mobile-or-email', 'AccountSettingController@changeMobileEmail')->name('change-mobile-or-email');
          Route::get('/change-security-password', 'AccountSettingController@changeSecurityPassword')->name('change-security-password');
          Route::get('/payout-settings', 'AccountSettingController@payoutSettings')->name('payout-settings');
          Route::get('/show-verification', 'AccountSettingController@showVerification')->name('show-verification');
          Route::post('/getUserPin', 'AccountSettingController@getUserPin')->name('getUserPin');
          Route::post('/updateProfile', 'AccountSettingController@updateProfile')->name('updateProfile');
         
    
});




Route::group(['middleware' => 'role:user|admin'], function() {
    Route::get('/dashboard',function(){
        return view('backend.dashboard');
    });

    Route::get('/home',function(){
        return redirect('/dashboard');
    });
    
});


Route::group(['middleware' => 'role:user'], function() {
    
});













