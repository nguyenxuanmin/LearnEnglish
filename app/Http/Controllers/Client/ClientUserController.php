<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\AdminService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ClientUserController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminService;
    }

    public function show(){
        $user = User::find(Auth::id());
        return view('client.user',[
            'user' => $user
        ]);
    }

    public function showPassword(){
        $user = User::find(Auth::id());
        return view('client.change-password',[
            'user' => $user
        ]);
    }

    public function update(Request $request){
        $phone = $request->phoneUser;
        $address = $request->addressUser;
        if (isset($_FILES["avatarUser"])) {
            $avatar = $_FILES["avatarUser"]["name"];
        }else{
            $avatar = "";
        }

        if(!empty($phone)){
            $messageError = $this->adminService->checkPhone($phone);
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }

        $user = User::find($request->idUser);

        if (!empty($avatar)) {
            $imagePath = 'users/'.$user->avatar;
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $messageError = $this->adminService->generateImage($_FILES["avatarUser"],'users');
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }else{
            $avatar = $user->avatar;
        }

        $user->phone = $phone;
        $user->address = $address;
        $user->avatar = $avatar;
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function change_password(Request $request){
        $passwordOld = $request->passwordOld;
        $passwordNew = $request->passwordNew;
        $passwordNewConfirm = $request->passwordNewConfirm;

        if (empty($passwordOld)) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu cũ không được để trống'
            ]);
        }
        if (empty($passwordNew)) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu mới không được để trống'
            ]);
        }
        if (empty($passwordNewConfirm)) {
            return response()->json([
                'success' => false,
                'message' => 'Nhập lại mật khẩu mới không được để trống'
            ]);
        }
        if (mb_strlen($passwordNew) < 6) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu mới phải hơn 6 ký tự'
            ]);
        }
        if ($passwordNew !== $passwordNewConfirm) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu mới và nhập lại mật khẩu mới không khớp'
            ]);
        }

        $user = User::find($request->idChangePassword);

        if (!Hash::check($passwordOld, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu cũ không đúng'
            ]);
        }

        $user->password = Hash::make($passwordNew);
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }
}
