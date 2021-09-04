<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate (
        
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
            ]
        
    );

    $user= new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->password =Hash::make($request->password);
    $user->ip = $request->ip();
    $user->user_agent = $request->server('HTTP_USER_AGENT');
    $user->login_at = date('Y-m-d H:i:s');
    $user->save();

    Wallet::firstOrCreate(
        [
            'user_id' => $user->id
        ],

        [
            'account_number'=>UUIDGenerate::accountNumber(),
            'amount'        => 0,
        ]
    );

    $token = $user->createToken('Magic Pay')->accessToken;

    return success('Successfully Registered.', ['token' => $token]);

    }

    public function login(Request $request){

        $request->validate (
        
            [
                'phone' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]
        
            );

    if(Auth::attempt(['phone'=> $request->phone, 'password'=> $request->password])){

        $user= auth()->user();

        $user->ip = $request->ip();
        $user->user_agent = $request->server('HTTP_USER_AGENT');
        $user->login_at = date('Y-m-d H:i:s');
        $user->update();

        Wallet::firstOrCreate(
            [
                'user_id' => $user->id
            ],

            [
                'account_number'=>UUIDGenerate::accountNumber(),
                'amount'        => 0,
            ]
        );

        $token = $user->createToken('Magic Pay')->accessToken;

        return success('Successfully logged in.', ['token' => $token]);

    }

    return fail('These credential do not match our record.',null);

    }

    public function logout(){
        $user = auth()->user();
        $user->token()->revoke();

        return success('Successfully Logged out',null);
    }

}
