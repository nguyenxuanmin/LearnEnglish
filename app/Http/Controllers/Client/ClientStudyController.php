<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Progress;
use App\Models\Unit;
use App\Models\Lesson;

class ClientStudyController extends Controller
{
    public function show(){
        $study = Progress::where('user_id',Auth::id())->firstOrFail();
        $course = $study->course;
        $units = $course->units()->with(['lessons.documents'])->orderBy('created_at', 'asc')->get();
        if(isset($units)){
            $unitActive = $units[0];
        }else{
            $unitActive = "";
        }
        if(!empty($unitActive)){
            $lessonActive = $unitActive->lessons[0];
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
    }

    public function getUnits(Request $request){
        $unit = Unit::where('id',$request->id)->first();
        $lessons = $unit->lessons()->orderBy('id', 'desc')->get();
        return response()->json([
            'unitName' => $unit->name,
            'lessons' => $lessons
        ]);
    }

    public function getLessons(Request $request){
        $lesson = Lesson::where('id',$request->id)->first();
        return response()->json([
            'lesson' => $lesson,
            'documents' => $lesson->documents
        ]);
    }
    
}
