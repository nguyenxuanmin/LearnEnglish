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
        $study = Progress::where('user_id', Auth::id())->first();
        if (!$study || is_null($study->course_id)) {
            return view('client.study', [
                'study' => $study
            ]);
        }
        $course = $study->course;
        $units = $course->units()->with('lessons.isNotKeyDocuments')->where('status', 1)->orderBy('created_at', 'desc')->get();
        if ($units->isEmpty()) {
            return view('client.study', [
                'study' => $study,
                'course' => $course,
                'units' => $units
            ]);
        }
        $unitActive = $units->first();
        $lessons = $unitActive->lessons()->with('isNotKeyDocuments')->where('status', 1)->orderBy('id', 'desc')->get();
        $lessonActive = $lessons->first();
        $isUpdate = false;
        $isDeadline = 0;
        $isLatest = Lesson::latest()->first()->id === $lessonActive->id;
        $deadline = $lessonActive->time->copy()->addDays(1);
        if ($deadline->lt(now()->startOfDay())) {
            $isDeadline = 1;
        }
        $exerciseEmpty = Exercise::where('lesson_id',$lessonActive->id)->first();
        if ($isLatest && $isDeadline === 0 && !isset($exerciseEmpty) && count($lessonActive->isNotKeyDocuments)){
            $isUpdate = true;
        }

        return view('client.study', [
            'study' => $study,
            'course' => $course,
            'units' => $units,
            'lessons' => $lessons,
            'unitActive' => $unitActive,
            'lessonActive' => $lessonActive,
            'isUpdate' => $isUpdate
        ]);
    }
    
    public function getUnits(Request $request){
        $unit = Unit::with(['lessons' => function($q) {
            $q->where('status', 1);
            $q->orderBy('created_at', 'desc');
        }])->find($request->id);

        return response()->json([
            'unitName' => $unit->name,
            'lessons' => $unit->lessons
        ]);
    }

    public function getLesson(Request $request){
        $lesson = Lesson::with('isNotKeyDocuments')->find($request->id);
        $isUpdate = false;
        $isDeadline = 0;
        $isLatest = Lesson::latest()->first()->id === $lesson->id;
        $deadline = $lesson->time->copy()->addDays(1);
        if ($deadline->lt(now()->startOfDay())) {
            $isDeadline = 1;
        }
        $exerciseEmpty = Exercise::where('lesson_id',$lesson->id)->first();
        if ($isLatest && $isDeadline === 0 && !isset($exerciseEmpty) && count($lesson->isNotKeyDocuments)){
            $isUpdate = true;
        }
        return response()->json([
            'lesson' => $lesson,
            'deadline' => $lesson->time ? $lesson->time->format('d-m-Y') : null,
            'documents' => $lesson->isNotKeyDocuments,
            'isUpdate' => $isUpdate
        ]);
    }
    
    public function lesson(Request $request){
        $id = $request->lessonId;
        $content = $request->contentLesson;

        if (!$request->hasFile('fileLesson')) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn tối thiếu 1 file bài tập.'
            ]);
        }

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
