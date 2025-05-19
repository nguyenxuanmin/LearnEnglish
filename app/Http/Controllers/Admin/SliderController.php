<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;
use App\Services\AdminService;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminService;
    }

    public function index(){
        $sliders = Slider::OrderBy('name','asc')->paginate(20);
        return view('admin.slider.list',[
            'sliders' => $sliders
        ]);
    }

    public function add(){
        $titlePage = "Thêm slider";
        $action = "add";
        return view('admin.slider.main',[
            'titlePage' => $titlePage,
            'action' => $action
        ]);
    }

    public function edit($id){
        $titlePage = "Sửa slider";
        $action = "edit";
        $slider = Slider::find($id);
        return view('admin.slider.main',[
            'titlePage' => $titlePage,
            'action' => $action,
            'slider' => $slider
        ]);
    }

    public function save(Request $request){
        $name = $request->name;
        $action = $request->action;
        if (isset($_FILES["image"])) {
            $image = $_FILES["image"]["name"];
        }else{
            $image = "";
        }

        if (empty($name)) {
            return response()->json([
                'success' => false,
                'message' => 'Tên slider không được để trống.'
            ]);
        }

        if($action == "edit"){
            $slider = Slider::find($request->id);
        }else{
            $slider = new Slider();
        }

        if ($image != "") {
            if($action == "edit"){
                $imagePath = 'sliders/'.$slider->image;
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            $messageError = $this->adminService->generateImage($_FILES["image"],'sliders');
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }

        if($action == "edit"){
            if (!$request->hasFile('image')) {
                $image = $slider->image;
            }
        }
        
        $slider->name = $name;
        $slider->image = $image;
        $slider->save();

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function delete(Request $request){
        $slider = Slider::find($request->id);
        $imagePath = 'sliders/'.$slider->image;
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        $slider->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function search(Request $request){
        $infoSearch = $request->search;
        $sliders = Slider::where('name','LIKE','%'.$infoSearch.'%')->orderBy('name','asc')->paginate(20);
        return view('admin.slider.list',[
            'infoSearch' => $infoSearch,
            'sliders' => $sliders
        ]);
    }
}
