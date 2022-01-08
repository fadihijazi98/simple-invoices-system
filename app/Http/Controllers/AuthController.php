<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $validate['password'] = Hash::make($request->get('password'));

        $user = User::create($validate);

        return
            response()
                ->json([
                    'user' => $user,
                    'token' => $user->createToken('auth-token', $request->only('ability'))->plainTextToken,
                ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = [];

        if(Auth::attempt($validated))
        {
            /** @var User $user */
            $user = Auth::user();

            $user->tokens()->delete();

            $response['user'] = $user;
            $response['token'] =
                $user
                    ->createToken('login-token', [$request->get('ability', '*')])
                    ->plainTextToken;
        } else {
            $response['failed'] = 'wrong credentials';
        }

        return
            response()
                ->json($response);
    }
}
