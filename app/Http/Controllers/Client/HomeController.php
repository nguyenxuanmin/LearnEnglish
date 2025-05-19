<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\About;
use App\Models\Course;

class HomeController extends Controller
{
    public function index(){
        $sliders = Slider::orderBy('created_at','desc')->limit(4)->get();
        $aboutUs = About::first();
        $courses = Course::orderBy('created_at','desc')->limit(6)->get();
        return view('client.index',[
            'sliders' => $sliders,
            'aboutUs' => $aboutUs,
            'courses' => $courses
        ]);
    }
}
