<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     /**
     * Registerd a newly created user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('Forum')->accessToken;

        return success('Successfully registered.', ['token' => $token, 'user' => $user]);
    }

       /**
     * Authenticate the log in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

       if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
           $user = auth()->user();
           $token = $user->createToken('Forum')->accessToken;
           $name = $user->name;
           return success('Successfully logged in.', ['token' => $token, 'user' => $user]);
       }
        
       return fail('These credentials do not match our records.', null);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
       $user = auth()->user();
       $user->token()->revoke();

       return success('Successfully logged out.', null);
    }
}
