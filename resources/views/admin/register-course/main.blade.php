@extends('admin.layout.master-page')

@section('title')
    {{$titlePage}}
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">{{$titlePage}}</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('list_register_course')}}">Danh sách đăng ký khóa học</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$titlePage}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-primary card-outline mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" name="name" value="{{$registerCourse->name}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" value="{{$registerCourse->email}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone" value="{{$registerCourse->phone}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Khóa học</label>
                                <input type="text" class="form-control" name="course" value="{{$registerCourse->course->name}}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6"></div>
                        <div class="col-12 mb-3 text-end">
                            <a href="{{route('list_register_course')}}" class="btn btn-dark">Trở lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
