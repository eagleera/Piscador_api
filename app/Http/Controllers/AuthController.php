<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $token = Auth::setTTL(72000)->attempt($credentials);
        $user = User::where('email', $credentials['email'])->first();
        $user->addRanch();
        if (!$user->ranch) {
            $user->ranch = false;
        }
        $user->token = $token;
        return $user;
    }

    public function me()
    {
        $user = Auth::user();
        if($user) { 
            $user->addRanch();
            return response()->json(['user' => $user, 'msg' => 'success']);
        }
        return response()->json(['user' => false, 'msg' => 'unauthenticated']);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['msg' => 'logged out']);
    }
}
