<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\User;

class FeedbackController extends Controller
{
    public function index(){
        $feedbacks = Feedback::OrderBy('created_at','desc')->paginate(20);
        return view('admin.feedback.list',[
            'feedbacks' => $feedbacks
        ]);
    }

    public function add(){
        $titlePage = "Thêm feedback";
        $action = "add";
        $users = User::where('access_right',0)->where('status',1)->OrderBy('name','asc')->get();
        return view('admin.feedback.main',[
            'titlePage' => $titlePage,
            'action' => $action,
            'users' => $users
        ]);
    }

    public function edit($id){
        $titlePage = "Sửa feedback";
        $action = "edit";
        $feedback = Feedback::find($id);
        $users = User::where('access_right',0)->where('status',1)->OrderBy('name','asc')->get();
        return view('admin.feedback.main',[
            'titlePage' => $titlePage,
            'action' => $action,
            'feedback' => $feedback,
            'users' => $users
        ]);
    }

    public function save(Request $request){
        $userId = $request->user;
        $content = $request->content;
        $action = $request->action;

        if (empty($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn học viên.'
            ]);
        }

        if($action == "edit"){
            $feedback = Feedback::find($request->id);
        }else{
            $feedback = new Feedback();
        }
        
        $feedback->user_id = $userId;
        $feedback->content = $content;
        $feedback->save();

        return response()->json([
            'success' => true,
            'message' => ""
        ]);
    }

    public function delete(Request $request){
        $feedback = Feedback::find($request->id);
        $feedback->delete();
        return response()->json([
            'success' => true
        ]);
    }

    public function search(Request $request){
        $infoSearchs = $request->search;
        $feedback = Feedback::where('name','LIKE','%'.$infoSearch.'%')->orderBy('created_at','desc')->paginate(20);
        return view('admin.slider.list',[
            'infoSearch' => $infoSearch,
            'feedbacks' => $feedbacks
        ]);
    }
}
