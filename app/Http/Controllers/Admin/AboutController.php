<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\About;
use App\Services\AdminService;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminService;
    }

    public function show(){
        $about = About::first();
        return view('admin.about.main',[
            'about' => $about
        ]);
    }

    public function save(Request $request){
        $content = $request->content;
        if (isset($_FILES["image"])) {
            $image = $_FILES["image"]["name"];
        }else{
            $image = "";
        }

        if (empty($content)) {
            return response()->json([
                'success' => false,
                'message' => 'Nội dung không được để trống.'
            ]);
        }

        $about = About::first();

        if(!isset($about)){
            $about = new About();
        }

        if ($image != "") {
            if(isset($about)){
                $imagePath = 'abouts/'.$about->image;
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            $messageError = $this->adminService->generateImage($_FILES["image"],'abouts');
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }

        if(isset($about)){
            if (!$request->hasFile('image')) {
                $image = $about->image;
            }
        }
        
        $about->content = $content;
        $about->image = $image;
        $about->save();

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }
}
