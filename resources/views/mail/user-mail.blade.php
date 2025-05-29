<!DOCTYPE html>
    <html>
        <head>
            <title>Thư thông tin tài khoản</title>
        </head>
    <body>
        <b>Xin chào {{$details['name']}},</b>
        <p>Đây là thông tin tài khoản của bạn.</p>
        <ul>
            <li>Email: {{$details['email']}}</li>
            <li>Mật khẩu: {{$details['password']}}</li>
        </ul>
        <p>Vui lòng nhấp vào đây để <a href="{{$details['url']}}">đăng nhập</a>.</p>
        Trân trọng,<br>
        Admin
    </body>
</html>