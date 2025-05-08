<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\User;
use App\Models\Course;

class ProgressController extends Controller
{
    public function index(){
        $users = User::with(['progress.course'])
        ->where('access_right', 0)
        ->where('status', 1)
        ->OrderBy('name','asc')->paginate(20);
        return view('admin.progress.list',[
            'users' => $users
        ]);
    }

    public function update($id){
        $user = User::find($id);
        $progress = Progress::Where('user_id',$id)->first();
        if (isset($progress) && $progress->list_course_id != "") {[];
            $arrCourseID = json_decode($progress->list_course_id, true);
            $listCourse = Course::where(function ($query) use ($arrCourseID) {
                foreach ($arrCourseID as $id) {
                    $query->orWhere('id',$id);
                }
            })->OrderBy('name','asc')->get();

            $courses = Course::where(function ($query) use ($arrCourseID) {
                foreach ($arrCourseID as $id) {
                    $query->Where('id','<>',$id);
                }
            })->OrderBy('name','asc')->get();
        }else{
            $listCourse = "";
            $courses = Course::OrderBy('name','asc')->get();
        }
        return view('admin.progress.main',[
            'user' => $user,
            'progress' => $progress,
            'courses' => $courses,
            'listCourse' => $listCourse
        ]);
    }

    public function save(Request $request){
        $user_id = $request->user_id;
        $course_id = $request->course;
        if (!isset($course_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Khóa học không được để trống.'
            ]);
        }

        $progress = Progress::Where('user_id',$user_id)->first();
        if (!isset($progress)) {
            $progress = new Progress();
        }
        $progress->user_id = $user_id;
        $progress->course_id = $course_id;
        $progress->save();
        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function complete(Request $request){
        $list_course_id = [];
        $progress = Progress::find($request->id);
        if (isset($progress->list_course_id)) {
            $arrCourseID = json_decode($progress->list_course_id, true);
            foreach ($arrCourseID as $item) {
                $list_course_id[] = $item;
            }
        }
        $list_course_id[] = $progress->course_id;
        
        $progress->course_id = NULL;
        $progress->list_course_id = $list_course_id;
        $progress->save();

        return response()->json([
            'success' => true
        ]);
    }
}
