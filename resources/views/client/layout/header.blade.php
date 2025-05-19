<header class="header">
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
                    <a href="">Giới thiệu</a>
                </li>
                <li>
                    <a href="">Khóa học</a>
                </li>
                <li>
                    <a href="">Chia sẻ kiến thức</a>
                </li>
                <li>
                    <a href="">Thư viện</a>
                </li>
                <li>
                    <a href="">Liên hệ</a>
                </li>
            </ul>
            <div class="item-user-header">
                <a id="item-show-user" href="javascript:void(0)"><i class="fa-solid fa-user"></i></a>
                <div class="item-user-header-content">
                    @if (Auth::check())
                        <a href="">Thông tin tài khoản</a>
                        <a href="">Khóa học đang học</a>
                        <a href="">Đăng xuất</a>
                    @else
                        <a href="">Đăng nhập</a>
                    @endif
                </div>
            </div>
            @php
                /*
            @endphp
                        <a class="item-show-menu" href="javascript:void(0)"><i class="fa fa-bars" aria-hidden="true"></i></a>
            @php
                */
            @endphp
        </div>
    </div>
</header>
@php
    /*
@endphp
<div id="menu-mobile">
    <a class="item-hide-menu" href="javascript:void(0)"><i class="fa-solid fa-xmark"></i></a>
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
            <a href="{{route('index')}}#about-us">Về chúng tôi</a>
        </li>
        <li>
            <a href="{{route('index')}}#service">Dịch vụ</a>
        </li>
        <li>
            <a href="{{route('index')}}#transport">Vận chuyển</a>
        </li>
        <li>
            <a href="{{route('index')}}#statistical">Thống kê</a>
        </li>
        <li>
            <a href="{{route('news')}}">Tin Tức</a>
        </li>
        <li>
            <a href="{{route('index')}}#contact">Liên hệ</a>
        </li>
    </ul>
</div>
@php
    */
@endphp