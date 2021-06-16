<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\AccountModel;
// use App\User;

class AccountController extends Controller
{
    public function post(Request $request){
        $wallet = AccountModel::createAccount($request , auth('api')->user()->id);
        return response()->json($wallet);
    }

    public function delete($id) {
        return response()->json(AccountModel::destroy($id));
    }
}
