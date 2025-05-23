@extends('admin.layout.master-page')

@section('title')
    Cập nhật tiến độ học tập
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Cập nhật tiến độ học tập</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('list_progress')}}">Tiến độ học tập</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cập nhật tiến độ học tập</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-primary card-outline mb-4">
                <form id="submitForm" data-url-submit="{{route('save_progress')}}" data-url-complete="{{route('list_progress')}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên học viên</label>
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Khóa học đang học</label>
                                    <select class="form-select" name="course">
                                        @if (isset($courses))
                                            @if (!isset($unit))
                                                <option selected disabled value="">Chọn khóa học</option>
                                            @endif
                                            @foreach ($courses as $item)
                                                <option @if (isset($progress) && $item->id == $progress->course_id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @else
                                            <option selected disabled value="">Chọn khóa học</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Khóa học đã học</label>
                                @if ($listCourse != "")
                                    <ul>
                                        @foreach ($listCourse as $item)
                                            <li>{{$item->name}}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="col-12 mb-3 text-end">
                                <button class="btn btn-success">Cập nhật</button>
                                <a href="{{route('list_progress')}}" class="btn btn-dark">Trở lại</a>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
