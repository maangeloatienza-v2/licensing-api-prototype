<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    use softDeletes; 

    protected $fillable = [
        'name',
        'license_key'
    ];

    public function transactionItem(){
        return $this->hasMany('App\TransactionItems');
    }
}
