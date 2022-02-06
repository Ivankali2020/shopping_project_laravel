<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function redirect($name)
    {
        return Socialite::driver("$name")->redirect($name);
    }

    public function callBack($name)
    {
        try{
            $user = Socialite::driver("$name")->stateless()->user();

            $check = User::where('email',$user->email)->first();
            if (!$check){
                $newUser = new User();
                $newUser->name = $user->name ?? $user->nickname;
                $newUser->email = $user->email;
                $newUser->password = Hash::make("$user->name");
                $newUser->save();
                Auth::login($newUser,true);
                return redirect()->route('home')->with('message',['icon'=>'success','text'=>'Success Login']);
            }

            Auth::login($check);
            return redirect()->route('home')->with('message',['icon'=>'success','text'=>'Success Login']);
        }catch (Exception $e){
            return $e;
        }
    }
}
