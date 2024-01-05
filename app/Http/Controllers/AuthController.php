<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function register(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt( $request->password ),
        ]);

        $token = $user->createToken('test')->plainTextToken;

        return response()->json([
            'type' =>1,
            'user' => $user,
            'token' => $token
        ]);

    }

     //
    public function login(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);


        $user = User::where('email', $request->email)
        ->OrWhere('name',$request->email)
        ->first();


        if($user && password_verify($request->password , $user->password)){
            $token = $user->createToken('test')->plainTextToken;

            return response()->json([
                'type' => 1,
                'user' => $user,
                'token' => $token,
                'message' => "success login"
            ]);
        }else{
            return response()->json([
                'message' => "email / password incorrect"
            ]);
        }
    }

    public function logout(){
        Auth::user()->tokens()->delete();

        return response()->json([
            'type' => 1,
            'message' => "success logout"
        ]);
    }
}
