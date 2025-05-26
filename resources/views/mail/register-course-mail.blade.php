<!DOCTYPE html>
    <html>
        <head>
            <title>Thư đăng ký khóa học</title>
        </head>
    <body>
        <b>Xin chào Admin,</b>
        <p>Bạn có một người dùng đăng ký khóa học.</p>
        <ul>
            <li>Họ và tên: {{$details['name']}}</li>
            <li>Email: {{$details['email']}}</li>
            <li>Số điện thoại: {{$details['phone']}}</li>
            <li>Khóa học đăng ký: {{$details['course']}}</li>
        </ul>
        Trân trọng,<br>
        System
    </body>
</html>