<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Wallet extends Model
{
    use HasFactory;
    public $table = 'wallet';

    protected $fillable = [
        'Income',
        'Expenses',
        'Transaction',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function createAccount(Request $request , int $user_id){
        $wallet = new Wallet();
        $wallet->Income = $request['Income'];
        $wallet->Expenses = $request['Expenses'];
        $wallet->Transaction = $request['Transaction'];
        $wallet->user_id = $user_id;
        $wallet->save();
        return $wallet;
    }


}