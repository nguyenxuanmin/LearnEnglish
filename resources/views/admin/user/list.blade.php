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
                                    <a href="javascript:void(0);" title="Hoạt động" class="text-success" onclick="change_stt({{$user->id}},'hide');"><i class="fa-solid fa-circle-check"></i></a>
                                @else
                                    <a href="javascript:void(0);" title="Không hoạt động" class="text-danger" onclick="change_stt({{$user->id}},'show');"><i class="fa-solid fa-circle-xmark"></i></a>
                                @endif
                            </td>
                            <td valign="middle" align="center">
                                <a href="{{route('edit_user',[$user->id])}}" class="btn btn-outline-info" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button class="btn btn-outline-success" title="Cập nhật mật khẩu" onclick="update_password({{$user->id}},'{{$user->name}}');"><i class="fa-solid fa-rotate"></i></button>
                                <button class="btn btn-outline-danger" title="Xóa" onclick="delete_user({{$user->id}});"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$users->links('admin.layout.pagination')}}
        </div>
    </div>
    <script>
        function delete_user(id){
            let result  = confirm("Bạn có muốn xóa học viên?");
            if (result) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{ route('delete_user') }}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    type: 'POST',
                    data: {id: id},
                    success: function(response) {
                        location.href = '{{route('list_user')}}';
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            }
        }

        function change_stt(id,stt){
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{ route('change_stt_user') }}',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                type: 'POST',
                data: {
                    id: id,
                    stt: stt
                },
                success: function(response) {
                    location.href = '{{route('list_user')}}';
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }

        function update_password(id,name){
            let result  = confirm("Bạn có muốn cập nhật mật khẩu cho học viên "+name+"?");
            if (result) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{ route('update_password') }}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    type: 'POST',
                    data: {id: id},
                    success: function(response) {
                        alert('Cập nhật thành công');
                        location.href = '{{route('list_user')}}';
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            }
        }
    </script>
@endsection
