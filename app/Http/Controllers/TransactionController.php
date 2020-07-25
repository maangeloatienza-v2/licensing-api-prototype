<?php

namespace App\Http\Controllers;

use App\Transactions;
use JWTAuth;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return TransactionResource::collection(Transactions::paginate(10));
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

        $transaction = Transactions::create([
            'code' => $request->code,
            'user_id' => JWTAuth::user()['id'],
            'status' => $request->status
        ]);

        return TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transactions $transactions)
    {
        //

        return new TransactionResource($transactions);
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
