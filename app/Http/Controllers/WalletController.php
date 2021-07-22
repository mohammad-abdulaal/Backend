<?php

namespace App\Http\Controllers;

use App\Models\transfer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Wallet;
// use App\User;

class WalletController extends Controller
{
    public function post(Request $request){
        $account = Wallet::createAccount($request , auth('api')->user()->id);
        return response()->json($account);
    }

    public function getByID($id){
        $account = Wallet::find($id);
        return response()->json($account);
    }

    public function delete($id) {
        return response()->json(Wallet::destroy($id));
    }

    public function transfer(Request $request){
        $transfer = transfer::transfer($request , auth('api')->user()->id);
        return response()->json($transfer);
    }


}
