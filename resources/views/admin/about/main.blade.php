@extends('admin.layout.master-page')

@section('title')
    Giới thiệu
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Giới thiệu</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-primary card-outline mb-4">
                <form id="submitForm" enctype="multipart/form-data" data-url-submit="{{route('save_about')}}" data-url-complete="">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh</label>
                                    <input type="file" class="form-control mb-3" name="image" id="imageUpload" accept="image/*">
                                    <div class="imageContent">
                                        <img id="imageContent" src="@if (isset($about) && $about->image != ""){{asset('storage/abouts/' . basename($about->image))}}@else{{asset('library/admin/default-image.png')}}@endif" alt="Image preview" style="max-width: 100%; max-height: 250px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6"></div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea name="content" id="contentSummernote">@if (isset($about)){{$about->content}}@endif</textarea>
                            </div>
                            <div class="col-12 mb-3 text-end">
                                <button class="btn btn-primary">Lưu</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
