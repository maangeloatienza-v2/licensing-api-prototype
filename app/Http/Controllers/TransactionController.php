<?php

namespace App\Http\Controllers;

use App\Transactions;
use App\User;
use JWTAuth;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():TransactionCollection
    {
        //

        return new TransactionCollection(Transactions::
        with(
            array(
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
        $transaction = Transactions::create([
            'code' => $random,
            'user_id' => JWTAuth::user()['id'],
            'status' => $request->status
        ]);

        return new TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transactions $transaction)
    {

        return new TransactionResource($transaction->load('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Transaction $transaction)
    {
        //

        if($request->transaction()->id !== $transaction->id){
            return response()->json(['error' => 'Updating trasaction is prohibited.'], 403);
        }

        $transaction->update($request->only(['status']));

        return new TransactionResource($transaction);
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
