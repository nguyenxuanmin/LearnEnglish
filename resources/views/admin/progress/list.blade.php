@extends('admin.layout.master-page')

@section('title')
    Tiến độ học tập
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Tiến độ học tập</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Tiến độ học tập</li>
                    </ol>
                  </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" width="100px" class="text-center">STT</th>
                        <th scope="col">Tên học viên</th>
                        <th scope="col" width="300px">Email</th>
                        <th scope="col" width="250px">Khóa học đang học</th>
                        <th scope="col" width="250px">Khóa học đã học</th>
                        <th scope="col" width="150px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($users) == 0)
                        <tr>
                            <td valign="middle" align="center" colspan="6">Không có dữ liệu</td>
                        </tr>
                    @endif
                    @foreach ($users as $key => $user)
                        <tr>
                            <td valign="middle" align="center">{{$key+1}}</td>
                            <td valign="middle">{{$user->name}}</td>
                            <td valign="middle">{{$user->email}}</td>
                            <td valign="middle"></td>
                            <td valign="middle"></td>
                            <td valign="middle" align="center">
                                <a href="{{route('update_progress',[$user->id])}}" class="btn btn-outline-success" title="Cập nhật tiến độ"><i class="fa-solid fa-rotate"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$users->links('admin.layout.pagination')}}
        </div>
    </div>
@endsection
