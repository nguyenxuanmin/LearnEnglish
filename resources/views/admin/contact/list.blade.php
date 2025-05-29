@extends('admin.layout.master-page')

@section('title')
    Danh sách liên hệ
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Danh sách liên hệ</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Danh sách liên hệ</li>
                    </ol>
                  </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{route('search_contact')}}">
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
                        <th scope="col">Tên người liên hệ</th>
                        <th scope="col" width="300px">Email</th>
                        <th scope="col" width="250px" class="text-center">Trạng thái</th>
                        <th scope="col" width="250px" class="text-center">Ngày liên hệ</th>
                        <th scope="col" width="150px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($contacts) == 0)
                        <tr>
                            <td valign="middle" align="center" colspan="6">Không có dữ liệu</td>
                        </tr>
                    @endif
                    @foreach ($contacts as $key => $contact)
                        <tr>
                            <td valign="middle" align="center">{{$key+1}}</td>
                            <td valign="middle">{{$contact->name}}</td>
                            <td valign="middle">{{$contact->email}}</td>
                            <td valign="middle" align="center">
                                @if ($contact->isRead == 1)
                                    <span class="badge text-bg-success">Đã đọc</span>
                                @else
                                    <span class="badge text-bg-info">Chưa đọc</span>
                                @endif
                            </td>
                            <td valign="middle" align="center">{{$contact->created_at->format('d/m/Y');}}</td>
                            <td valign="middle" align="center">
                                <a href="{{route('view_contact',[$contact->id])}}" class="btn btn-outline-info" title="Xem"><i class="fa-solid fa-eye"></i></a>
                                <button class="btn btn-outline-danger" title="Xóa" onclick="deleteItem({{$contact->id}},'liên hệ','{{route('delete_contact')}}')"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$contacts->appends(['search' => $infoSearch])->links('admin.layout.pagination')}}
        </div>
    </div>
@endsection
