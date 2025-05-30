<form id="formExercise" enctype="multipart/form-data">
    <div class="col-12 mb-3">
        <label class="form-label">Nội dung</label>
        <textarea class="form-control" name="contentExercise" rows="4" @if(!$isEdit) disabled @endif>{{$exercise->content}}</textarea>
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">File bài tập</label>
        <input id="fileExercise" @if(!$isEdit) disabled @endif class="form-control" name="fileExercise[]" type="file" multiple accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx" onchange="handleFileSelect(this)">
        <div class="title-detail mt-3"><i class="fa-solid fa-file"></i> File bài tập đã nộp:</div>
        @foreach ($exercise->exerciseDocuments as $item)
            <div class="file-old">
                <span>{{$item->name}} <b><a href="{{asset('storage/exercise_documents/'.$item->name)}}" download title="Xem">Tải về</a></b></span>
                @if($isEdit)
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFile(this)">Xóa file</button>
                @endif
            </div>
            <input type="hidden" name="fileExerciseOld[]" value="{{$item->name}}" class="file-hidden">
        @endforeach
        <div id="preview" class="file-preview"></div>
    </div>
    @if ($isEdit)
        <div class="col-12 mb-3 text-end">
            <button id="btnEditExercise" class="btn btn-submit-lesson">Chỉnh sửa</button>
        </div>
    @else
        <div class="col-12 mb-3">
            <div class="title-detail"><i class="fa-solid fa-file"></i> File đáp án:</div>
            @foreach ($exercise->lesson->isKeyDocuments as $item)
                <div class="item-key-exercise">
                    <span>{{$item->name}}</span>
                    <b><a href="{{asset('storage/documents/'.$item->name)}}" download title="Tải về">Tải về</a></b>
                </div>
            @endforeach
        </div>
    @endif
    <input type="hidden" name="exerciseId" value="{{$exercise->id}}">
</form>