<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email'         => 'required|email',
            'password'      => 'required',
            'device_name'   => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            dd('Invalid credentials');
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are not correct.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plaintTextToken,
        ]);
    }
}
