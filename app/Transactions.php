<?php

namespace App;
use App\models\User;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    //

    protected $fillable = [
        'user_id',
        'code',
        'status'
    ];

    public function transactionItems(){
        return $this->hasMany('App\TransactionItems');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
