<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //It will throw an error by Exceptions/Handler   
        $request->validate([
            'email' => 'required | email',
            'password' => 'required | min:6',
        ]);

        $credentials = $request->only('email', 'password');

        //https://laravel.com/docs/10.x/authentication#authenticating-users
        //It doesn't throw AuthenticationException, so I used like this.
        $check = Auth::attempt($credentials);
        if (!$check) {
            return $this->responseFail('User not found');
        }

        $user = User::where('email', $request->email)->first();
        
        $token = $user->createToken("USER TOKEN")->plainTextToken;

        $request->session()->regenerate();

        return $this->responseSuccess($token);
    }
  
    public function register(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();

        //It doesn't throw an error to me. So I am not really sure if I should use "if".
        try{
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
        } catch(\Exception $e){
            $this->responseFail($e->getMessage());
        }
        // if(!$user){
        //     return $this->responseFail();
        // }

        $token = $user->createToken("USER TOKEN")->plainTextToken;

        return $this->responseSuccess($token);
    }

    public function seeRegistered()
    {
        $users = User::all();

        if(!$users){
            return $this->responseNotfound();
        }

        return $this->responseSuccess($users);
    }
    
    public function getCurrentUser()
    {
        $user = Auth::user();
        
        if(!$user){
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
