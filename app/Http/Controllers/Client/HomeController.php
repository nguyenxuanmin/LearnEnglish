<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\About;
use App\Models\Course;
use App\Models\Feedback;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index(){
        $sliders = Slider::orderBy('created_at','desc')->limit(4)->get();
        $aboutUs = About::first();
        $courses = Course::where('status',1)->orderBy('created_at','desc')->limit(8)->get();
        $feedbacks = Feedback::orderBy('created_at','desc')->limit(8)->get();
        $blogs = Blog::where('status',1)->orderBy('created_at','desc')->limit(8)->get();
        return view('client.index',[
            'sliders' => $sliders,
            'aboutUs' => $aboutUs,
            'courses' => $courses,
            'feedbacks' => $feedbacks,
            'blogs' => $blogs
        ]);
    }
}
