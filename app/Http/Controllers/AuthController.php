<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
// use App\User;

class AuthController extends Controller
{
    public function login(Request $request){
        try{
            if (Auth::attempt($request->only('email','password'))){
                /** @var User $user */
                $user=Auth::user();
                $token=$user->createToken('app')->accessToken;
                return response([
                    'message'=>'success',
                    'token'=>$token,
                    'user'=>$user
                ]);
            }
        }
        catch(\Exception $exception){
            return response([
                'message'=>$exception->getMessage()
            ],400);
        }
        return response([
            'message'=>'Invalid password'
        ],401);
    }

    public function user() {
        return Auth::user();
    }

    public function signup(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'account_balance' => 'required|string',
            'location' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $user=new User([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'phone_number'=>$request->phone_number,
            'account_balance'=>$request->account_balance,
            'location'=>$request->location,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);

        $user->save();

        return response()->json([
            'message'=>'Successfully created !'
        ],201);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}
