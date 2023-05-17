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
        try{
            $request->validate([
                'email' => 'required | email',
                'password' => 'required | min:6',
            ]);
        }
        //這個不太會抓 email 的格式不正確性（我猜），好像只要有 @ 會認為 email
        catch (ValidationException $exception) {
            $errorMessages = $exception->validator->getMessageBag()->getMessages();
            return $this->responseFail($errorMessages);
        }
        // dd($credentials);

        $credentials = $request->only('email', 'password');

        //https://laravel.com/docs/10.x/authentication#authenticating-users
        $check = Auth::attempt($credentials);
        if (!$check) {
            return $this->responseFail();
        }

        $user = User::where('email', $request->email)->first();

        // dd($user);
        
        $token = $user->createToken("USER TOKEN")->plainTextToken;

        $request->session()->regenerate();

        return $this->responseSuccess($token);
    }
  
    public function register(Request $request)
    {  
        try{
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
        }
        catch (ValidationException $exception) {
            $errorMessages = $exception->validator->getMessageBag()->getMessages();
            return $this->responseFail($errorMessages);
        }
           
        $data = $request->all();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
         
        if(!$user){
            return $this->responseFail();
        }

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

        // dd($user);

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
