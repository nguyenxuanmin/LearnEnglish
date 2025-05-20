<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;

class ClientAboutController extends Controller
{
    public function show(){
        $aboutUs = About::first();
        $titlePage = "Giới thiệu";
        return view('client.about',[
            'aboutUs' => $aboutUs,
            'titlePage' => $titlePage
        ]);
    }
}
