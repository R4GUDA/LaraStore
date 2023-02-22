<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthorizedResource;
use App\Http\Resources\Auth\UnauthorizedResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ApiAuthenticateController extends Controller
{
    public function store(LoginRequest $request) {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) return UnauthorizedResource::make([]);

        $token = Hash::make(Str::random(16));

        Auth::user()->update(['remember_token' => $token]);

        return AuthorizedResource::make($token);
    }
}
