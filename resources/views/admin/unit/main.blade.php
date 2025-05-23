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
                        <li class="breadcrumb-item"><a href="{{route('list_unit')}}">Danh sách unit</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$titlePage}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-primary card-outline mb-4">
                <form id="submitForm" enctype="multipart/form-data" data-url-submit="{{route('save_unit')}}" data-url-complete="{{route('list_unit')}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên unit</label>
                                    <input type="text" class="form-control" name="name" value="@if (isset($unit)){{$unit->name}}@endif">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Khóa học</label>
                                    <select class="form-select" name="course">
                                        @if (isset($courses))
                                            @if (!isset($unit))
                                                <option selected disabled value="">Chọn khóa học</option>
                                            @endif
                                            @foreach ($courses as $item)
                                                <option @if (isset($unit) && $item->id == $unit->course_id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @else
                                            <option selected disabled value="">Chọn khóa học</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mô tả unit</label>
                                    <textarea class="form-control" name="description" rows="4">@if (isset($unit)){{$unit->description}}@endif</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ẩn/Hiện</label>
                                    <input type="checkbox" class="form-check-input" name="status" @if (!isset($unit) || (isset($unit) && $unit->status == 1)) checked @endif>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="card card-success card-outline mb-4">
                                    <div class="card-header">
                                        <div class="text-end"><a href="javascript:void(0);" onclick="addLesson();" class="btn btn-success">Thêm bài học</a></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="accordion" id="lessonForm">
                                            @if (isset($lessons))
                                                @foreach ($lessons as $key => $lesson)
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLesson{{$key + 1}}" aria-expanded="false" aria-controls="collapseLesson{{$key + 1}}">
                                                                Bài học {{$key + 1}}
                                                            </button>
                                                        </h2>
                                                        <div id="collapseLesson{{$key + 1}}" class="accordion-collapse collapse" data-bs-parent="#lessonForm">
                                                            <div class="accordion-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tên bài học</label>
                                                                    <input type="text" class="form-control" name="nameLesson[]" value="{{$lesson->name}}">
                                                                    <input type="hidden" class="form-control" name="idLesson[]" value="{{$lesson->id}}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nội dung bài học</label>
                                                                    <textarea name="contentLesson[]" class="contentLesson">{{$lesson->content}}</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Ẩn/Hiện</label>
                                                                    <input type="checkbox" class="form-check-input" name="statusLesson[]" @if ($lesson->status == 1) checked @endif>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">File đính kèm</label>
                                                                    <input class="form-control" name="fileLesson{{$key + 1}}[]" type="file" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx" onchange="handleFileSelect(this, {{$key + 1}})">
                                                                    @foreach ($lesson->documents as $item)
                                                                        <div class="d-flex align-items-center justify-content-between mt-2 file-old">
                                                                            <div style="width: 85%; word-break: break-all;">{{$item->name}}</div>
                                                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeFile(this)">Xóa file</button>
                                                                        </div>
                                                                        <input type="hidden" name="fileLessonOld[{{$key + 1}}][]" value="{{$item->name}}" class="file-hidden">
                                                                    @endforeach
                                                                    <div id="preview{{$key + 1}}" class="file-preview"></div>
                                                                </div>
                                                                <div class="text-end">
                                                                    <button type="button" class="btn btn-danger" onclick="removeLesson(this)">Xóa bài học</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3 text-end">
                                <button class="btn btn-primary">{{$titlePage}}</button>
                                <a href="{{route('list_unit')}}" class="btn btn-dark">Trở lại</a>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="action" value="{{$action}}">
                    <input type="hidden" name="countLesson" id="countLesson" value="@if (isset($lessons)){{count($lessons)}}@endif">
                    <input type="hidden" name="id" value="@if (isset($unit)){{$unit->id}}@endif">
                </form>
            </div>
        </div>
    </div>
    <script>
        let lessonCount = {{$sumLesson}};

        function addLesson() {
            const uniqueId = lessonCount++;
            const lessonIndex = $('#lessonForm .accordion-item').length + 1;
            const newLessonId = 'collapseLesson' + uniqueId;
            const lessonHTML = `
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${newLessonId}" aria-expanded="false" aria-controls="${newLessonId}">
                            Bài học ${lessonIndex}
                        </button>
                    </h2>
                    <div id="${newLessonId}" class="accordion-collapse collapse" data-bs-parent="#lessonForm">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <label class="form-label">Tên bài học</label>
                                <input type="text" class="form-control" name="nameLesson[]" value="">
                                <input type="hidden" class="form-control" name="idLesson[]" value="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội dung bài học</label>
                                <textarea name="contentLesson[]" class="contentLesson"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ẩn/Hiện</label>
                                <input type="checkbox" class="form-check-input" name="statusLesson[]" checked>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">File đính kèm</label>
                                <input class="form-control" name="fileLesson${lessonIndex}[]" type="file" multiple accept=".webp,.jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx" onchange="handleFileSelect(this, ${lessonIndex})">
                                <div id="preview${lessonIndex}" class="file-preview"></div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-danger" onclick="removeLesson(this)">Xóa bài học</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('#lessonForm').append(lessonHTML);

            $(`#lessonForm .accordion-item:last .contentLesson`).summernote({
                height: 200
            });
            toastr.success('Đã thêm bài học!');
            renumberLessons();
        }

        function removeLesson(btn) {
            $(btn).closest('.accordion-item').remove();
            toastr.error('Đã xóa bài học!');
            renumberLessons();
        }

        function renumberLessons() {
            $('#lessonForm .accordion-item').each(function(index) {
                $(this).find('.accordion-button').text(`Bài học ${index + 1}`);
            });

            const currentLessonCount = $('#lessonForm .accordion-item').length;
                $('#countLesson').val(currentLessonCount);
        }

        let selectedFiles = {};

        const allowedTypes = [
            'image/webp', 'image/jpeg', 'image/png', 'image/gif',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        function handleFileSelect(input, lessonIndex) {
            const files = Array.from(input.files);
            const validFiles = files.filter(file => {
                if (!allowedTypes.includes(file.type)) {
                    alert(`File "${file.name}" không hợp lệ và sẽ bị bỏ qua.`);
                    return false;
                }
                return true;
            });
            selectedFiles[lessonIndex] = validFiles;
            renderFileList(lessonIndex);
        }

        function renderFileList(lessonIndex) {
            const preview = document.getElementById('preview' + lessonIndex);
            preview.innerHTML = '';
            selectedFiles[lessonIndex].forEach((file, index) => {
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
                    selectedFiles[lessonIndex].splice(index, 1);
                    renderFileList(lessonIndex);
                };
                div.appendChild(div2);
                div.appendChild(btn);
                preview.appendChild(div);
            });
            updateInputFiles(lessonIndex);
        }

        function updateInputFiles(lessonIndex) {
            const input = document.querySelectorAll('input[type="file"]')[lessonIndex];
            const dataTransfer = new DataTransfer();
            selectedFiles[lessonIndex].forEach(file => {
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

        $(document).ready(function() {
            $('.contentLesson').summernote({
                height: 300
            });
        });
    </script>
@endsection
