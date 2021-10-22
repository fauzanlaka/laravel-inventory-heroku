<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //register
    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|min:6',
            'username' => 'required|string',
            'email'    => 'required|string|unique:users',
            'password' => 'required|string|confirmed',
            'tel'      => 'required|string',
            'role'     => 'required|string',
        ]);

        $user = User::create([
            'fullname' => $request['fullname'],
            'username' => $request['username'],
            'email'    => $request['email'],
            'password' => bcrypt($request['password']),
            'tel'      => $request['tel'],
            'role'     => $request['role'],
        ]);

        //create token

        $token = $user->createToken($request->userAgent(), ["$user->role"])->plainTextToken;

        $respone = [
            'usesr' => $user,
            'token' => $token,
        ];

        return response($respone, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        //check email
        $user = User::where('email', $request->email)->first();

        // //check password
        if(! $user || ! Hash::check($request->password, $user->password)){
            // throw ValidationException::withMessages([
            //     'username' => ['username atau password salah'],
            // ]);
            return response([
                'message' => 'invalid login!'
            ], 401);
        }else{

            $user->tokens()->delete();

            //create token
            $token = $user->createToken($request->userAgent(), ["$user->role"])->plainTextToken;

            $respone = [
                'usesr' => $user,
                'token' => $token,
            ];

            return response($respone, 201);  
        }  

        // return $request->all();
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'loged out'
        ];
    }
}
