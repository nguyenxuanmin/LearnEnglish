<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Models\Course;
use App\Models\User;
use App\Models\RegisterCourse;
use App\Mail\RegisterCourseMail;
use Illuminate\Support\Facades\Mail;

class ClientCourseController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminService;
    }

    public function show(){
        $courses = Course::where('status',1)->orderBy('name','asc')->paginate(24);
        $titlePage = "Khóa học";
        return view('client.course',[
            'courses' => $courses,
            'titlePage' => $titlePage
        ]);
    }

    public function detail($slug){
        $course = Course::where('status',1)->where('slug',$slug)->firstOrFail();
        $titlePage = $course->name;
        $category = "Khóa học";
        $categoryLink = "course";
        $otherCourses = Course::where('status',1)->where('id','<>',$course->id)->orderBy('name','asc')->limit(8)->get();
        return view('client.course-detail',[
            'course' => $course,
            'titlePage' => $titlePage,
            'category' => $category,
            'categoryLink' => $categoryLink,
            'otherCourses' => $otherCourses
        ]);
    }

    public function registerCourse(Request $request){
        $name = trim($request->nameCourse);
        $email = trim($request->emailCourse);
        $phone = trim($request->phoneCourse);
        $courseName = $request->courseName;
        $courseId = $request->courseId;

        if(empty($name)){
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập họ và tên.'
            ]);
        }
        if(empty($email)){
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập email.'
            ]);
        }else{
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'success' => false,
                    'message' => $email. ' không phải là email hợp lệ.'
                ]);
            }
            $registerCourseExist = RegisterCourse::where('email',$email)->where('course_id',$courseId)->first();

            if(isset($contactExist)){
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã đăng ký khóa học này.'
                ]);
            }
        }

        if(empty($phone)){
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập số điện thoại.'
            ]);
        }else{
            $messageError = $this->adminService->checkPhone($phone);
            if($messageError != ""){
                return response()->json([
                    'success' => false,
                    'message' => $messageError
                ]);
            }
        }

        $details = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'course' => $courseName
        ];
        $emailAdmin = User::where('access_right',1)->first();
        Mail::to($emailAdmin->email)->send(new RegisterCourseMail($details));

        $registerCourse = new RegisterCourse();
        $registerCourse->name = $name;
        $registerCourse->email = $email;
        $registerCourse->phone = $phone;
        $registerCourse->course_id = $courseId;
        $registerCourse->save();

        return response()->json([
            'success' => true,
            'message' => ''
        ]);
    }
}
