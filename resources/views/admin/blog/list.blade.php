@extends('admin.layout.master-page')

@section('title')
    Danh sách blogs
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Danh sách blogs</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                      <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Danh sách blogs</li>
                    </ol>
                  </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="mb-3">
                <a class="btn btn-outline-primary" href="{{route('add_blog')}}" title="Thêm">Thêm blog</a>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 mb-3">
                    <form action="{{route('search_blog')}}">
                        <div class="input-group">
                            <input type="search" name="search" class="form-control form-control" placeholder="Tìm kiếm" value="@if (isset($infoSearch)){{$infoSearch}}@endif">
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
                        <th scope="col">Tên blog</th>
                        <th scope="col" width="250px" class="text-center">Trạng thái</th>
                        <th scope="col" width="250px" class="text-center">Ngày tạo</th>
                        <th scope="col" width="150px" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($blogs) == 0)
                        <tr>
                            <td valign="middle" align="center" colspan="5">Không có dữ liệu</td>
                        </tr>
                    @endif
                    @foreach ($blogs as $key => $blog)
                        <tr>
                            <td valign="middle" align="center">{{$key+1}}</td>
                            <td valign="middle">{{$blog->name}}</td>
                            <td valign="middle" align="center">
                                @if ($blog->status == 1)
                                    <a href="javascript:void(0);" title="Hiển thị" class="text-success" onclick="change_stt({{$blog->id}},'hide');"><i class="fa-solid fa-eye"></i></a>
                                @else
                                    <a href="javascript:void(0);" title="Ẩn" class="text-danger" onclick="change_stt({{$blog->id}},'show');"><i class="fa-solid fa-eye-slash"></i></a>
                                @endif
                            </td>
                            <td valign="middle" align="center">{{$blog->created_at->format('d/m/Y');}}</td>
                            <td valign="middle" align="center">
                                <a href="{{route('edit_blog',[$blog->id])}}" class="btn btn-outline-info" title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button class="btn btn-outline-danger" title="Xóa" onclick="delete_blog({{$blog->id}});"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$blogs->links('admin.layout.pagination')}}
        </div>
    </div>
    <script>
        function delete_blog(id){
            let result  = confirm("Bạn có muốn xóa blog?");
            if (result) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{ route('delete_blog') }}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    type: 'POST',
                    data: {id: id},
                    success: function(response) {
                        location.href = '{{route('list_blog')}}';
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
                url: '{{ route('change_stt_blog') }}',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                type: 'POST',
                data: {
                    id: id,
                    stt: stt
                },
                success: function(response) {
                    location.href = '{{route('list_blog')}}';
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }
    </script>
@endsection
