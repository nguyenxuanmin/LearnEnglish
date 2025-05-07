<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProgressController extends Controller
{
    public function index(){
        $users = User::Where('access_right',0)->Where('status',1)->OrderBy('name','asc')->paginate(20);
        return view('admin.progress.list',[
            'users' => $users
        ]);
    }

    public function update($id){
        $progress = User::find($id);
        return view('admin.progress.main',[
            'progress' => $progress
        ]);
    }

    public function save(Request $request){

    }
}
