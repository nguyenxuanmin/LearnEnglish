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
        $idLessons = $request->input('idLesson');
        $nameLessons = $request->input('nameLesson');
        $contentLessons = $request->input('contentLesson');
        $statusLessons = $request->input('statusLesson');
        
        if (empty($name)) {
            return response()->json([
                'success' => false,
                'message' => 'Tên unit không được để trống.'
            ]);
        }

        if(isset($request->course)){
            $courseId = $request->course;
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Khóa học không được để trống.'
            ]);
        }

        if($action == "edit"){
            $checkEmpty = Unit::where('slug',$slug)->where('id','<>',$request->id)->where('course_id',$courseId)->first();
        }else{
            $checkEmpty = Unit::where('slug',$slug)->where('course_id',$courseId)->first();
        }
        if(isset($checkEmpty)){
            return response()->json([
                'success' => false,
                'message' => 'Tên unit đã tạo.'
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
            $lessons = Lesson::with('documents')->where('unit_id',$unit->id)->get();
            foreach ($lessons as $key => $lesson) {
                foreach ($lesson->documents as $documentRemove) {
                    $fileName = $documentRemove->name;
                    if((!empty($fileLessonOlds) && !in_array($fileName,$fileLessonOlds[$key+1])) || empty($fileLessonOlds)){
                        $filePath = 'documents/' . $fileName;
                        if (Storage::disk('public')->exists($filePath)) {
                            Storage::disk('public')->delete($filePath);
                        }
                    }
                    $documentRemove->delete();
                }
            }
        }else{
            $unit = new Unit();
        }
        
        $unit->name = $name;
        $unit->slug = $slug;
        $unit->course_id = $courseId;
        $unit->description = $description;
        $unit->status = $status;
        $unit->save();

        for ($i=0; $i < $countLesson; $i++) {
            if (empty($idLessons[$i])) {
                $lesson = new Lesson();
            } else {
                $lesson = Lesson::find($idLessons[$i]);
            }
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
                        $path = $file->storeAs('documents', $newNameFile, 'public');
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
        $lessons = Lesson::with('documents')->where('unit_id',$unit->id)->get();
        foreach ($lessons as $lesson) {
            foreach ($lesson->documents as $document) {
                $filePath = 'documents/' . $document->name;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        }
        $unit->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function changeStt(Request $request){
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

    public function search(Request $request){
        $infoSearch = $request->search;
        $units = Unit::where('name','LIKE','%'.$infoSearch.'%')->orderBy('name','asc')->paginate(20);
        return view('admin.unit.list',[
            'infoSearch' => $infoSearch,
            'units' => $units
        ]);
    }
}
