<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"><i class="bi bi-list"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i> <span class="navbar-badge badge text-bg-warning">1</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">Có 1 liên hệ chưa đọc</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-envelope me-2"></i> aaa
                        <span class="float-end text-secondary fs-7">3h</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer"> Xem tất cả liên hệ </a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{asset('library/admin/user-01.png')}}" class="user-image rounded-circle shadow" alt="{{Auth::User()->name}}"/>
                    <span class="d-none d-md-inline">{{Auth::User()->name}}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{asset('library/admin/user-01.png')}}" class="rounded-circle shadow" alt="{{Auth::User()->name}}"/>
                        <p>{{Auth::User()->name}}</p>
                    </li>
                    <li class="user-footer">
                        <a href="{{route('logout')}}" class="btn btn-default btn-flat float-end">Đăng xuất</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>