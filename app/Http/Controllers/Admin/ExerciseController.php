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
use App\Models\NoticeExercise;
use App\Mail\NoticeExerciseMail;
use Illuminate\Support\Facades\Mail;

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
            $exercise = Exercise::with('lesson.unit')->where('user_id', $student->user_id)->where('lesson_id', $latestLesson->id)->first();
            $exercises[] = [
                'name' => $student->user->name,
                'lesson' => $latestLesson->unit->name . " - ". $latestLesson->name,
                'status' => $exercise ? true : false,
                'deadline' => $latestLesson->time->lte(now()->startOfDay()) ? true : false,
                'id' => $exercise ? $exercise->id : '',
                'email' => $student->user->email,
                'lesson_id' => $latestLesson->id,
                'user_id' => $student->user->id,
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
        $exercise = Exercise::with(['lesson.unit','user','exerciseDocuments'])->find($id);
        if($exercise->isConfirm != 1){
            $exercise->isConfirm = 1;
            $exercise->save();
        }
        return view('admin.exercise.main', [
            'exercise' => $exercise
        ]);
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
                'id' => $exercise ? $exercise->id : '',
                'email' => $student->user->email,
                'lesson_id' => $latestLesson->id,
                'user_id' => $student->user->id,
            ];
        }

        return view('admin.exercise.list-detail', compact('exercises'))->render();
    }

    public function noticeExercise(Request $request){
        $lessonId = $request->lesson_id;
        $email = $request->email;
        $userName = $request->user_name;
        $userId = $request->user_id;

        $lesson = Lesson::with('unit')->find($lessonId);
        $noticeExerciseEmpty = NoticeExercise::where('user_id',$userId)->where('lesson_id',$lessonId)->first();
        if (isset($noticeExerciseEmpty)) {
            return response()->json([
                'success' => false,
                'message' => "Bạn đã nhắc học viên này rồi"
            ]);
        }
        $details = [
            'name' => $userName,
            'unit' => $lesson->unit->name,
            'lesson' => $lesson->name,
            'deadline' => $lesson->time->addDays(2)->format('d/m/Y'),
        ];

        Mail::to($email)->send(new NoticeExerciseMail($details));

        $noticeExercise = new NoticeExercise();
        $noticeExercise->user_id = $userId;
        $noticeExercise->lesson_id = $lessonId;
        $noticeExercise->save();

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }
}
