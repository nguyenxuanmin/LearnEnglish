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
                <form id="submitForm" enctype="multipart/form-data" data-url-submit="{{route('save_user')}}" data-url-complete="{{route('list_user')}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên học viên</label>
                                    <input type="text" class="form-control" name="name" value="@if (isset($user)){{$user->name}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Emai</label>
                                    <input type="email" class="form-control" name="email" value="@if (isset($user)){{$user->email}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone" value="@if (isset($user)){{$user->phone}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address" value="@if (isset($user)){{$user->address}}@endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ngày đăng ký học</label>
                                    <input type="date" class="form-control" name="date_start" value="@if (isset($user)){{$user->date_start->format('Y-m-d');}}@else{{now()->format('Y-m-d');}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Avatar</label>
                                    <input type="file" class="form-control mb-3" name="avatar" id="imageUpload" accept="image/*">
                                    <div class="imageContent">
                                        <img id="imageContent" src="@if (isset($user) && $user->avatar != ""){{asset('storage/users/' . basename($user->avatar))}}@else{{asset('library/admin/default-image.png')}}@endif" alt="Avatar preview" style="max-width: 100%; max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Hoạt động/Không hoạt động</label>
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
@endsection
