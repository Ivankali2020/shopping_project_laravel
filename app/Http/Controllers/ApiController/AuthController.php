<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {

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
