<!DOCTYPE html>
    <html>
        <head>
            <title>Thư cập nhật lại mật khẩu</title>
        </head>
    <body>
        <b>Xin chào {{$details['name']}},</b>
        <p>Đây là mật khẩu mới của bạn.</p>
        <ul>
            <li>Mật khẩu: {{$details['password']}}</li>
        </ul>
        <p>Vui lòng nhấp vào đây để <a href="{{$details['url']}}">đăng nhập</a>.</p>
        Trân trọng,<br>
        Admin
    </body>
</html>