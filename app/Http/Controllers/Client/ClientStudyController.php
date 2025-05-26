<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Progress;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\Exercise;
use App\Models\ExerciseDocument;

class ClientStudyController extends Controller
{
    public function show(){
        $study = Progress::where('user_id',Auth::id())->first();
        if (isset($study) && !is_null($study->course_id)) {
            $course = $study->course;
            $units = $course->units()->with(['lessons.documents'])->where('status',1)->orderBy('created_at', 'asc')->get();
            if(isset($units)){
                $unitActive = $units[0];
            }else{
                $unitActive = "";
            }
            if(!empty($unitActive)){
                $lessons = $unitActive->lessons()->with('documents')->where('status',1)->orderBy('created_at', 'desc')->get();
                $lessonActive = $lessons[0];
            }else{
                $lessonActive = "";
            }
            return view('client.study',[
                'study' => $study,
                'course' => $course,
                'units' => $units,
                'unitActive' => $unitActive,
                'lessonActive' => $lessonActive
            ]);
        } else {
            return view('client.study',[
                'study' => $study
            ]);
        }
    }

    public function getUnits(Request $request){
        $unit = Unit::where('id',$request->id)->first();
        $lessons = $unit->lessons()->orderBy('created_at', 'desc')->get();
        return response()->json([
            'unitName' => $unit->name,
            'lessons' => $lessons
        ]);
    }

    public function getLessons(Request $request){
        $lesson = Lesson::where('id',$request->id)->first();
        return response()->json([
            'lesson' => $lesson,
            'documents' => $lesson->documents,
            'exercises' => $lesson->exercises
        ]);
    }
    
    public function lesson(Request $request){
        $id = $request->lessonId;
        $content = $request->contentLesson;
        $exerciseConfirm = Exercise::where('lesson_id',$id)->where('user_id',Auth::id())->where('isConfirm',1)->first();
        if (isset($exerciseConfirm)) {
            return response()->json([
                'success' => false,
                'message' => 'Bài tập bạn nộp đã được xác nhận, không thể nộp nữa.'
            ]);
        }

        if (!$request->hasFile('fileLesson')) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn tối thiếu 1 file bài học.'
            ]);
        }else{
            $exercise = new Exercise();
            $exercise->content = $content;
            $exercise->lesson_id = $id;
            $exercise->user_id = Auth::id();
            $exercise->save();
            foreach ($request->file('fileLesson') as $file) {
                if ($file->isValid()) {
                    $nameFile = $file->getClientOriginalName();
                    $typeFile = $file->getClientOriginalExtension();
                    $nameOnly = pathinfo($nameFile, PATHINFO_FILENAME);
                    $newNameFile = 'exercise_' . time() . '_' . $nameOnly . '.' . $typeFile;
                    $path = $file->storeAs('exercise_documents', $newNameFile, 'public');
                    $exerciseDocument = new ExerciseDocument();
                    $exerciseDocument->name = $newNameFile;
                    $exerciseDocument->exercise_id = $exercise->id;
                    $exerciseDocument->save();
                }
            }
            return response()->json([
                'success' => true,
                'message' => ''
            ]);
        }
    }
}
