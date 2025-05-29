<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\Exercise;
use App\Models\Progress;

class ExerciseController extends Controller
{
    public function index(){
        $courses = Course::where('status', 1)->get();
        if ($courses->isEmpty()) {
            abort(404);
        }
        $courseActive = $courses->first();
        $students = Progress::with('user')->where('course_id',$courseActive->id)->get();
        $latestLesson = Lesson::with('unit')->where('status',1)->whereHas('unit', function ($q) use ($courseActive) {
            $q->where('course_id', $courseActive->id);
        })->orderBy('id','desc')->firstOrFail();
        $exercises = [];
        foreach ($students as $student) {
            $exercise = Exercise::with('lesson.unit')->where('user_id', $student->user_id)
                ->where('lesson_id', $latestLesson->id)
                ->first();
            $exercises[] = [
                'name' => $student->user->name,
                'lesson' => $latestLesson->unit->name . " - ". $latestLesson->name,
                'status' => $exercise ? true : false,
                'deadline' => $latestLesson->time->lte(now()->startOfDay()) ? true : false,
            ];
        }

        return view('admin.exercise.list', [
            'courses' => $courses,
            'courseActive' => $courseActive,
            'exercises' => $exercises,
            'infoSearch' => ''
        ]);
    }

    public function view($id){
        
    }

    public function getExercises(Request $request){
        $students = Progress::with('user')->where('course_id',$request->course_id)->get();
        $latestLesson = Lesson::with('unit')->where('status',1)->whereHas('unit', function ($q) use ($request) {
            $q->where('course_id', $request->course_id);
        })->orderBy('id','desc')->firstOrFail();
        $exercises = [];
        foreach ($students as $student) {
            $exercise = Exercise::with('lesson.unit')->where('user_id', $student->user_id)->where('lesson_id', $latestLesson->id)->first();
            $exercises[] = [
                'name' => $student->user->name,
                'lesson' => $latestLesson->unit->name . " - ". $latestLesson->name,
                'status' => $exercise ? true : false,
                'deadline' => $latestLesson->time->lte(now()->startOfDay()) ? true : false,
            ];
        }

        return view('admin.exercise.list-detail', compact('exercises'))->render();
    }
}
