@extends('admin.layout.master-page')

@section('title')
    Danh sách học viên nộp bài tập
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Danh sách học viên nộp bài tập</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách học viên nộp bài tập</li>
                    </ol>
                  </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Khóa học</label>
                    <select class="form-select" name="course" id="courseSelect">
                        @foreach ($courses as $item)
                            <option @if ($item->id == $courseActive->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-8 mb-3"></div>
            </div>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" width="100px" class="text-center">STT</th>
                        <th scope="col">Tên học viên</th>
                        <th scope="col" width="400px">Bài học</th>
                        <th scope="col" width="250px" class="text-center">Tình trạng</th>
                        <th scope="col" width="150px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody id="tableExercise">
                    @include('admin.exercise.list-detail')
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#courseSelect').on('change', function () {
                var courseId = $(this).val();
                $('#tableExercise').html('<tr><td colspan="5" align="center">Đang tải...</td></tr>');
                $.ajax({
                    url: '{{route('get_exercises')}}',
                    type: 'GET',
                    data: { course_id: courseId },
                    success: function (html) {
                        $('#tableExercise').html(html);
                    }
                });
            });
        });
    </script>
@endsection
