@extends('admin.layout.master-page')

@section('title')
    Danh sách học viên
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Danh sách học viên</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Danh sách học viên</li>
                    </ol>
                  </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="mb-3">
                <a class="btn btn-outline-primary" href="{{route('add_user')}}" title="Thêm">Thêm học viên</a>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{route('search_user')}}">
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
                        <th scope="col">Tên học viên</th>
                        <th scope="col" width="300px">Email</th>
                        <th scope="col" width="250px">Số điện thoại</th>
                        <th scope="col" width="150px" class="text-center">Trạng thái</th>
                        <th scope="col" width="200px" class="text-center">Hành động</th>
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
                            <td valign="middle">{{$user->phone}}</td>
                            <td valign="middle" align="center">
                                @if ($user->status == 1)
                                    <a href="javascript:void(0);" title="Hoạt động" class="text-success" onclick="changeStt({{$user->id}},'hide','{{route('change_stt_user')}}');"><i class="fa-solid fa-circle-check"></i></a>
                                @else
                                    <a href="javascript:void(0);" title="Không hoạt động" class="text-danger" onclick="changeStt({{$user->id}},'show','{{route('change_stt_user')}}');"><i class="fa-solid fa-circle-xmark"></i></a>
                                @endif
                            </td>
                            <td valign="middle" align="center">
                                <a href="{{route('edit_user',[$user->id])}}" class="btn btn-outline-info" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button class="btn btn-outline-success" title="Cập nhật mật khẩu" onclick="updatePassword({{$user->id}},'{{$user->name}}');"><i class="fa-solid fa-rotate"></i></button>
                                <button class="btn btn-outline-danger" title="Xóa" onclick="deleteItem({{$user->id}},'học viên','{{route('delete_user')}}');"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$users->appends(['search' => $infoSearch])->links('admin.layout.pagination')}}
        </div>
    </div>
    <script>
        function updatePassword(id,name){
            Swal.fire({
                text: 'Bạn có muốn cập nhật mật khẩu cho học viên '+name+'?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Cập nhật',
                cancelButtonText: 'Huỷ bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    Swal.fire({
                        title: "Đang cập nhật!",
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        url: '{{ route('update_password') }}',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        type: 'POST',
                        data: {id: id},
                        success: function(response) {
                            Swal.fire({
                                text: "Cập nhật thành công!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                }
            });
        }
    </script>
@endsection
