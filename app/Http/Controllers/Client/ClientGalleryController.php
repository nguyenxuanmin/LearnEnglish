<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;

class ClientGalleryController extends Controller
{
    public function show(){
        $galleries = Gallery::orderBy('name','asc')->get();
        $titlePage = "Thư viện ảnh";
        return view('client.gallery',[
            'galleries' => $galleries,
            'titlePage' => $titlePage
        ]);
    }
}
