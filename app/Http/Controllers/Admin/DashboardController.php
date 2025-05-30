<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Course;
use App\Models\Contact;
use App\Models\RegisterCourse;
use App\Models\Exercise;

class DashboardController extends Controller
{
    public function index(){
        $countUser = Progress::where('course_id','<>',NULL)->count();
        $countCourse = Course::count();
        $contacts = Contact::where('isRead',0)->OrderBy('created_at','desc')->get();
        $registerCourses = RegisterCourse::where('isRead',0)->OrderBy('created_at','desc')->get();
        $revenue = Progress::join('courses', 'progress.course_id', '=', 'courses.id')->sum('courses.fee');
        $countExercise = Exercise::whereDate('created_at',now())->count();
        $monthlyRevenue = Progress::join('courses', 'progress.course_id', '=', 'courses.id')
        ->selectRaw('MONTH(progress.created_at) as month, SUM(courses.fee) as revenue')
        ->groupByRaw('MONTH(progress.created_at)')
        ->pluck('revenue', 'month');
        $dataMonthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataMonthlyRevenue[] = $monthlyRevenue[$i] ?? 0;
        }
        return view('admin.dashboard',[
            'countUser' => $countUser,
            'countCourse' => $countCourse,
            'contacts' => $contacts,
            'registerCourses' => $registerCourses,
            'revenue' => $revenue,
            'countExercise' => $countExercise,
            'dataMonthlyRevenue' => $dataMonthlyRevenue
        ]);
    }
}
