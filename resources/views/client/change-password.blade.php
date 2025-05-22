@extends('client.layout.master-page')

@section('title')
    Thay đổi mật khẩu
@endsection

@section('content')
    <section class="section-change-password">
        <div class="container">
            <div class="title-index">
                <span>Thay đổi mật khẩu</span>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4"></div>
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <form id="formChangePassword">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Mật khẩu cũ</label> 
                                        <input type="password" class="form-control password-field" name="passwordOld" value="">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Mật khẩu mới</label> 
                                        <input type="password" class="form-control password-field" name="passwordNew" value="">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Nhập lại mật khẩu mới</label> 
                                        <input type="password" class="form-control password-field" name="passwordNewConfirm" value="">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="checkbox" class="form-check-input" name="displayPassword" id="displayPassword" value="">
                                        <label class="form-check-label">Hiển thị mật khẩu</label>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button id="btnChangePassword" class="btn btn-outline-success">Thay đổi mật khẩu</button>
                                    </div>
                                </div>
                                <input type="hidden" name="idChangePassword" value="{{$user->id}}">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4"></div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#displayPassword').on('change', function () {
                const type = this.checked ? 'text' : 'password';
                $('.password-field').attr('type', type);
            });

            $('#formChangePassword').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var btn = document.getElementById('btnChangePassword');
                btn.disabled = true;
                btn.innerText = 'Đang xử lý...';
                $.ajax({
                    url: '{{route('change_password')}}',
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
                            message = "<div class='msgSuccess'><i class='fa-solid fa-check'></i><span>Thay đổi mật khẩu thành công.</span></div>";
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
                        btn.innerText = 'Thay đổi mật khẩu';
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
@endsection