@extends('client.layout.master-page')

@section('title')
    Thông tin tài khoản
@endsection

@section('content')
    <section class="section-user">
        <div class="container">
            <div class="title-index">
                <span>Thông tin tài khoản</span>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4 mb-3 col-mb-0">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="item-user-avatar mb-3">
                                <img id="avatarContent" src="@if (!empty($user->avatar)){{asset('storage/users/'.$user->avatar)}}@else{{asset('library/client/avatar-user.jpg')}}@endif" alt="{{$user->name}}" class="w-100 h-100 object-fit-cover rounded-circle">
                            </div>
                            <ul class="item-user-detail">
                                <li><b>{{$user->name}}</b></li>
                                <li>{{$user->email}}</li>
                                <li>Ngày tham gia: @if(isset($user->date_start)){{$user->date_start->format('d-m-Y')}}@else{{$user->created_at->format('d-m-Y')}}@endif</li>
                                <li>Khóa học đang học: @if(isset($user->progress->course)){{$user->progress->course->name}}@else Chưa có @endif</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form id="formUser" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Tên</label> 
                                        <input type="text" class="form-control" name="nameUser" value="{{$user->name}}" readonly>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" name="emailUser" value="{{$user->email}}" readonly>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="text" class="form-control" name="phoneUser" value="{{$user->phone}}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Địa chỉ</label>
                                        <input type="text" class="form-control" name="addressUser" value="{{$user->address}}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Avatar</label>
                                        <input type="file" class="form-control mb-3" name="avatarUser" id="avatarUser" accept="image/*">
                                    </div>
                                    <div class="col-12 text-end">
                                        <button id="btnUser" class="btn btn-outline-success">Cập nhật</button>
                                    </div>
                                </div>
                                <input type="hidden" name="idUser" value="{{$user->id}}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            document.getElementById('avatarUser').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageUrl = e.target.result;
                        const imgElement = document.getElementById('avatarContent'); 
                        imgElement.src = imageUrl;
                    }
                    reader.readAsDataURL(file);
                }
            });
            $('#formUser').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var btn = document.getElementById('btnUser');
                btn.disabled = true;
                btn.innerText = 'Đang xử lý...';
                $.ajax({
                    url: '{{route('update_user')}}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false, 
                    success: function(response) {
                        var message = "";
                        var modalContact = new bootstrap.Modal(document.getElementById('modalAlert'), {
                            backdrop: 'static',
                            keyboard: false
                        });
                        if(response.success == true){
                            message = "<div class='msgSuccess'><i class='fa-solid fa-check'></i><span>Cập nhật thành công.</span></div>";
                            modalContact.show();
                            setTimeout(() => {
                                location.href = '{{route('index')}}';
                            }, 3000);
                        }else{
                            message = "<div class='msgError'><i class='fa-solid fa-circle-exclamation'></i><span>"+response.message+"</span></div>";
                            modalContact.show();
                            setTimeout(() => {
                                modalContact.hide();
                            }, 2000);
                        }
                        $('#showMessage').html(message);
                        btn.disabled = false;
                        btn.innerText = 'Cập nhật';
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
@endsection