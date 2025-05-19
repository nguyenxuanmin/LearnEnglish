@extends('client.layout.master-page')

@section('title')
    Trang chủ
@endsection

@section('content')
    <section class="section-slider">
        <div class="my-slider">
            @foreach ($sliders as $slider)
                <div class="item-slider">
                    <img src="{{asset('storage/sliders/'.$slider->image)}}" alt="{{$slider->name}}" class="w-100 object-fit-cover">
                </div>
            @endforeach
        </div>
    </section>
    <section class="section-about-us">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">@php echo $aboutUs->content @endphp</div>
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
            <div class="my-course">
                @foreach ($courses as $course)
                    <div class="item-course">
                        <div class="item-course-image">
                            <a href="">
                                <img src="{{asset('storage/courses/'.$course->image)}}" alt="{{$course->name}}" class="w-100 h-100 object-fit-cover">
                            </a>
                        </div>
                        <div class="item-course-content">
                            <div class="item-course-title"><a href="">{{$course->name}}</a></div>
                            <div class="item-course-desc">{{$course->description}}</div>
                            <div class="item-course-fee"><i class="fa-solid fa-dollar-sign"></i> {{number_format($course->fee, 0, ',', '.')}} VND</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
