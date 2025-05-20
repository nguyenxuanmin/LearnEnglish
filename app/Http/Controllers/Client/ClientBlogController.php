<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class ClientBlogController extends Controller
{
    public function show(){
        $blogs = Blog::where('status',1)->orderBy('created_at','desc')->paginate(24);
        $titlePage = "Chia sẻ kiến thức";
        return view('client.blog',[
            'blogs' => $blogs,
            'titlePage' => $titlePage
        ]);
    }

    public function detail($slug){
        $blog = Blog::where('status',1)->where('slug',$slug)->firstOrFail();
        $titlePage = $blog->name;
        $category = "Chia sẻ kiến thức";
        $categoryLink = "blog";
        $otherBlogs = Blog::where('status',1)->where('id','<>',$blog->id)->orderBy('created_at','desc')->limit(8)->get();
        return view('client.blog-detail',[
            'blog' => $blog,
            'titlePage' => $titlePage,
            'category' => $category,
            'categoryLink' => $categoryLink,
            'otherBlogs' => $otherBlogs
        ]);
    }
}
