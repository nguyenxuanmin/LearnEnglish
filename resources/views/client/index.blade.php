@extends('client.layout.master-page')

@section('title')
    Trang chủ
@endsection

@section('content')
    <section class="section-slider">
        <div class="my-slider">
            @foreach ($sliders as $slider)
                <div class="item-slider">
                    <img src="{{asset('storage/sliders/'.$slider->image)}}" alt="{{$slider->name}}" class="w-100 h-100 object-fit-cover">
                </div>
            @endforeach
        </div>
    </section>
    <section class="section-about-us">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 mb-4 mb-lg-0">@php echo $aboutUs->content @endphp</div>
                <div class="col-12 col-lg-6">
                    <img src="{{asset('storage/abouts/'.$aboutUs->image)}}" alt="Giới thiệu" class="w-100 object-fit-cover">
                </div>
            </div>
        </div>
    </section>
    <section class="section-course">
        <div class="container">
            <div class="title-index">
                <span>Khóa học nỗi bật</span>
            </div>
            <div class="my-course mx-15">
                @foreach ($courses as $course)
                    <div class="item-course px15">
                        <div class="item-course-image">
                            <a href="{{route('course_detail',$course->slug)}}">
                                <img src="{{asset('storage/courses/'.$course->image)}}" alt="{{$course->name}}" class="w-100 h-100 object-fit-cover">
                            </a>
                        </div>
                        <div class="item-course-content">
                            <div class="item-course-title"><a href="{{route('course_detail',$course->slug)}}">{{$course->name}}</a></div>
                            <div class="item-course-desc">{{$course->description}}</div>
                            <div class="item-course-fee"><i class="fa-solid fa-dollar-sign"></i> {{number_format($course->fee, 0, ',', '.')}} VND</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="section-feedback" style="background: url('{{asset('library/client/bg_feedback.webp')}}');">
        <div class="container">
            <div class="title-index">
                <span>Cảm nhận của học viên</span>
            </div>
            <div class="my-feedback mx-15">
                @foreach ($feedbacks as $feedback)
                    <div class="item-feedback px15">
                        <div class="item-feedback-content">
                            <div class="item-feedback-image">
                                <img src="@if(!empty($feedback->user->avatar)){{asset('storage/users/'.$feedback->user->avatar)}}@else{{asset('library/client/avatar-user.jpg')}}@endif" alt="{{$feedback->user->name}}" class="w-100 h-100 object-fit-cover rounded-circle">
                            </div>
                            <p>
                                {{strip_tags($feedback->content)}}
                            </p>
                            <b>{{$feedback->user->name}}</b>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="section-blog">
        <div class="container">
            <div class="title-index">
                <span>Chia sẻ kiến thức</span>
            </div>
            <div class="my-blog mx-15">
                @foreach ($blogs as $blog)
                    <div class="item-blog px15">
                        <div class="item-blog-image">
                            <a href="{{route('blog_detail',$blog->slug)}}">
                                <img src="{{asset('storage/blogs/'.$blog->image)}}" alt="{{$blog->name}}" class="w-100 h-100 object-fit-cover">
                            </a>
                        </div>
                        <div class="item-blog-date">{{$blog->created_at->format('d-m-Y');}}</div>
                        <div class="item-blog-title"><a href="{{route('blog_detail',$blog->slug)}}">{{$blog->name}}</a></div>
                        <div class="item-blog-desc">{{$blog->description}}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
