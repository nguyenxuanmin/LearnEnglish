@extends('client.layout.master-page')

@section('title')
    {{$titlePage}}
@endsection

@section('content')
    @include('client.layout.breadcrumb')
    <div class="container">
        <div class="item-blog-detail mb-3 mb-lg-4">
            <h2 class="item-blog-detail-title">{{$titlePage}}</h2>
            <div class="item-blog-detail-date"><i class="fa-solid fa-calendar-days"></i> {{$blog->created_at->format('d-m-Y')}}</div>
            <div class="item-blog-detail-content clearfix">
                @php echo $blog->content; @endphp
            </div>
        </div>
        <div class="title-index">
            <span>Các chia sẻ kiến thức khác</span>
        </div>
        <div class="my-blog mx-15">
            @foreach ($otherBlogs as $otherBlog)
                <div class="item-blog px15">
                    <div class="item-blog-image">
                        <a href="{{route('blog_detail',$otherBlog->slug)}}">
                            <img src="{{asset('storage/blogs/'.$otherBlog->image)}}" alt="{{$otherBlog->name}}" class="w-100 h-100 object-fit-cover">
                        </a>
                    </div>
                    <div class="item-blog-date">{{$otherBlog->created_at->format('d-m-Y');}}</div>
                    <div class="item-blog-title"><a href="{{route('blog_detail',$otherBlog->slug)}}">{{$otherBlog->name}}</a></div>
                    <div class="item-blog-desc">{{$otherBlog->description}}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection