<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiHelperTrait;

    public function __construct()
    {
        $this->initializeApiHelper();
    }

    public function v_login(Request $request)
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $credentials = $request->only('email', 'password');

        try {
            $response_data = $this->postData('/api/v1/auth/login', $credentials, 'json', false);

            if (!$response_data->success) {
                return redirect()->back()->withErrors($response_data->message);
            }

            session([
                'token' => $response_data->data->token,
                'user' => $response_data->data->user,
            ]);

            return redirect()->route('home')->with('success', 'Login successful!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Login failed. Please try again.');
        }
    }

    public function v_register(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $userData = $request->only('name', 'email', 'password');

        try {
            $response_data = $this->postData('/api/v1/auth/register', $userData, 'json', false);

            if (!$response_data->success) {
                return redirect()->back()->withErrors($response_data->message);
            }

            session([
                'token' => $response_data->data->token,
                'user' => $response_data->data->user,
            ]);

            return redirect()->route('home')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Registration failed. Please try again.');
        }
    }
}
