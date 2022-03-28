<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class UserController extends Controller
{
    public function untie($soc)
    {
        if(!auth()->check())
            return back();

        User::find(auth()->id())->update([
            $soc.'_id' => null
        ]);

        return back();
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
 
        return back();
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return back();
    }

    public  function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
