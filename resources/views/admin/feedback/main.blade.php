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
                        <li class="breadcrumb-item"><a href="{{route('list_feedback')}}">Danh sách feedbacks</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$titlePage}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-primary card-outline mb-4">
                <form id="submitForm" data-url-submit="{{route('save_feedback')}}" data-url-complete="{{route('list_feedback')}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Học viên</label>
                                    <select class="form-select" name="user">
                                        @if (isset($users))
                                            @if (!isset($feedback))
                                                <option selected disabled value="">Chọn học viên</option>
                                            @endif
                                            @foreach ($users as $item)
                                                <option @if (isset($feedback) && $item->id == $feedback->user_id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @else
                                            <option selected disabled value="">Chọn học viên</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6"></div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea name="content" id="contentSummernote">@if (isset($feedback)){{$feedback->content}}@endif</textarea>
                            </div>
                            <div class="col-12 mb-3 text-end">
                                <button class="btn btn-primary">{{$titlePage}}</button>
                                <a href="{{route('list_feedback')}}" class="btn btn-dark">Trở lại</a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="{{$action}}">
                    <input type="hidden" name="id" value="@if (isset($feedback)){{$feedback->id}}@endif">
                </form>
            </div>
        </div>
    </div>
@endsection
