<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthController extends Controller
{
    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        if (empty($email) || empty($password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email và mật khẩu không được để trống.'
            ]);
        }

        $credentials = ['email' => $email, 'password' => $password,'status' => 1];
        if (auth()->attempt($credentials)) {
            return response()->json([
                'success' => true,
                'message' => 'Bạn đăng nhập thành công.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Thông tin đăng nhập không chính xác.'
        ]);
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('index');
    }
}
