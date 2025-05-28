@extends('admin.layout.master-page')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{$countUser}}</h3>
                            <p>Học viên</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="small-box-icon" viewBox="0 0 18 18">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{$countCourse}}</h3>
                            <p>Khóa học</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="small-box-icon" viewBox="0 0 18 18">
                            <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>111</h3>
                            <p>Liên hệ</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="small-box-icon" viewBox="0 0 18 18">
                            <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>11111111111</h3>
                            <p>Doanh thu</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="small-box-icon" viewBox="0 0 18 18">
                            <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z"/>
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6 mb-3">
                    <div class="card direct-chat direct-chat-primary mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách liên hệ chưa đọc</h3>
                            <div class="card-tools">
                                <span title="{{count($contacts)}} liên hệ mới" class="badge text-bg-warning"> {{count($contacts)}} </span>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="direct-chat-messages">
                                @if (count($contacts))
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tên người liên hệ</th>
                                                <th style="width:120px; text-align:right;">Ngày liên hệ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contacts as $item)
                                                <tr class="align-middle">
                                                    <td><a title="Xem" style="text-decoration: none; color:#000;" href="{{route('view_contact',$item->id)}}">{{$item->name}}</a></td>
                                                    <td style="text-align: right;">{{$item->created_at->format('d/m/Y')}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <div class="card direct-chat direct-chat-primary mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách đăng ký khóa học chưa đọc</h3>
                            <div class="card-tools">
                                <span title="{{count($registerCourses)}} đăng ký khóa học mới" class="badge text-bg-success"> {{count($registerCourses)}} </span>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="direct-chat-messages">
                                @if (count($registerCourses))
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tên người đăng ký</th>
                                                <th>Khóa học</th>
                                                <th style="width:120px; text-align:right;">Ngày đăng ký</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($registerCourses as $item)
                                                <tr class="align-middle">
                                                    <td><a title="Xem" style="text-decoration: none; color:#000;" href="{{route('view_register_course',$item->id)}}">{{$item->name}}</a></td>
                                                    <td>{{$item->course->name}}</td>
                                                    <td style="text-align: right;">{{$item->created_at->format('d/m/Y')}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
