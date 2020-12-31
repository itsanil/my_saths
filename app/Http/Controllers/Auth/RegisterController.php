<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'contact' => 'nullable|numeric|digits:10',
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile' => ['required', 'numeric', 'digits:10', 'unique:users'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            // 'email' => $data['email'],
            'mobile' => $data['mobile'],
            // 'password' => Hash::make($data['password']),
        ]);

        $customer = new customer();
        $customer->name = $data['name'];
        $customer->user_id = $user->id;
        $customer->whatsapp_no = $data['mobile'];
        $customer->contact_no = $data['contact'];
        $customer->flat_no = $data['flat_no'];
        $customer->building_name = $data['select_building_name'];
        $customer->area_id = $data['area_id'];
        $customer->lane = $data['lane'];
        $customer->city = $data['city'];
        $customer->status = 0;
        $customer->save();
            

        $user->attachRole('customer');
        // echo "<pre>"; print_r(''); echo "</pre>"; die('end of code');
            // $this->WelcomeEmail('mail.sanchitsolutions.org','no-reply@sanchitsolutions.org','Qch9&-9cEEr8','ssl','465','sales@sanchitsolutions.net','no-reply@sanchitsolutions.org','Sanchit solutions',$data['email'],$data['receiver_name']);
        return $user;
    }
}
