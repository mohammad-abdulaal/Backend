<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Float_;

// use App\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
      /*  $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {

            return response(['errors' => $validator->errors()->all()], 422);
        }*/
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token , 'email'=>$user->email];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }

    public function user() {
        $u =  User::where('email' , auth('api')->user()->email) ->first();
        return response()->json($u ,  200);
    }

    public function signup(Request $request)
    {
        ini_set('mysql.connect_timeout', 1000);
        ini_set('default_socket_timeout', 1000);
        // $request->validate([
        //     'first_name' => 'required|string',
        //     'last_name' => 'required|string',
        //     'phone_number' => 'required|string',
        //     'account_balance' => 'required|string',
        //     'location' => 'required|string',
        //     'email' => 'required|string|email|unique:users',
        //     'passport_picture' => 'required|string',
        //     'Fin_number' => 'required|string',

        // ]);
        $user=new User([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'phone_number'=>$request->phone_number,
            'account_balance'=>$request->account_balance,
            'location'=>$request->location,
            'email'=>$request->email,
            'passport_picture'=>$request->passport_picture,
            'Fin_number'=> (float)$request->Fin_number,
            'is_approved'=>$request->is_approved=0,
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
    public function approve(Request $request)
    {
        $user=User::find($request->user_id);
        $user->is_approved=1;
        $user->save();

        return response()->json([
            'message'=>'Successfully updated !'
        ],201);
    }




}
