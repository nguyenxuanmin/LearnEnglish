@extends('client.layout.master-page')

@section('title')
    Lịch sử nộp bài tập
@endsection

@section('content')
    <section class="section-exercise">
        <div class="container">
            <div class="title-index">
                <span>Lịch sử nộp bài tập</span>
            </div>
            @if (count($exercises) == 0)
                <div class="item-study-alert">Hiện tại bạn chưa nộp bài tập nào.</div>
            @endif
            @foreach ($exercises as $exercise)
                <div class="item-exercise">
                    <div class="item-exercise-header" data-id="{{$exercise->id}}" data-bs-toggle="collapse" data-bs-target="#collapseExercise{{$exercise->id}}" aria-expanded="false" aria-controls="collapseExercise{{$exercise->id}}">
                        {{$exercise->lesson->unit->name}} - {{$exercise->lesson->name}}
                        <span class="toggle-icon"><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <div class="collapse" id="collapseExercise{{$exercise->id}}">
                        <div class="card card-body">
                            <div id="contentExercise{{$exercise->id}}"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <script>
        let selectedFiles = "";

        const allowedTypes = [
            'image/webp', 'image/jpeg', 'image/png', 'image/gif',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        if ($('.collapse').length > 0) {
            $('.collapse').on('show.bs.collapse', function () {
                $('.collapse').not(this).collapse('hide');
                $('.toggle-icon').html('<i class="fa-solid fa-plus"></i>');
                const targetId = $(this).attr('id');
                $(`[data-bs-target="#${targetId}"]`).find('.toggle-icon').html('<i class="fa-solid fa-minus"></i>');
            });

            $('.collapse').on('hide.bs.collapse', function () {
                const targetId = $(this).attr('id');
                $(`[data-bs-target="#${targetId}"]`).find('.toggle-icon').html('<i class="fa-solid fa-plus"></i>');
            });
        }

        function handleFileSelect(input) {
            const files = Array.from(input.files);
            const validFiles = files.filter(file => {
                if (!allowedTypes.includes(file.type)) {
                    alert(`File "${file.name}" không hợp lệ và sẽ bị bỏ qua.`);
                    return false;
                }
                return true;
            });
            selectedFiles = validFiles;
            renderFileList();
        }

        function renderFileList() {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'd-flex align-items-center justify-content-between mt-2';
                const div2 = document.createElement('div');
                div2.style.width = '85%';
                div2.style.wordBreak = 'break-all';
                div2.textContent = `${file.name}`;
                const btn = document.createElement('button');
                btn.textContent = `Xóa file`;
                btn.type = 'button';
                btn.className = 'btn btn-sm btn-danger';
                btn.onclick = () => {
                    selectedFiles.splice(index, 1);
                    renderFileList();
                };
                div.appendChild(div2);
                div.appendChild(btn);
                preview.appendChild(div);
            });
            updateInputFiles();
        }

        function updateInputFiles() {
            const input = document.getElementById('fileExercise');
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            input.files = dataTransfer.files;
        }

        function removeFile(button) {
            const fileItem = button.closest('.file-old');
            const hiddenInput = fileItem.nextElementSibling;
            if (fileItem) fileItem.remove();
            if (hiddenInput && hiddenInput.classList.contains('file-hidden')) hiddenInput.remove();
        }

        if ($('.collapse').length > 0) {
            $('.item-exercise-header').one('click', function () {
                var exerciseId = $(this).data('id');
                $.ajax({
                    url: `/get-form-exercise/${exerciseId}`,
                    type: 'GET',
                    success: function (response) {
                        $(`#contentExercise${exerciseId}`).html(response);
                    },
                    error: function (xhr) {
                        console.error(xhr);
                        alert("Không thể tải form bài tập.");
                    }
                });
            });
        }

        $(document).on('submit', '#formExercise', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var btn = document.getElementById('btnEditExercise');
            btn.disabled = true;
            btn.innerText = 'Đang xử lý...';
            $.ajax({
                url: '{{route('update_exercise')}}',
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
                            text: "Bạn đã chỉnh sửa bài tập thành công!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2000
                        }).then((result) => {
                            location.reload();
                        });
                    }else{
                        Swal.fire({
                            text: response.message,
                            icon: "error",
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                    btn.disabled = false;
                    btn.innerText = 'Chỉnh sửa';
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });
    </script>
@endsection