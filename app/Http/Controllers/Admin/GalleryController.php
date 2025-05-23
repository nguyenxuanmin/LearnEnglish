<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Gallery;
use App\Services\AdminService;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminService;
    }

    public function index(){
        $galleries = Gallery::OrderBy('name','asc')->paginate(20);
        return view('admin.gallery.list',[
            'galleries' => $galleries
        ]);
    }

    public function add(){
        $titlePage = "Thêm ảnh";
        $action = "add";
        return view('admin.gallery.main',[
            'titlePage' => $titlePage,
            'action' => $action
        ]);
    }

    public function edit($id){
        $titlePage = "Sửa ảnh";
        $action = "edit";
        $gallery = Gallery::find($id);
        return view('admin.gallery.main',[
            'titlePage' => $titlePage,
            'action' => $action,
            'gallery' => $gallery
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
                'message' => 'Tên ảnh không được để trống.'
            ]);
        }

        if($action == "edit"){
            $gallery = Gallery::find($request->id);
        }else{
            $gallery = new Gallery();
        }

        if ($image != "") {
            if($action == "edit"){
                $imagePath = 'galleries/'.$gallery->image;
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            $messageError = $this->adminService->generateImage($_FILES["image"],'galleries');
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }

        if($action == "edit"){
            if (!$request->hasFile('image')) {
                $image = $gallery->image;
            }
        }
        
        $gallery->name = $name;
        $gallery->image = $image;
        $gallery->save();

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function delete(Request $request){
        $gallery = Gallery::find($request->id);
        $imagePath = 'galleries/'.$gallery->image;
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        $gallery->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function search(Request $request){
        $infoSearch = $request->search;
        $galleries = Gallery::where('name','LIKE','%'.$infoSearch.'%')->orderBy('name','asc')->paginate(20);
        return view('admin.gallery.list',[
            'infoSearch' => $infoSearch,
            'galleries' => $galleries
        ]);
    }
}
