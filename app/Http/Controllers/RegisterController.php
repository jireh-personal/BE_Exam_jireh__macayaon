<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Hash;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
class RegisterController extends Controller
{
    public function signup(SignUpRequest $request){

        $user = User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'role'      => 'admin',
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->to('/');
    }
}
