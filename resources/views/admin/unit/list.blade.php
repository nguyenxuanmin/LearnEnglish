@extends('admin.layout.master-page')

@section('title')
    Danh sách unit
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Danh sách unit</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Danh sách unit</li>
                    </ol>
                  </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="mb-3">
                <a class="btn btn-outline-primary" href="{{route('add_unit')}}" title="Thêm">Thêm unit</a>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{route('search_unit')}}">
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
                        <th scope="col">Tên unit</th>
                        <th scope="col" width="300px">Khóa học</th>
                        <th scope="col" width="200px" class="text-center">Tổng số bài học</th>
                        <th scope="col" width="250px" class="text-center">Trạng thái</th>
                        <th scope="col" width="150px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($units) == 0)
                        <tr>
                            <td valign="middle" align="center" colspan="6">Không có dữ liệu</td>
                        </tr>
                    @endif
                    @foreach ($units as $key => $unit)
                        <tr>
                            <td valign="middle" align="center">{{$key+1}}</td>
                            <td valign="middle">{{$unit->name}}</td>
                            <td valign="middle">{{$unit->course->name}}</td>
                            <td valign="middle" align="center">{{count($unit->lessons)}}</td>
                            <td valign="middle" align="center">
                                @if ($unit->status == 1)
                                    <a href="javascript:void(0);" title="Hiển thị" class="text-success" onclick="changeStt({{$unit->id}},'hide','{{route('change_stt_unit')}}');"><i class="fa-solid fa-eye"></i></a>
                                @else
                                    <a href="javascript:void(0);" title="Ẩn" class="text-danger" onclick="changeStt({{$unit->id}},'show','{{route('change_stt_unit')}}');"><i class="fa-solid fa-eye-slash"></i></a>
                                @endif
                            </td>
                            <td valign="middle" align="center">
                                <a href="{{route('edit_unit',[$unit->id])}}" class="btn btn-outline-info" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button class="btn btn-outline-danger" title="Xóa" onclick="deleteItem({{$unit->id}},'unit','{{route('delete_unit')}}');"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$units->appends(['search' => $infoSearch])->links('admin.layout.pagination')}}
        </div>
    </div>
@endsection
