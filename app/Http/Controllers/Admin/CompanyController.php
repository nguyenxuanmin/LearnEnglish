<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use App\Services\AdminService;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminService;
    }

    public function show(){
        $company = Company::all();
        return view('admin.company.main',[
            'company' => $company
        ]);
    }

    public function save(Request $request){
        $name = $request->name;
        $address = $request->address;
        $hotline = $request->hotline;
        $email = $request->email;
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

        $checkEmpty = Company::all();
        if(count($checkEmpty) == 0){
            $company = new Company();
        }else{
            $company = Company::find($checkEmpty[0]->id);
        }

        if ($logo != "") {
            if(count($checkEmpty) != 0){
                $imagePath = 'company/logo/'.$checkEmpty[0]->logo;
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }
            $messageError = $this->adminService->generateImage($_FILES["logo"],'company/logo');
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }else{
            if(count($checkEmpty) != 0){
                $logo = $checkEmpty[0]->logo;
            }
        }

        if ($favicon != "") {
            if(count($checkEmpty) != 0){
                $imagePath = 'company/favicon/'.$checkEmpty[0]->favicon;
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
            }
            $messageError = $this->adminService->generateImage($_FILES["favicon"],'company/favicon');
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }else{
            if(count($checkEmpty) != 0){
                $favicon = $checkEmpty[0]->favicon;
            }
        }
        
        $company->name = $name;
        $company->address = $address;
        $company->hotline = $hotline;
        $company->email = $email;
        $company->logo = $logo;
        $company->favicon = $favicon;
        $company->save();

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }
}
