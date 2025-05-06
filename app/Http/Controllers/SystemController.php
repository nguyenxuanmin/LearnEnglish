<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\User;
use App\Services\AdminService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminService;
    }
    
    public function index(){
        return view('system');
    }

    public function save(Request $request){
        $name = $request->name;
        $address = $request->address;
        $hotline = $request->hotline;
        $email = $request->email;
        $timework = $request->timework;
        $map = $request->map;
        if (isset($_FILES["logo"])) {
            $logo = $_FILES["logo"]["name"];
        }else{
            $logo = "";
        }
        if (isset($_FILES["favicon"])) {
            $favicon = $_FILES["favicon"]["name"];
        }else{
            $favicon = "";
        }
        
        if ($name == "") {
            return response()->json([
                'success' => false,
                'message' => 'Tên công ty không được để trống.'
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'success' => false,
                'message' => $email. ' không phải là email hợp lệ.',
            ]);
        }

        if ($logo != "") {
            $messageError = $this->adminService->generateImage($_FILES["logo"],'company/logo');
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }

        if ($favicon != "") {
            $messageError = $this->adminService->generateImage($_FILES["favicon"],'company/favicon');
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }

        $nameAdmin = $request->nameAdmin;
        $emailAdmin = $request->emailAdmin;
        $passWordAdmin = $request->passWordAdmin;

        if (empty($nameAdmin) || empty($emailAdmin) || empty($passWordAdmin)) {
            return response()->json([
                'success' => false,
                'message' => 'Tên, email và mật khẩu không được để trống.',
            ]);
        }
        if (!filter_var($emailAdmin, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'success' => false,
                'message' => $emailAdmin. ' không phải là email hợp lệ.',
            ]);
        }
        if (strlen($passWordAdmin) < 6) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            ]);
        }
        
        $company = new Company();
        $company->name = $name;
        $company->address = $address;
        $company->hotline = $hotline;
        $company->email = $email;
        $company->logo = $logo;
        $company->favicon = $favicon;
        $company->save();

        $user = new User();
        $user->name = $nameAdmin;
        $user->email = $emailAdmin;
        $user->password = Hash::make($passWordAdmin);
        $user->access_right = 1;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }
}
