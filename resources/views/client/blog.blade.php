@extends('client.layout.master-page')

@section('title')
    {{$titlePage}}
@endsection

@section('content')
    @include('client.layout.breadcrumb')
    <div class="container">
        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-12 col-lg-4 mb-3 mb-lg-4">
                    <div class="item-blog">
                        <div class="item-blog-image">
                            <a href="{{route('blog_detail',$blog->slug)}}">
                                <img src="{{asset('storage/blogs/'.$blog->image)}}" alt="{{$blog->name}}" class="w-100 h-100 object-fit-cover">
                            </a>
                        </div>
                        <div class="item-blog-date">{{$blog->created_at->format('d-m-Y');}}</div>
                        <div class="item-blog-title"><a href="{{route('blog_detail',$blog->slug)}}">{{$blog->name}}</a></div>
                        <div class="item-blog-desc">{{$blog->description}}</div>
                    </div>
                </div>
            @endforeach
        </div>
        {{$blogs->links('client.layout.pagination')}}
    </div>
@endsection