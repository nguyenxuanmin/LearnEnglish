@php
    $currentUrl = $_SERVER['REQUEST_URI'];
@endphp
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{route('admin')}}" class="brand-link">
            @if (count($company) && $company[0]->logo != "")
                <img src="{{asset('storage/company/logo/'.$company[0]->logo)}}" alt="{{$company[0]->name}}" class="brand-image opacity-75 shadow" />
            @else
                <img src="{{asset('library/admin/AdminLTEFullLogo.png')}}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            @endif
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('list_course')}}" class="nav-link @if (strpos($currentUrl, 'course') !== false) active @endif">
                        <i class="nav-icon fa-solid fa-book-open"></i> <p>Danh sách khóa học</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list_unit')}}" class="nav-link @if (strpos($currentUrl, 'unit') !== false) active @endif">
                        <i class="fa-solid fa-graduation-cap"></i> <p>Danh sách unit</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list_user')}}" class="nav-link @if (strpos($currentUrl, 'user') !== false) active @endif">
                        <i class="nav-icon fa-solid fa-user"></i> <p>Danh sách học viên</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list_progress')}}" class="nav-link @if (strpos($currentUrl, 'progress') !== false) active @endif">
                        <i class="fa-solid fa-graduation-cap"></i> <p>Tiến độ học tập</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list_exercise')}}" class="nav-link @if (strpos($currentUrl, 'exercise') !== false) active @endif">
                        <i class="fa-solid fa-file-lines"></i> <p>Nộp bài tập</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('about')}}" class="nav-link @if (strpos($currentUrl, 'about') !== false) active @endif">
                        <i class="fa-solid fa-circle-info"></i> <p>Giới thiệu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list_slider')}}" class="nav-link @if (strpos($currentUrl, 'slider') !== false) active @endif">
                        <i class="fa-solid fa-image"></i> <p>Slider</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list_blog')}}" class="nav-link @if (strpos($currentUrl, 'blog') !== false) active @endif">
                        <i class="fa-solid fa-blog"></i> <p>Blog</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list_feedback')}}" class="nav-link @if (strpos($currentUrl, 'feedback') !== false) active @endif">
                        <i class="fa-solid fa-message"></i> <p>Feedback</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list_gallery')}}" class="nav-link @if (strpos($currentUrl, 'gallery') !== false) active @endif">
                        <i class="fa-solid fa-images"></i> <p>Thư viện ảnh</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list_contact')}}" class="nav-link @if (strpos($currentUrl, 'contact') !== false) active @endif">
                        <i class="fa-solid fa-comment"></i> <p>Liên hệ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('list_register_course')}}" class="nav-link @if (strpos($currentUrl, 'register-course') !== false) active @endif">
                        <i class="fa-solid fa-user-plus"></i> <p>Đăng ký khóa học</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('company')}}" class="nav-link @if (strpos($currentUrl, 'company') !== false) active @endif">
                        <i class="fa-solid fa-house"></i> <p>Thông tin công ty</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>