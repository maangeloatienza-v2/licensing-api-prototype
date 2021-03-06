<?php
namespace App\Http\Controllers;
use App\User;
use Auth;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function __construct()
    {
      $this->middleware('auth:api')->except(['register', 'login']);
    }

    public function register(Request $request){

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken(
            $token,
            'Account created successfully',
            Auth::user());
    }

    public function login(Request $request){
        $reqBody = $request->only([
            'email',
            'password'
        ]);

        if(!$token = auth()->attempt($reqBody)) {
            return response()->json([
                'message' => 'Invalid username/password',
                'context' => 'Unauthorized'
            ],500);
        }

        return $this->respondWithToken(
            $token,
            'Logged in successfully',
            Auth::user());
    }

    public function respondWithToken($token,$message,$user){
        return response()->json([
            'data' => $user,
            'message' => $message,
            'token' => 'Bearer '.$token,
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ],200);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out'],200);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
