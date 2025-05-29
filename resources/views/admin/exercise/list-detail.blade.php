 @if (count($exercises) == 0)
    <tr>
        <td valign="middle" align="center" colspan="5">Không có dữ liệu</td>
    </tr>
@endif
@foreach ($exercises as $key => $exercise)
    <tr>
        <td valign="middle" align="center">{{$key+1}}</td>
        <td valign="middle">{{$exercise['name']}}</td>
        <td valign="middle">{{$exercise['lesson']}}</td>
        <td valign="middle" align="center">
            @if ($exercise['status'] == 1)
                <span class="badge text-bg-success">Đã nộp</span>
            @else
                <span class="badge text-bg-info">Chưa nộp</span>
            @endif
        </td>
        <td valign="middle" align="center">
            @if ($exercise['status'] == 1)
                <a href="" class="btn btn-outline-info" title="Xem chi tiết"><i class="fa-solid fa-eye"></i></a>
            @else
                @if ($exercise['deadline'])
                    <button class="btn btn-outline-warning" title="Nhắc nộp bài tập" onclick=""><i class="fa-solid fa-bell"></i></button>
                @endif
            @endif
        </td>
    </tr>
@endforeach