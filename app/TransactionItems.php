<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionItems extends Model
{
    //

    protected $fillable = [
        'code',
        'product_id',
        'user_id'
    ];


    public function transaction(){
        return $this->belongsTo('App\Transactions');
    }

    public function product(){
        return $this->belongsTo('App\Products');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
