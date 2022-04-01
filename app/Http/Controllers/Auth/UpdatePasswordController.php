<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UpdatePasswordController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */


    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    
    public function store(Request $request)
    {
        if(auth()->user()->password != '')
        {
            if(!Hash::check($request->old_password, auth()->user()->password))
            {
                return response()->json(['message' => 'The given data was invalid.', 'errors' => ['old_password' => [__('auth.old_password')]]], 422);
            }
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if($request->has('ajaxValidate'))
            return response('OK', 200);

        User::find(auth::id())->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('message', __('Password was updated successfully'));

     //   return redirect(RouteServiceProvider::INDEX);
    }
}
