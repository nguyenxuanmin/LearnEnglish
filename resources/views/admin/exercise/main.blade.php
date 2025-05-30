@extends('admin.layout.master-page')

@section('title')
    Nội dung bài tập của {{$exercise->user->name}}
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Nội dung bài tập của {{$exercise->user->name}}</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('list_exercise')}}">Danh sách học viên nộp bài tập</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nội dung bài tập của {{$exercise->user->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-primary card-outline mb-4">
                <div class="card-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Unit</label>
                                    <input type="text" class="form-control" name="unitName" readonly value="{{$exercise->lesson->unit->name}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Bài học</label>
                                    <input type="text" class="form-control" name="lessonName" readonly value="{{$exercise->lesson->name}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Nội dung</label>
                                <textarea class="form-control" name="content" rows="4" readonly>{{$exercise->content}}</textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">File bài tập</label>
                                <div class="alert alert-success" role="alert">
                                    @foreach ($exercise->exerciseDocuments as $item)
                                        <div class="py-2">
                                            {{$item->name}} <a class="alert-link" href="{{asset('storage/exercise_documents/'.$item->name)}}" download title="Xem">Tải về</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 mb-3 text-end">
                                <a href="{{route('list_exercise')}}" class="btn btn-dark">Trở lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
