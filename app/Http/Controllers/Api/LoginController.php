<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Series;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials) === false) {
            return response()->json('Unauthorized', 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('token', ['series:delete']);
        
        return response()->json($token->plainTextToken);
    }
}
