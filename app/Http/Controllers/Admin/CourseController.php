<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Services\AdminService;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminService;
    }

    public function index(){
        $courses = Course::OrderBy('created_at','desc')->paginate(20);
        return view('admin.course.list',[
            'courses' => $courses
        ]);
    }

    public function add(){
        $titlePage = "Thêm khóa học";
        $action = "add";
        return view('admin.course.main',[
            'titlePage' => $titlePage,
            'action' => $action
        ]);
    }

    public function edit($id){
        $titlePage = "Sửa khóa học";
        $action = "edit";
        $course = Course::find($id);
        return view('admin.course.main',[
            'titlePage' => $titlePage,
            'action' => $action,
            'course' => $course,
        ]);
    }

    public function save(Request $request){
        $name = $request->name;
        $slug = $this->adminService->generateSlug($name);
        $description = $request->description;
        $fee = $request->fee;
        if(isset($request->status)){
            $status = 1;
        }else{
            $status = 0;
        }
        $action = $request->action;

        if ($name == "") {
            return response()->json([
                'success' => false,
                'message' => 'Tên khóa học không được để trống.'
            ]);
        }

        if($action == "edit"){
            $course = Course::find($request->id);
        }else{
            $course = new Course();
        }
        
        $course->name = $name;
        $course->slug = $slug;
        $course->description = $description;
        $course->fee = $fee;
        $course->status = $status;
        $course->save();

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function delete(Request $request){
        $course = Course::find($request->id);
        $course->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function change_stt(Request $request){
        $course = Course::find($request->id);
        if ($request->stt == 'show') {
            $course->status = 1;
        }else{
            $course->status = 0;
        }
        $course->save();
        return response()->json([
            'success' => true
        ]);
    }
}
