@extends('admin.layout.master-page')

@section('title')
    Danh sách đăng ký khóa học
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Danh sách đăng ký khóa học</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Danh sách đăng ký khóa học</li>
                    </ol>
                  </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{route('search_register_course')}}">
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
                        <th scope="col">Tên người đăng ký</th>
                        <th scope="col" width="300px">Email</th>
                        <th scope="col" width="300px">Khóa học</th>
                        <th scope="col" width="150px" class="text-center">Trạng thái</th>
                        <th scope="col" width="200px" class="text-center">Ngày đăng ký</th>
                        <th scope="col" width="150px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($registerCourses) == 0)
                        <tr>
                            <td valign="middle" align="center" colspan="7">Không có dữ liệu</td>
                        </tr>
                    @endif
                    @foreach ($registerCourses as $key => $registerCourse)
                        <tr>
                            <td valign="middle" align="center">{{$key+1}}</td>
                            <td valign="middle">{{$registerCourse->name}}</td>
                            <td valign="middle">{{$registerCourse->email}}</td>
                            <td valign="middle">{{$registerCourse->course->name}}</td>
                            <td valign="middle" align="center">
                                @if ($registerCourse->isRead == 1)
                                    <span class="badge text-bg-success">Đã đọc</span>
                                @else
                                    <span class="badge text-bg-info">Chưa đọc</span>
                                @endif
                            </td>
                            <td valign="middle" align="center">{{$registerCourse->created_at->format('d/m/Y');}}</td>
                            <td valign="middle" align="center">
                                <a href="{{route('view_register_course',[$registerCourse->id])}}" class="btn btn-outline-info" title="Xem"><i class="fa-solid fa-eye"></i></a>
                                <button class="btn btn-outline-danger" title="Xóa" onclick="deleteItem({{$registerCourse->id}},'liên hệ','{{route('delete_register_course')}}')"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$registerCourses->appends(['search' => $infoSearch])->links('admin.layout.pagination')}}
        </div>
    </div>
@endsection
