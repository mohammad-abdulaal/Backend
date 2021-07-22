<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model;
use App\Models\PayModel;
class PayController extends Controller
{
    public function put(Request $request){
        $account = PayModel::createAccount($request , auth('api')->user()->id);
        return response()->json($account);
    }

    public function get(Request $request ,$id){
        $account = PayModel::createAccount($request , auth('api')->user()->id);
        return response()->json($account , $id);
    }
}
