<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use App\Services\AdminService;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminService;
    }

    public function index(){
        $blogs = Blog::OrderBy('created_at','desc')->paginate(20);
        return view('admin.blog.list',[
            'blogs' => $blogs,
            'infoSearch' => ''
        ]);
    }

    public function add(){
        $titlePage = "Thêm blog";
        $action = "add";
        return view('admin.blog.main',[
            'titlePage' => $titlePage,
            'action' => $action
        ]);
    }

    public function edit($id){
        $titlePage = "Sửa blog";
        $action = "edit";
        $blog = Blog::find($id);
        return view('admin.blog.main',[
            'titlePage' => $titlePage,
            'action' => $action,
            'blog' => $blog
        ]);
    }

    public function save(Request $request){
        $name = $request->name;
        $slug = $this->adminService->generateSlug($name);
        $description = $request->description;
        $content = $request->content;
        if(isset($request->status)){
            $status = 1;
        }else{
            $status = 0;
        }
        $action = $request->action;
        if (isset($_FILES["image"])) {
            $image = $_FILES["image"]["name"];
        }else{
            $image = "";
        }

        if (empty($name)) {
            return response()->json([
                'success' => false,
                'message' => 'Tên blog không được để trống.'
            ]);
        }

        if($action == "edit"){
            $blog = Blog::find($request->id);
        }else{
            $blog = new Blog();
        }

        if ($image != "") {
            if($action == "edit"){
                $imagePath = 'blogs/'.$blog->image;
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            $messageError = $this->adminService->generateImage($_FILES["image"],'blogs');
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }

        if($action == "edit"){
            if (!$request->hasFile('image')) {
                $image = $blog->image;
            }
        }
        
        $blog->name = $name;
        $blog->slug = $slug;
        $blog->description = $description;
        $blog->content = $content;
        $blog->image = $image;
        $blog->status = $status;
        $blog->save();

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function delete(Request $request){
        $blog = Blog::find($request->id);
        $imagePath = 'blogs/'.$blog->image;
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        $blog->delete();
        return response()->json([
            'success' => true
        ]);
    }
    
    public function changeStt(Request $request){
        $blog = Blog::find($request->id);
        if ($request->stt == 'show') {
            $blog->status = 1;
        }else{
            $blog->status = 0;
        }
        $blog->save();
        return response()->json([
            'success' => true
        ]);
    }

    public function search(Request $request){
        $infoSearch = $request->search;
        $blogs = Blog::where('name','LIKE','%'.$infoSearch.'%')->orderBy('created_at','desc')->paginate(20);
        return view('admin.blog.list',[
            'infoSearch' => $infoSearch,
            'blogs' => $blogs
        ]);
    }
}
