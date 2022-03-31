<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\LoginRequest;
class LoginController extends Controller
{
    public function index(LoginRequest $request)
    {
        if(Auth::attempt(['username' => $request->username,'password' => $request->password],$request->remember_me))
        {
            return redirect()->to('/?reload=true');
        }
        else
        {
            if(Auth::attempt(['email' => $request->username,'password' => $request->password],$request->remember_me))
            {
                return redirect()->to('/?reload=true');
            }
            return redirect()->to('/')->with('error','Invalid Email or Password.');
        }
    }
    public function logout()
    {
        Auth::logout();
        
        return redirect()->to('/');     
    }
    public function secret()
    {
        return response()->json($this->preparedResponseSuccess([
            'apiToken' => Auth::user()->createToken('auth_token')->plainTextToken, 
            'token' => csrf_token(),
            'name'  => Auth::user()->name
        ],'auth'));
    }
}
