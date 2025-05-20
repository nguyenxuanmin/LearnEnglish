<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class ClientCourseController extends Controller
{
    public function show(){
        $courses = Course::where('status',1)->orderBy('name','asc')->paginate(24);
        $titlePage = "Khóa học";
        return view('client.course',[
            'courses' => $courses,
            'titlePage' => $titlePage
        ]);
    }

    public function detail($slug){
        $course = Course::where('status',1)->where('slug',$slug)->firstOrFail();
        $titlePage = $course->name;
        $category = "Khóa học";
        $categoryLink = "course";
        $otherCourses = Course::where('status',1)->where('id','<>',$course->id)->orderBy('name','asc')->limit(8)->get();
        return view('client.course-detail',[
            'course' => $course,
            'titlePage' => $titlePage,
            'category' => $category,
            'categoryLink' => $categoryLink,
            'otherCourses' => $otherCourses
        ]);
    }
}
