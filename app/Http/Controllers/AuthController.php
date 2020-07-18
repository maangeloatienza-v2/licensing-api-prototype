<?php
namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function register(Request $request){

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login(){
        $reqBody = $request->only([
            'email',
            'password'
        ]);

        if(!$token = auth()->attempt($reqBody)) {
            return response()->json([
                'error' => 'Unauthorized'
            ],401);
        }
    }

    public function respondWithToken($token){
        return response()->json([
            'token' => 'Bearer '.$token,
            'expires_in' => auth()->factory()->getTTL() *60
        ]);
    }
}
