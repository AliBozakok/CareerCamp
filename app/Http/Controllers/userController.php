<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class userController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth:user', ['except' => ['login','register']]);
   }


   public function login()
   {
       $credentials = request(['email', 'password']);

       if (! $token = auth('user')->attempt($credentials)) {
           return response()->json(['error' => 'Unauthorized'], 401);
       }

       return $this->respondWithToken($token);
   }


   public function me()
   {
       return response()->json(auth('user')->user());
   }

   /**
    * Log the user out (Invalidate the token).
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function logout()
   {
       auth('user')->logout();

       return response()->json(['message' => 'Successfully logged out']);
   }


   protected function respondWithToken($token)
   {
       return response()->json([
           'access_token' => $token,
           'token_type' => 'bearer',
           'expires_in' => auth('user')->factory()->getTTL() * 60
       ]);
   }

   public function register(Request $request)
   {
    $input= $request->validate([
        'name'=>['required'],
        'email'=>['required','email'],
        'password'=>['required']
    ]);
    $user= User::where('email',$input['email'])->first();
    if(!$user)
    {
      User::create($input);
      return response()->json(["message"=>"user is added successfully"]);
    }
    return response()->json(["message"=>"user is found "]);
   }
}
