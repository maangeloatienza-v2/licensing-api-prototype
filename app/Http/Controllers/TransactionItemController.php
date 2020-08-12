<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use App\TransactionItems;
use App\Http\Resources\TransactionItemResource;
use App\Http\Resources\TransactionItemCollection;
use Illuminate\Support\Str;


class TransactionItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():TransactionItemCollection
    {
        //

        return new TransactionItemCollection(TransactionItems::with(
            array(
                'product' => function($product){
                    $product->select(
                        'id',
                        'name',
                        'license_key'
                    );
                },
                'user' => function($user){
                    $user->select(
                        'id',
                        'first_name',
                        'last_name',
                        'email'
                    );
                }
            )
        )
        ->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $random = Str::random(10);

        $fields = ['user_id' => JWTAuth::user()['id'],'product_id'=> $request->product_id ];

        $transaction = TransactionItems::whereNull('transaction_id')
            ->where($fields)
            ->exists();

        if($transaction) {
            return response()->json([
                'message' => 'Item already exists in cart'
            ]);
        }else {
            $transactionItem = TransactionItems::create([
                'code' => $random,
                'product_id' => $request->product_id,
                'user_id' => JWTAuth::user()['id']
            ]);

            return new TransactionItemResource($transactionItem);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionItems $transactionItem)
    {
        return new TransactionItemResource($transactionItem->load('user','product'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
