<!DOCTYPE html>
<html>
    <head>
        <title>Thư thông báo nộp bài tập</title>
    </head>
    <body>
        <b>Xin chào {{$details['name']}},</b>
        <p>Bạn có một bài tập cần nộp trước ngày {{$details['deadline']}}.</p>
        <p>Thông tin bài học cần nộp:</p>
        <ul>
            <li>Unit : {{$details['unit']}}</li>
            <li>Bài học : {{$details['lesson']}}</li>
        </ul>
        Trân trọng,<br>
        Admin
    </body>
</html>