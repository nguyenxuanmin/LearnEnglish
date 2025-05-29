<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Course;
use App\Models\Progess;
use App\Models\Contact;
use App\Models\RegisterCourse;

class DashboardController extends Controller
{
    public function index(){
        $countUser = Progress::where('course_id','<>',NULL)->count();
        $countCourse = Course::count();
        $contacts = Contact::where('isRead',0)->OrderBy('created_at','desc')->get();
        $registerCourses = RegisterCourse::where('isRead',0)->OrderBy('created_at','desc')->get();
        return view('admin.dashboard',[
            'countUser' => $countUser,
            'countCourse' => $countCourse,
            'contacts' => $contacts,
            'registerCourses' => $registerCourses
        ]);
    }
}
