@extends('client.layout.master-page')

@section('title')
    {{$titlePage}}
@endsection

@section('content')
    @include('client.layout.breadcrumb')
    <div class="container">
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-12 col-lg-4 mb-3 mb-lg-4">
                    <div class="item-course">
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
                </div>
            @endforeach
        </div>
        {{$courses->links('client.layout.pagination')}}
    </div>
@endsection