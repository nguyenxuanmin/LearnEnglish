<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterCourse;

class RegisterCourseController extends Controller
{
    public function index(){
        $registerCourses = RegisterCourse::OrderBy('created_at','desc')->paginate(20);
        return view('admin.register-course.list',[
            'registerCourses' => $registerCourses
        ]);
    }

    public function view($id){
        $registerCourse = RegisterCourse::find($id);
        if ($registerCourse->isRead != 1) {
            $registerCourse->isRead = 1;
            $registerCourse->save();
        }
        $titlePage = $registerCourse->name;
        return view('admin.register-course.main',[
            'titlePage' => $titlePage,
            'registerCourse' => $registerCourse
        ]);
    }

    public function delete(Request $request){
        $registerCourse = RegisterCourse::find($request->id);
        $registerCourse->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function search(Request $request){
        $infoSearch = $request->search;
        $registerCourses = RegisterCourse::where('name','LIKE','%'.$infoSearch.'%')->OrderBy('created_at','desc')->paginate(20);
        return view('admin.register-course.list',[
            'infoSearch' => $infoSearch,
            'registerCourses' => $registerCourses
        ]);
    }
}
