@extends('admin.layout.master-page')

@section('title')
    Danh sách khóa học
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Danh sách khóa học</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Danh sách khóa học</li>
                    </ol>
                  </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="mb-3">
                <a class="btn btn-outline-primary" href="{{route('add_course')}}" title="Thêm">Thêm khóa học</a>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{route('search_course')}}">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control form-control" placeholder="Tìm kiếm" value="{{$infoSearch}}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-dark">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-md-8"></div>
            </div>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" width="100px" class="text-center">STT</th>
                        <th scope="col">Tên khóa học</th>
                        <th scope="col" width="300px">Học phí</th>
                        <th scope="col" width="250px" class="text-center">Thời gian học</th>
                        <th scope="col" width="250px" class="text-center">Trạng thái</th>
                        <th scope="col" width="150px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($courses) == 0)
                        <tr>
                            <td valign="middle" align="center" colspan="6">Không có dữ liệu</td>
                        </tr>
                    @endif
                    @foreach ($courses as $key => $course)
                        <tr>
                            <td valign="middle" align="center">{{$key+1}}</td>
                            <td valign="middle">{{$course->name}}</td>
                            <td valign="middle">{{number_format($course->fee, 0, ',', '.')}} VND</td>
                            <td valign="middle" align="center">{{$course->time}} tháng</td>
                            <td valign="middle" align="center">
                                @if ($course->status == 1)
                                    <a href="javascript:void(0);" title="Hiển thị" class="text-success" onclick="changeStt({{$course->id}},'hide','{{route('change_stt_course')}}');"><i class="fa-solid fa-eye"></i></a>
                                @else
                                    <a href="javascript:void(0);" title="Ẩn" class="text-danger" onclick="changeStt({{$course->id}},'show','{{route('change_stt_course')}}');"><i class="fa-solid fa-eye-slash"></i></a>
                                @endif
                            </td>
                            <td valign="middle" align="center">
                                <a href="{{route('edit_course',[$course->id])}}" class="btn btn-outline-info" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button class="btn btn-outline-danger" title="Xóa" onclick="deleteItem({{$course->id}},'khóa học','{{route('delete_course')}}');"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$courses->appends(['search' => $infoSearch])->links('admin.layout.pagination')}}
        </div>
    </div>
@endsection
