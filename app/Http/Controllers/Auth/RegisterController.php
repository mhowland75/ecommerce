<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use App\Mail\NewUserMail;
use Auth;
use Session;
use DB;
use Carbon\Carbon;

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
    protected $redirectTo = '/home';

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'online'=> '1',
            
        ]);

    }
    protected function registered(\Illuminate\Http\Request $request, $user) {
      // if the user has added items to there basket registering will change the temp id to the user id.
        if (Session::get('temp_id')){
          DB::table('basket')
             ->where('user_id', Session::get('temp_id'))
             ->update(['user_id' => Auth::id()]);
             Session::forget('temp_id');
        }
        DB::table('ip_address')->insert(
          ['user_id' => Auth::id(), 'ip_address' => User::get_client_ip(), 'created_at'=> carbon::now()]
        );
        DB::table('users')->where('id',Auth::id())->update(['online'=> 1]);
        Mail::to(Auth::user()->email)->send(new NewUserMail());
      }

}
