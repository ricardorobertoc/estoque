<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
//use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function Login(AuthRequest $request)
    {
      // grab credentials from the request
      $credentials = $request->only('username', 'password');

      try {
          // attempt to verify the credentials and create a token for the user
          if (! $token = JWTAuth::attempt($credentials)) {
              return response()->json(['error' => 'invalid_credentials'], 401);
          }
      } catch (JWTException $e) {
          // something went wrong whilst attempting to encode the token
          return response()->json(['error' => 'could_not_create_token'], 500);
      }

      // all good so return the token
      //return response()->json(compact('token'));
      return $this->getUser($token);
    }

    public function getUser(string $token)
    {
      $user = Auth::user();
      return compact('token', 'user');
    }
}
