<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        //https://laravel.com/docs/10.x/authentication#authenticating-users
        $check = Auth::attempt($credentials);
        if (!$check) {
            return $this->responseSuccess(false, 'AUTH_0001', 'Invalid email or password');
        }

        $user = Auth::user();

        $token = $user->createToken('USER TOKEN')->plainTextToken;

        $request->session()->regenerate();

        return $this->responseSuccess($token);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        //No need try & catch, handeled by Exceptions/Handler
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('USER TOKEN')->plainTextToken;

        return $this->responseSuccess($token);
    }

    public function seeRegistered()
    {
        $users = User::all();

        if (!$users) {
            return $this->responseNotfound();
        }

        return $this->responseSuccess($users);
    }

    public function getCurrentUser()
    {
        $user = Auth::user();

        if (!$user) {
            return $this->responseNotfound();
        }

        return $this->responseSuccess($user);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->responseSuccess();
    }
}
