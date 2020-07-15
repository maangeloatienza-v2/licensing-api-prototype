<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionItems extends Model
{
    //
    protected $fillable = [
        'code',
        'transaction_id',
        'product_id',
        'user_id',
        'status'
    ];


    public function transactions(){
        return $this->belongsTo('App\Transactions');
    }

    public function products(){
        return $this->belongsTo('App\Products');
    }

    public function users(){
        return $this->belongsTo('App\Users');
    }
}
