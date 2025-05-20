@extends('client.layout.master-page')

@section('title')
    {{$titlePage}}
@endsection

@section('content')
    @include('client.layout.breadcrumb')
    <div class="container">
        <div class="item-course-detail mb-3 mb-lg-4">
            <h2 class="item-course-detail-title">{{$titlePage}}</h2>
            <div class="item-course-detail-fee">
                <b>Học phí:</b>  <span>{{number_format($course->fee, 0, ',', '.')}} VND</span>
            </div>
            <div class="title-detail"><i class="fa-regular fa-bookmark"></i> Chi tiết khóa học</div>
            <div class="item-course-detail-content clearfix">
                @php echo $course->content; @endphp
            </div>
        </div>
        <div class="title-index">
            <span>Các khóa học khác</span>
        </div>
        <div class="my-course mx-15">
            @foreach ($otherCourses as $otherCourse)
                <div class="item-course px15">
                    <div class="item-course-image">
                        <a href="{{route('course_detail',$otherCourse->slug)}}">
                            <img src="{{asset('storage/courses/'.$otherCourse->image)}}" alt="{{$otherCourse->name}}" class="w-100 h-100 object-fit-cover">
                        </a>
                    </div>
                    <div class="item-course-content">
                        <div class="item-course-title"><a href="{{route('course_detail',$otherCourse->slug)}}">{{$otherCourse->name}}</a></div>
                        <div class="item-course-desc">{{$otherCourse->description}}</div>
                        <div class="item-course-fee"><i class="fa-solid fa-dollar-sign"></i> {{number_format($otherCourse->fee, 0, ',', '.')}} VND</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection