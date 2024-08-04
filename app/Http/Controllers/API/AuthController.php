<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\CommonTrait;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    use CommonTrait;


    public function notAuthorized(Request $request)
    {
        $token = $request->bearerToken();

        if ($token) {
            $tokenModel = PersonalAccessToken::findToken($token);

            if ($tokenModel) {
                if ($tokenModel->expires_at && Carbon::now()->gt($tokenModel->expires_at)) {
                    return $this->sendError('Token ini telah kedaluwarsa, silakan login kembali', null, 200);
                }
            }
        }

        return $this->sendError('Anda tidak diizinkan untuk mengakses ini', null, 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->failsValidate($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->plainTextToken;

        $tokenModel = PersonalAccessToken::findToken($token);
        $tokenModel->expires_at = Carbon::now()->addDay();
        $tokenModel->save();

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $this->sendResponse($response, 'User created successfully.');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->failsValidate($validator->errors());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $this->sendError('User does not exist.');
        }

        if (!Hash::check($request->password, $user->password)) {
            $this->sendError('Password does not match.');
        }

        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->plainTextToken;

        $tokenModel = PersonalAccessToken::findToken($token);
        $tokenModel->expires_at = Carbon::now()->addDay();
        $tokenModel->save();

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $this->sendResponse($response, 'User logged in successfully.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse(null, 'User logged out successfully.');
    }
}
