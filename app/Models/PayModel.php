<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class PayModel extends Model
{
    use HasFactory;
    public $table = 'pay';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function createAccount(Request $request , int $user_id){
        $pay = new PayModel();
        $pay=User::find($user_id);
        $pay->user_id = $user_id;
        $pay->save();
        return $pay;
    }

}
