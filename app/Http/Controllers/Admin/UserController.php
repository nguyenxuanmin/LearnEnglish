<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AdminService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->adminService = new AdminService;
    }

    public function index(){
        $users = User::Where('access_right',0)->OrderBy('name','asc')->paginate(20);
        return view('admin.user.list',[
            'users' => $users
        ]);
    }

    public function add(){
        $titlePage = "Thêm học viên";
        $action = "add";
        return view('admin.user.main',[
            'titlePage' => $titlePage,
            'action' => $action
        ]);
    }

    public function edit($id){
        $titlePage = "Sửa học viên";
        $action = "edit";
        $user = User::find($id);
        return view('admin.user.main',[
            'titlePage' => $titlePage,
            'action' => $action,
            'user' => $user
        ]);
    }

    public function save(Request $request){
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $address = $request->address;
        $dateStart = $request->date_start;
        if(isset($request->status)){
            $status = 1;
        }else{
            $status = 0;
        }
        if (isset($_FILES["avatar"])) {
            $avatar = $_FILES["avatar"]["name"];
        }else{
            $avatar = "";
        }
        $action = $request->action;

        if (empty($name)) {
            return response()->json([
                'success' => false,
                'message' => 'Tên học viên không được để trống.'
            ]);
        }

        if (empty($email)) {
            return response()->json([
                'success' => false,
                'message' => 'Email không được để trống.'
            ]);
        }else{
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'success' => false,
                    'message' => $email. ' không phải là email hợp lệ.'
                ]);
            }

            if($action == "edit"){
                $checkEmpty = User::where('email',$email)->where('id','<>',$request->id)->first();
            }else{
                $checkEmpty = User::where('email',$email)->first();
            }
            if(isset($checkEmpty)){
                return response()->json([
                    'success' => false,
                    'message' => 'Email học viên đã tồn tại.'
                ]);
            }
        }

        if($phone != ""){
            $messageError = $this->adminService->checkPhone($phone);
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }

        if($action == "edit"){
            $user = User::find($request->id);
            $password = $user->password;
        }else{
            $user = new User();
            $password = Hash::make('123456');
        }

        if ($avatar != "") {
            if($action == "edit"){
                $imagePath = 'users/'.$user->avatar;
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            $messageError = $this->adminService->generateImage($_FILES["avatar"],'users');
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }

        if($action == "edit"){
            if (!$request->hasFile('avatar')) {
                $avatar = $user->avatar;
            }
        }

        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->address = $address;
        $user->date_start = $dateStart;
        $user->avatar = $avatar;
        $user->status = $status;
        $user->password = $password;
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function delete(Request $request){
        $user = User::find($request->id);
        $imagePath = 'users/'.$user->avatar;
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        $user->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function change_stt(Request $request){
        $user = User::find($request->id);
        if ($request->stt == 'show') {
            $user->status = 1;
        }else{
            $user->status = 0;
        }
        $user->save();
        return response()->json([
            'success' => true
        ]);
    }

    public function update_password(Request $request){
        $user = User::find($request->id);
        $user->password = Hash::make('123456');
        $user->save();
        return response()->json([
            'success' => true
        ]);
    }

    public function search(Request $request){
        $infoSearch = $request->search;
        $users = User::where('name','LIKE','%'.$infoSearch.'%')->orWhere('email','LIKE','%'.$infoSearch.'%')->orderBy('name','asc')->paginate(20);
        return view('admin.user.list',[
            'infoSearch' => $infoSearch,
            'users' => $users
        ]);
    }
}
