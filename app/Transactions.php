<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    //

    protected $fillable = [
        'user_id',
        'code'
    ];

    public function transactionItems(){
        return $this->hasMany('App\TransactionItems');
    }

    public function users(){
        return $this->hasOne('App\Users');
    }
}
