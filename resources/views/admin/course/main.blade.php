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
                <form id="submitForm" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên khóa học</label>
                                    <input type="text" class="form-control" name="name" value="@if (isset($course)){{$course->name}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả khóa học</label>
                                    <textarea class="form-control" name="description" rows="4">@if (isset($course)){{$course->description}}@endif</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="fee" class="form-label">Học phí</label>
                                    <input type="text" class="form-control" name="fee" value="@if (isset($course)){{$course->fee}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Ẩn/Hiện</label>
                                    <input type="checkbox" class="form-check-input" name="status" @if (!isset($course) || (isset($course) && $course->status == 1)) checked @endif>
                                </div>
                            </div>
                            <div class="col-12 col-md-6"></div>
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
            $('#submitForm').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{ route('save_course') }}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false, 
                    success: function(response) {
                        if (response.success == true) {
                            location.href = '{{route('list_course')}}';
                        }else{
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
@endsection
