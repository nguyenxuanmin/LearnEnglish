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
                        <li class="breadcrumb-item"><a href="{{route('list_user')}}">Danh sách học viên</a></li>
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
                                    <label for="name" class="form-label">Tên học viên</label>
                                    <input type="text" class="form-control" name="name" value="@if (isset($user)){{$user->name}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Emai</label>
                                    <input type="email" class="form-control" name="email" value="@if (isset($user)){{$user->email}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone" value="@if (isset($user)){{$user->phone}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address" value="@if (isset($user)){{$user->address}}@endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="date_start" class="form-label">Ngày đăng ký học</label>
                                    <input type="date" class="form-control" name="date_start" value="@if (isset($user)){{$user->date_start->format('Y-m-d');}}@else{{now()->format('Y-m-d');}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Avatar</label>
                                    <input type="file" class="form-control mb-3" name="avatar" id="avatar" accept="image/*">
                                    <div class="avatarContent">
                                        <img id="avatarContent" src="@if (isset($user) && $user->avatar != ""){{asset('storage/user/' . basename($user->avatar))}}@else{{asset('library/admin/default-image.png')}}@endif" alt="Avatar preview" style="max-width: 100%; max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="status" class="form-label">Hoạt động/Không hoạt động</label>
                                <input type="checkbox" class="form-check-input" name="status" @if (!isset($user) || (isset($user) && $user->status == 1)) checked @endif>
                            </div>
                            <div class="col-12 mb-3 text-end">
                                <button class="btn btn-primary">{{$titlePage}}</button>
                                <a href="{{route('list_user')}}" class="btn btn-dark">Trở lại</a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="{{$action}}">
                    <input type="hidden" name="id" value="@if (isset($user)){{$user->id}}@endif">
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            document.getElementById('avatar').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageUrl = e.target.result;
                        const imgElement = document.getElementById('avatarContent'); 
                        imgElement.src = imageUrl; 
                        imgElement.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('#submitForm').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: '{{ route('save_user') }}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false, 
                    success: function(response) {
                        if (response.success == true) {
                            location.href = '{{route('list_user')}}';
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
