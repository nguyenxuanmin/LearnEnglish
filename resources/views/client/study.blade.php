@extends('client.layout.master-page')

@section('title')
    Khóa học đang học
@endsection

@section('content')
    <section class="section-study">
        <div class="container">
            @if (!isset($study))
                <div class="item-study-alert">
                    Bạn chưa có khóa học nào
                </div>
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
                                        @foreach ($unitActive->lessons as $item)
                                            <div class="item-lesson @if (!empty($lessonActive) && $lessonActive->id == $item->id) active @endif" data-id="{{$item->id}}">{{$item->name}}</div>
                                        @endforeach
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
                                        @if (!empty($lessonActive->content))
                                            <div>
                                                @php
                                                    echo $lessonActive->content;
                                                @endphp
                                            </div>
                                        @endif
                                        @foreach ($lessonActive->documents as $item)
                                            <div class="item-document">
                                                <span>{{$item->name}}</span>
                                                <a href="{{asset('storage/lesson_files/'.$item->name)}}" download title="Tải về"><i class="fa-solid fa-download"></i></a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <script>
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
                            response.lessons.forEach(function(lesson) {
                                unitContent += `
                                    <div class="item-lesson" data-id="${lesson.id}">
                                        ${lesson.name}
                                    </div>
                                `;
                            });
                        $('#unitContent').html(unitContent);
                        $('#lessonContent').html("");
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
        });

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
                        const baseDocumentUrl = "{{asset('storage/lesson_files')}}/";
                        let lessonContent = `<h4>${response.lesson.name}</h4>`;
                        if (response.lesson.content && response.lesson.content.trim() !== '') {
                            lessonContent += `
                                <div>
                                    ${response.lesson.content}
                                </div>
                            `;
                        }
                        response.documents.forEach(function(document) {
                            lessonContent += `
                                <div class="item-document">
                                    <span>${document.name}</span>
                                    <a href="${baseDocumentUrl}${document.name}" download title="Tải về"><i class="fa-solid fa-download"></i></a>
                                </div>
                            `;
                        });
                        $('#lessonContent').html(lessonContent);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            }
        });
    </script>
@endsection