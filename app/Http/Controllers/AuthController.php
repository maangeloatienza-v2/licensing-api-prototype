<?php
namespace App\Http\Controllers;
use App\User;
use Auth;

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

        return $this->respondWithToken($token,Auth::user());
    }

    public function login(Request $request, User $user){
        $reqBody = $request->only([
            'email',
            'password'
        ]);

        if(!$token = auth()->attempt($reqBody)) {
            return response()->json([
                'error' => 'Unauthorized'
            ],401);
        }

        return $this->respondWithToken($token,Auth::user());
    }

    public function respondWithToken($token,$user){
        return response()->json([
            'data' => $user,
            'token' => 'Bearer '.$token,
            'expires_in' => auth()->factory()->getTTL() *60
        ]);
    }
}
