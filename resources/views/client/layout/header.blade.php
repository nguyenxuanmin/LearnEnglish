@php
    $currentUrl = $_SERVER['REQUEST_URI'];
@endphp
<header>
    <div class="top-header">
        <div class="container">
            <div class="top-header-content">
                <div class="top-header-left">
                    <i class="fa-solid fa-location-dot"></i> {{$company[0]->address}}
                </div>
                <div class="top-header-right">
                    <a href=""><i class="fa-solid fa-envelope"></i> {{$company[0]->email}}</a>
                    <a href=""><i class="fa-solid fa-phone"></i> {{$company[0]->hotline}}</a>
                </div>
            </div>
        </div>
    </div>
    <div id="header">
        <div class="container">
            <div class="item-header">
                <div class="item-logo">
                    <a href="{{route('index')}}">
                        @if (count($company) && $company[0]->logo != "")
                            <img src="{{asset('storage/company/logo/'.$company[0]->logo)}}" alt="{{$company[0]->name}}" class="object-fix">
                        @else
                            LOGO
                        @endif
                    </a>
                </div>
                <ul class="item-nav">
                    <li>
                        <a href="{{route('client_about')}}" @if (strpos($currentUrl, 'gioi-thieu') !== false) class="active" @endif>Giới thiệu</a>
                    </li>
                    <li>
                        <a href="{{route('course')}}" @if (strpos($currentUrl, 'khoa-hoc') !== false) class="active" @endif>Khóa học</a>
                    </li>
                    <li>
                        <a href="{{route('blog')}}" @if (strpos($currentUrl, 'chia-se-kien-thuc') !== false) class="active" @endif>Chia sẻ kiến thức</a>
                    </li>
                    <li>
                        <a href="{{route('gallery')}}" @if (strpos($currentUrl, 'thu-vien-anh') !== false) class="active" @endif>Thư viện ảnh</a>
                    </li>
                    <li>
                        <a href="#contact">Liên hệ</a>
                    </li>
                </ul>
                <div class="item-menu-user">
                    <a id="itemMenuMobile" href="javascript:void(0)"><i class="fa fa-bars" aria-hidden="true"></i></a>
                    <div class="item-user-header">
                        <a id="itemDisplayUser" href="javascript:void(0)"><i class="fa-solid fa-user"></i></a>
                        <div class="item-user-header-content">
                            @if (Auth::check())
                                <a href="">Thông tin tài khoản</a>
                                <a href="">Khóa học đang học</a>
                                <a href="{{route('logout_client')}}">Đăng xuất</a>
                            @else
                                <a href="{{route('login_client')}}">Đăng nhập</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="menuMobile">
    <a id="itemHideMenu" href="javascript:void(0)"><i class="fa-solid fa-xmark"></i></a>
    <div class="item-logo-mobile">
        <a href="{{route('index')}}">
            @if (count($company) && $company[0]->logo != "")
                <img src="{{asset('storage/company/logo/'.$company[0]->logo)}}" alt="{{$company[0]->name}}" class="object-fix">
            @else
                LOGO
            @endif
        </a>
    </div>
    <ul>
       <li>
            <a href="{{route('client_about')}}"  @if (strpos($currentUrl, 'gioi-thieu') !== false) class="active" @endif>Giới thiệu</a>
        </li>
        <li>
            <a href="{{route('course')}}" @if (strpos($currentUrl, 'khoa-hoc') !== false) class="active" @endif>Khóa học</a>
        </li>
        <li>
            <a href="{{route('blog')}}" @if (strpos($currentUrl, 'chia-se-kien-thuc') !== false) class="active" @endif>Chia sẻ kiến thức</a>
        </li>
        <li>
            <a href="{{route('gallery')}}" @if (strpos($currentUrl, 'thu-vien-anh') !== false) class="active" @endif>Thư viện ảnh</a>
        </li>
        <li>
            <a href="#contact">Liên hệ</a>
        </li>
    </ul>
</div>