<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AccountModel extends Model
{
    use HasFactory;
    public $table = 'account';

    protected $fillable = [
        'currency_name',
        'balance',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public static function createAccount(Request $request , int $user_id){
        $account = new AccountModel();
        $account->currency_name = $request['currency_name'];
        $account->balance = $request['balance'];
        $account->user_id = $user_id;
        $account->save();
        return $account;
    }
}
