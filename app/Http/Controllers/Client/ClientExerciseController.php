<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Exercise;
use App\Models\ExerciseDocument;

class ClientExerciseController extends Controller
{
    public function show(){
        $exercises = Exercise::with('lesson')->where('user_id',Auth::id())->orderBy('created_at','desc')->get();
        return view('client.exercise',[
            'exercises' => $exercises
        ]);
    }

    public function update(Request $request){
        $id = $request->exerciseId;
        $content = $request->contentExercise;
        $fileExerciseOlds = $request->input('fileExerciseOld');
        if (!$request->hasFile('fileExercise') && empty($fileExerciseOlds)) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn tối thiếu 1 file bài tập.'
            ]);
        }else{
            $exercise = Exercise::find($id);
            $deadline = $exercise->lesson->time->copy()->addDays(1);
            if ($deadline->lt(now()->startOfDay())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đã quá thời gian nộp bài tập, không thể sửa.'
                ]);
            }
            
            if($exercise->isConfirm == 1){
                return response()->json([
                    'success' => false,
                    'message' => 'Bài tập đã được xác nhận, không thể sửa.'
                ]);
            }

            foreach ($exercise->exerciseDocuments as $exerciseDocument) {
                $fileName = $exerciseDocument->name;
                if((!empty($fileExerciseOlds) && !in_array($fileName,$fileExerciseOlds)) || empty($fileExerciseOlds)){
                    $filePath = 'exercise_documents/' . $fileName;
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
                $exerciseDocument->delete();
            }
            $exercise->content = $content;
            $exercise->save();

            if(!empty($fileExerciseOlds)){
                foreach ($fileExerciseOlds as $fileExerciseOld) {
                    $exerciseDocument = new ExerciseDocument();
                    $exerciseDocument->name = $fileExerciseOld;
                    $exerciseDocument->exercise_id = $exercise->id;
                    $exerciseDocument->save();
                }
            }
            
            if($request->hasFile('fileExercise')){
                foreach ($request->file('fileExercise') as $file) {
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
            }
            
            return response()->json([
                'success' => true,
                'message' => ''
            ]);
        }
    }
}
