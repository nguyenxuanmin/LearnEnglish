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
                        <li class="breadcrumb-item"><a href="{{route('list_blog')}}">Danh sách blogs</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$titlePage}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-primary card-outline mb-4">
                <form id="submitForm" enctype="multipart/form-data" data-url-submit="{{route('save_blog')}}" data-url-complete="{{route('list_blog')}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tiêu đề</label>
                                    <input type="text" class="form-control" name="name" value="@if (isset($blog)){{$blog->name}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mô tả</label>
                                    <textarea class="form-control" name="description" rows="4">@if (isset($blog)){{$blog->description}}@endif</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ẩn/Hiện</label>
                                    <input type="checkbox" class="form-check-input" name="status" @if (!isset($blog) || (isset($blog) && $blog->status == 1)) checked @endif>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh</label>
                                    <input type="file" class="form-control mb-3" name="image" id="imageUpload" accept="image/*">
                                    <div class="imageContent">
                                        <img id="imageContent" src="@if (isset($blog) && $blog->image != ""){{asset('storage/blogs/' . basename($blog->image))}}@else{{asset('library/admin/default-image.png')}}@endif" alt="Image preview" style="max-width: 100%; max-height: 250px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea name="content" id="contentSummernote">@if (isset($blog)){{$blog->content}}@endif</textarea>
                            </div>
                            <div class="col-12 mb-3 text-end">
                                <button class="btn btn-primary">{{$titlePage}}</button>
                                <a href="{{route('list_blog')}}" class="btn btn-dark">Trở lại</a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="{{$action}}">
                    <input type="hidden" name="id" value="@if (isset($blog)){{$blog->id}}@endif">
                </form>
            </div>
        </div>
    </div>
@endsection
