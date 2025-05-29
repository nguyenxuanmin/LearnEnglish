<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegisterCourse;

class RegisterCourseController extends Controller
{
    public function index(){
        $registerCourses = RegisterCourse::with('course')->orderBy('created_at','desc')->paginate(20);
        return view('admin.register-course.list',[
            'registerCourses' => $registerCourses,
            'infoSearch' => ''
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
        $registerCourses = RegisterCourse::with('course')
        ->where('name','LIKE','%'.$infoSearch.'%')
        ->orWhereHas('course', function ($query) use ($infoSearch) {
            $query->where('name', 'LIKE', '%' . $infoSearch . '%');
        })
        ->orderBy('created_at','desc')
        ->paginate(20);
        return view('admin.register-course.list',[
            'infoSearch' => $infoSearch,
            'registerCourses' => $registerCourses
        ]);
    }
}
