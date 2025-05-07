<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\Document;
use App\Services\AdminService;
use Illuminate\Support\Facades\Storage;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminService;
    }

    public function index(){
        $units = Unit::With(['course', 'lessons'])->OrderBy('name','asc')->paginate(20);
        return view('admin.unit.list',[
            'units' => $units
        ]);
    }

    public function add(){
        $titlePage = "Thêm unit";
        $action = "add";
        $courses = Course::where('status',1)->OrderBy('name','asc')->get();
        $sumLesson = 1;
        return view('admin.unit.main',[
            'titlePage' => $titlePage,
            'action' => $action,
            'courses' => $courses,
            'sumLesson' => $sumLesson
        ]);
    }

    public function edit($id){
        $titlePage = "Sửa unit";
        $action = "edit";
        $unit = Unit::find($id);
        $courses = Course::where('status',1)->OrderBy('name','asc')->get();
        $lessons = Lesson::With('documents')->Where('unit_id',$id)->OrderBy('name','asc')->get();
        $sumLesson = count($lessons) + 1;
        return view('admin.unit.main',[
            'titlePage' => $titlePage,
            'action' => $action,
            'unit' => $unit,
            'courses' => $courses,
            'lessons' => $lessons,
            'sumLesson' => $sumLesson
        ]);
    }

    public function save(Request $request){
        $name = $request->name;
        $slug = $this->adminService->generateSlug($name);
        $description = $request->description;
        if(isset($request->status)){
            $status = 1;
        }else{
            $status = 0;
        }
        $action = $request->action;
        $countLesson = $request->countLesson;
        $nameLessons = $request->input('nameLesson');
        $contentLessons = $request->input('contentLesson');
        $statusLessons = $request->input('statusLesson');
        
        if ($name == "") {
            return response()->json([
                'success' => false,
                'message' => 'Tên unit không được để trống.'
            ]);
        }

        if($action == "edit"){
            $checkEmpty = Unit::where('slug',$slug)->where('id','<>',$request->id)->first();
        }else{
            $checkEmpty = Unit::where('slug',$slug)->first();
        }
        if(isset($checkEmpty)){
            return response()->json([
                'success' => false,
                'message' => 'Tên unit đã tạo.'
            ]);
        }

        if(isset($request->course)){
            $course_id = $request->course;
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Khóa học không được để trống.'
            ]);
        }

        if ($countLesson == "" || $countLesson == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Bài học chưa được tạo.'
            ]);
        }

        for ($i = 0; $i < $countLesson; $i++) {
            if (empty($nameLessons[$i])) {
                return response()->json([
                    'success' => false,
                    'message' => "Tên bài học " . ($i + 1) . " không được để trống."
                ]);
            }
            $fileLessonOlds = $request->input('fileLessonOld', []);
        }

        if($action == "edit"){
            $unit = Unit::find($request->id);
            $lessonRemoves = Lesson::Where('unit_id',$unit->id)->get();
            foreach ($lessonRemoves as $key => $lessonRemove) {
                $fileRemoves = Document::Where('lesson_id',$lessonRemove->id)->get();
                foreach ($fileRemoves as $fileRemove) {
                    $fileName = $fileRemove->name;
                    if(isset($fileLessonOlds) && !in_array($fileName,$fileLessonOlds[$key+1])){
                        $filePath = 'lesson_files/' . $fileName;
                        if (Storage::disk('public')->exists($filePath)) {
                            Storage::disk('public')->delete($filePath);
                        }
                    }
                    $fileRemove->delete();
                }
                $lessonRemove->delete();
            }
        }else{
            $unit = new Unit();
        }
        
        $unit->name = $name;
        $unit->slug = $slug;
        $unit->course_id = $course_id;
        $unit->description = $description;
        $unit->status = $status;
        $unit->save();

        for ($i=0; $i < $countLesson; $i++) {
            $lesson = new Lesson();
            $lesson->name = $nameLessons[$i];
            $lesson->slug = $this->adminService->generateSlug($nameLessons[$i]);
            $lesson->content = $contentLessons[$i];
            if(isset($statusLessons[$i])){
                $lesson->status = 1;
            }else{
                $lesson->status = 0;
            }
            $lesson->unit_id = $unit->id;
            $lesson->save();
            
            $fileLessonOlds = $request->input('fileLessonOld', []);
            if (isset($fileLessonOlds[$i + 1])) {
                foreach ($fileLessonOlds[$i + 1] as $fileLessonOld) {
                    $fileLesson = new Document();
                    $fileLesson->name = $fileLessonOld;
                    $fileLesson->lesson_id = $lesson->id;
                    $fileLesson->save();
                }
            }

            if ($request->hasFile('fileLesson'.$i+1)) {
                foreach ($request->file('fileLesson'.$i+1) as $file) {
                    if ($file->isValid()) {
                        $nameFile = $file->getClientOriginalName();
                        $typeFile = $file->getClientOriginalExtension();
                        $nameOnly = pathinfo($nameFile, PATHINFO_FILENAME);
                        $newNameFile = 'lesson_' . time() . '_' . $nameOnly . '.' . $typeFile;
                        $path = $file->storeAs('lesson_files', $newNameFile, 'public');
                        $fileLesson = new Document();
                        $fileLesson->name = $newNameFile;
                        $fileLesson->lesson_id = $lesson->id;
                        $fileLesson->save();
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function delete(Request $request){
        $unit = Unit::find($request->id);
        $fileRemoves = DB::table('documents')
            ->join('lessons', 'documents.lesson_id', '=', 'lessons.id')
            ->where('lessons.unit_id', $request->id)
            ->select('documents.name')
            ->get();
        foreach ($fileRemoves as $fileRemove) {
            $filePath = 'lesson_files/' . $fileRemove->name;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }
        $unit->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function change_stt(Request $request){
        $unit = Unit::find($request->id);
        if ($request->stt == 'show') {
            $unit->status = 1;
        }else{
            $unit->status = 0;
        }
        $unit->save();
        return response()->json([
            'success' => true
        ]);
    }
}
