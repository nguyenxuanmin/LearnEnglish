@extends('client.layout.master-page')

@section('title')
    {{$titlePage}}
@endsection

@section('content')
    @include('client.layout.breadcrumb')
    <div class="container">
        <div class="item-course-detail mb-3 mb-lg-4">
            <h2 class="item-course-detail-title">{{$titlePage}}</h2>
            <div class="item-course-detail-fee">
                <b>Học phí:</b>  <span>{{number_format($course->fee, 0, ',', '.')}} VND</span>
                <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCourse">Đăng ký học</a>
            </div>
            <div class="title-detail"><i class="fa-regular fa-bookmark"></i> Chi tiết khóa học</div>
            <div class="item-course-detail-content clearfix">
                @php echo $course->content; @endphp
            </div>
        </div>
        @if (count($otherCourses) > 0)
            <div class="title-index">
                <span>Các khóa học khác</span>
            </div>
            <div class="my-course mx-15">
                @foreach ($otherCourses as $otherCourse)
                    <div class="item-course px15">
                        <div class="item-course-image">
                            <a href="{{route('course_detail',$otherCourse->slug)}}">
                                <img src="{{asset('storage/courses/'.$otherCourse->image)}}" alt="{{$otherCourse->name}}" class="w-100 h-100 object-fit-cover">
                            </a>
                        </div>
                        <div class="item-course-content">
                            <div class="item-course-title"><a href="{{route('course_detail',$otherCourse->slug)}}">{{$otherCourse->name}}</a></div>
                            <div class="item-course-desc">{{$otherCourse->description}}</div>
                            <div class="item-course-fee"><i class="fa-solid fa-dollar-sign"></i> {{number_format($otherCourse->fee, 0, ',', '.')}} VND</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="modal fade" id="modalCourse" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đăng ký khóa học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCourse">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" name="nameCourse" value="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phoneCourse" value="">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Emai</label>
                                    <input type="email" class="form-control" name="emailCourse" value="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Khóa học</label>
                                    <input type="text" class="form-control" name="courseName" value="{{$titlePage}}" readonly>
                                    <input type="hidden" name="courseId" value="{{$course->id}}">
                                </div>
                            </div>
                            <div class="col-12 mb-3 text-center">
                                <button id="btnCourse" class="btn btn-primary">Đăng ký</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#formCourse').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var btn = document.getElementById('btnCourse');
                btn.disabled = true;
                btn.innerText = 'Đang xử lý...';
                $.ajax({
                    url: '{{route('register_course')}}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false, 
                    success: function(response) {
                        if(response.success == true){
                            Swal.fire({
                                text: "Bạn đã đăng ký khóa học thành công!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            }).then((result) => {
                                location.href = '{{route('index')}}';
                            });
                        }else{
                            Swal.fire({
                                text: response.message,
                                icon: "error",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                        btn.disabled = false;
                        btn.innerText = 'Đăng ký';
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
@endsection