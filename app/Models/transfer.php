<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class transfer extends Model
{
    use HasFactory;
    public $table = 'transfers';

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'amount'
    ];

    public function fromUser()
    {
        return $this->hasOne(User::class, 'id', 'from_user_id');
    }

    public function toUser()
    {
        return $this->hasOne(User::class, 'id', 'to_user_id');
    }

    public static function transfer(Request $request , int $user_id){
        $to_fin_number=$request['to_fin_number'];
        $user=User::where(
            'Fin_number',$to_fin_number
        )->first();
        if (!$user) {
            return response("error");
        }
        $account_balance=$user->account_balance+$request['amount'];
        $user->account_balance=$account_balance;
        $user->save();
        $from_user=User::find($user_id);
        $account_balance=$from_user->account_balance-$request['amount'];
        $from_user->account_balance=$account_balance;
        $from_user->save();
        $transfer = new transfer();
        $transfer->from_user_id = $user_id;
        $transfer->to_user_id =$user->id;
        $transfer->amount = $request['amount'];
        $transfer->save();
        return $transfer;
    }


}
