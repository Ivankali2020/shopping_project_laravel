<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role??'0';
        $user->save();
        return response()->json(['icon'=>'success','text'=>'successfully registered']);

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($validator->validated())){
            return response()->json([
                'message' => 'login successfully',
                'token' => Auth::user()->createToken('token_name')->plainTextToken,
            ]);
        }
        return response()->json(['message'=>'login failed']);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'successfuly logout'
        ]);
    }
}
