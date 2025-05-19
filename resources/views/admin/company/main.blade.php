@extends('admin.layout.master-page')

@section('title')
    Thông tin công ty
@endsection

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Thông tin công ty</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thông tin công ty</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-primary card-outline mb-4">
                <form id="submitForm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên công ty</label>
                                    <input type="text" class="form-control" name="name" value="@if (count($company)){{$company[0]->name}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address" value="@if (count($company)){{$company[0]->address}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label for="hotline" class="form-label">Hotline</label>
                                    <input type="text" class="form-control" name="hotline" value="@if (count($company)){{$company[0]->hotline}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="@if (count($company)){{$company[0]->email}}@endif">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" class="form-control mb-3" name="logo" id="logo" accept="image/*">
                                    <div class="logoContent">
                                        <img id="logoContent" src="@if (count($company) && $company[0]->logo != ""){{asset('storage/company/logo/'.$company[0]->logo)}}@else{{asset('library/admin/default-image.png')}}@endif" alt="Logo preview" style="max-width: 100%; max-height: 150px;">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="favicon" class="form-label">Favicon</label>
                                    <input type="file" class="form-control mb-3" name="favicon" id="favicon" accept="image/*">
                                    <div class="faviconContent">
                                        <img id="faviconContent" src="@if (count($company) && $company[0]->favicon != ""){{asset('storage/company/favicon/'.$company[0]->favicon)}}@else{{asset('library/admin/default-image.png')}}@endif" alt="Favicon preview" style="max-width: 100%; max-height: 100px;">
                                    </div>
                                </div>
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
    <script>
        $(document).ready(function() {
            document.getElementById('logo').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageUrl = e.target.result;
                        const imgElement = document.getElementById('logoContent'); 
                        imgElement.src = imageUrl; 
                        imgElement.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            document.getElementById('favicon').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imageUrl = e.target.result;
                        const imgElement = document.getElementById('faviconContent'); 
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
                    url: '{{ route('save_company') }}',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false, 
                    success: function(response) {
                        if (response.success == true) {
                            alert("Cập nhật thành công");
                            location.reload();
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
