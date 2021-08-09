<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Float_;
use Illuminate\Support\Facades\Storage;
// use App\User;
use Illuminate\Support\Facades\URL;
class AuthController extends Controller
{
    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password ) && $user->is_approved==1) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token , 'email'=>$user->email];
                return response($response, 200);
            } else if ( $user->is_approved==0) {
                $response = ["message" => "still not approved"];
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
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'account_balance' => 'required|string',
            'location' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'passport_picture' => 'required|string',
            'Fin_number' => 'required|string',

        ]);




        $image = $request->passport_picture;
        preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
        $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
        $image = str_replace(' ', '+', $image);
        $imageName = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;
        $base64_decode= base64_decode($image);
        $passport_picture_url = 'uploads/'.$imageName;
        file_put_contents($passport_picture_url,$base64_decode);

        $user=new User([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'phone_number'=>$request->phone_number,
            'account_balance'=>$request->account_balance,
            'location'=>$request->location,
            'email'=>$request->email,
            'passport_picture'=>URL::to('/') ."/".$passport_picture_url,
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
    public function get(){
        $res = [
            'all' => [],
        ];
        $users = User::get();

        foreach($users as $key => $user) {
            $res['all'][$key] = [
                'id' => $user->id,
                "first_name"=>$user->first_name,
                "last_name"=>$user->last_name,
                "Fin_number"=>$user->Fin_number,
                "location"=>$user->location,
                "email"=>$user->email,
                "phone_number"=>$user->phone_number,
                "account_balance"=>$user->account_balance,
                "is_approved"=>$user->is_approved,
                "passport_picture"=>$user->passport_picture,
            ];
        }
        return response()->json($res);
    }




}
