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
                        <li class="breadcrumb-item"><a href="{{route('list_course')}}">Danh sách khóa học</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$titlePage}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-primary card-outline mb-4">
                <form id="submitForm" enctype="multipart/form-data" data-url-submit="{{route('save_course')}}" data-url-complete="{{route('list_course')}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên khóa học</label>
                                    <input type="text" class="form-control" name="name" value="@if (isset($course)){{$course->name}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mô tả khóa học</label>
                                    <textarea class="form-control" name="description" rows="4">@if (isset($course)){{$course->description}}@endif</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Học phí</label>
                                    <input type="text" class="form-control" name="fee" id="fee" value="@if (isset($course)){{number_format($course->fee, 0, ',', '.')}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Thời gian học</label>
                                    <select class="form-select" name="time">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option @if ((!isset($course) && $i == 1) || (isset($course) && $i == $course->time))selected @endif value="{{$i}}">{{$i}} tháng</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ẩn/Hiện</label>
                                    <input type="checkbox" class="form-check-input" name="status" @if (!isset($course) || (isset($course) && $course->status == 1)) checked @endif>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh</label>
                                    <input type="file" class="form-control mb-3" name="image" id="imageUpload" accept="image/*">
                                    <div class="imageContent">
                                        <img id="imageContent" src="@if (isset($course) && $course->image != ""){{asset('storage/courses/' . basename($course->image))}}@else{{asset('library/admin/default-image.png')}}@endif" alt="Image preview" style="max-width: 100%; max-height: 250px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea name="content" id="contentSummernote">@if (isset($course)){{$course->content}}@endif</textarea>
                            </div>
                            <div class="col-12 mb-3 text-end">
                                <button class="btn btn-primary">{{$titlePage}}</button>
                                <a href="{{route('list_course')}}" class="btn btn-dark">Trở lại</a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="{{$action}}">
                    <input type="hidden" name="id" value="@if (isset($course)){{$course->id}}@endif">
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#fee').on('input', function() {
                let value = $(this).val();
                value = value.replace(/[^0-9]/g, '');
                let formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                $(this).val(formatted);
            });
        });
    </script>
@endsection
