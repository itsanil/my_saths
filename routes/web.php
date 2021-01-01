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
        //user
    
});




Route::group(['middleware' => 'role:user|admin'], function() {
    Route::get('/dashboard',function(){
        return view('backend.dashboard');
    });

    Route::get('/login',function(){
        return redirect('/dashboard');
    });
    
});


Route::group(['middleware' => 'role:user'], function() {
    
});













