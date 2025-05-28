@extends('client.layout.master-page')

@section('title')
    Khóa học đang học
@endsection

@section('content')
    <section class="section-study">
        <div class="container">
            @if (!isset($study) || (isset($study) && is_null($study->course_id)) || (count($units) == 0))
                <div class="title-index">
                    <span>Khóa học đang học</span>
                </div>
                <div class="item-study-alert">Hiện tại bạn chưa có khóa học nào đang học.</div>
            @else
                <div class="title-index">
                    <span>{{$course->name}}</span>
                </div>
                <div class="item-unit">
                    @foreach ($units as $unit)
                        <div class="item-unit-name @if (!empty($unitActive) && $unitActive->id == $unit->id) active @endif" data-id="{{$unit->id}}">{{$unit->name}}</div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                        <div class="card">
                            <div class="card-body">
                                <div id="unitContent">
                                    @if (!empty($unitActive))
                                        <div class="unit-content-title">{{$unitActive->name}}</div>
                                        <div class="unit-content">
                                            @foreach ($lessons as $item)
                                                <div class="item-lesson @if (!empty($lessonActive) && $lessonActive->id == $item->id) active @endif" data-id="{{$item->id}}">{{$item->name}}</div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div id="lessonContent">
                                    @if (!empty($lessonActive))
                                        <h4>{{$lessonActive->name}}</h4>
                                        @if (count($lessonActive->isNotKeyDocuments))
                                            <a class="btn btn-lesson" data-bs-toggle="modal" data-bs-target="#modalLesson">Nộp bài tập</a>
                                            <p>Hạn cuối nộp bài tập: {{$lessonActive->time->format('d-m-Y')}}</p>
                                        @endif
                                        <div class="lesson-content">
                                            @if (!empty($lessonActive->content))
                                                <div>
                                                    @php
                                                        echo $lessonActive->content;
                                                    @endphp
                                                </div>
                                            @endif
                                            <div class="title-detail"><i class="fa-solid fa-file"></i> Tài liệu và bài tập:</div>
                                            @foreach ($lessonActive->isNotKeyDocuments as $item)
                                                <div class="item-document">
                                                    <span>{{$item->name}}</span>
                                                    <a href="{{asset('storage/documents/'.$item->name)}}" download title="Tải về"><i class="fa-solid fa-download"></i></a>
                                                </div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" id="lessonId" name="lessonId" value="{{$lessonActive->id}}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="modal fade" id="modalLesson" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nộp bài tập</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formLesson" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <a class="link-history" href="{{route('history_exercise')}}"><b>Lịch sử nộp bài tập</b></a>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Nội dung</label>
                                    <textarea class="form-control" name="contentLesson" rows="4"></textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">File bài tập</label>
                                    <input id="fileLesson" class="form-control" name="fileLesson[]" type="file" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx" onchange="handleFileSelect(this)">
                                    <div id="preview" class="file-preview"></div>
                                </div>
                                <div class="col-12 mb-3 text-center">
                                    <button id="btnLesson" class="btn btn-submit-lesson">Nộp bài tập</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

        if ($('.item-unit-name').length > 0) {
            document.querySelectorAll('.item-unit-name').forEach(unit => {
                unit.addEventListener('click', function () {
                    $('.item-unit-name').removeClass('active');
                    $(this).addClass('active');
                    const unitId = this.dataset.id;
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{route('get_unit')}}',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        type: 'POST',
                        data: {id: unitId},
                        success: function(response) {
                            let unitContent = `<div class="unit-content-title">${response.unitName}</div>`;
                                unitContent += `<div class="unit-content">`;
                                    response.lessons.forEach(function(lesson) {
                                        unitContent += `
                                            <div class="item-lesson" data-id="${lesson.id}">
                                                ${lesson.name}
                                            </div>
                                        `;
                                    });
                                unitContent += `</div>`;
                            $('#unitContent').html(unitContent);
                            $('#lessonContent').html("");
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                });
            });
        }

        if ($('#unitContent').length > 0) {
            document.getElementById('unitContent').addEventListener('click', function(e) {
                if (e.target.classList.contains('item-lesson')) {
                    $('.item-lesson').removeClass('active');
                    $(e.target).addClass('active');
                    const lessonId = e.target.dataset.id;
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{route('get_lesson')}}',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        type: 'POST',
                        data: { id: lessonId },
                        success: function(response) {
                            const baseDocumentUrl = "{{asset('storage/documents')}}/";
                            let lessonContent = `<h4>${response.lesson.name}</h4>`;
                            if(response.documents.length > 0){
                                lessonContent += `
                                    <a class="btn btn-lesson" data-bs-toggle="modal" data-bs-target="#modalLesson">Nộp bài tập</a>
                                    <p>Hạn cuối nộp bài tập: ${response.deadline}</p>
                                `;
                            }
                            lessonContent += `<div class="lesson-content">`;
                                if (response.lesson.content && response.lesson.content.trim() !== '') {
                                    lessonContent += `
                                        <div>
                                            ${response.lesson.content}
                                        </div>
                                    `;
                                }
                                lessonContent += `<div class="title-detail"><i class="fa-solid fa-file"></i> Tài liệu và bài tập:</div>`;
                                response.documents.forEach(function(document) {
                                    lessonContent += `
                                        <div class="item-document">
                                            <span>${document.name}</span>
                                            <a href="${baseDocumentUrl}${document.name}" download title="Tải về"><i class="fa-solid fa-download"></i></a>
                                        </div>
                                    `;
                                });
                            lessonContent += `</div>`;
                            lessonContent += `
                                <input type="hidden" id="lessonId" name="lessonId" value="${response.lesson.id}">
                            `;
                            $('#lessonContent').html(lessonContent);
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                }
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
            const input = document.getElementById('fileLesson');
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            input.files = dataTransfer.files;
        }

        if ($('#formLesson').length > 0){
            $('#formLesson').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var btn = document.getElementById('btnLesson');
                var lessonId = document.getElementById('lessonId').value;
                formData.append('lessonId', lessonId);
                btn.disabled = true;
                btn.innerText = 'Đang xử lý...';
                $.ajax({
                    url: '{{route('lesson')}}',
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
                                text: "Bạn đã nộp bài tập thành công!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            }).then((result) => {
                                location.href = '{{route('history_exercise')}}';
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
                        btn.innerText = 'Nộp bài tập';
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
        }
    </script>
@endsection