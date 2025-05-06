@php
    $currentUrl = $_SERVER['REQUEST_URI'];
    $list1 = ["course","unit"];
    $isFound1 = false;
    foreach ($list1 as $item) {
        if (strpos($currentUrl, $item) !== false) {
            $isFound1 = true;
            break;
        }
    }
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
                <li class="nav-item @if ($isFound1 == true) menu-open @endif">
                    <a href="#" class="nav-link @if ($isFound1 == true) active @endif">
                        <i class="nav-icon fa-solid fa-book-open"></i>
                        <p>Quản lý khóa học <i class="nav-arrow fa-solid fa-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('list_course')}}" class="nav-link @if (strpos($currentUrl, 'course') !== false) active @endif">
                                <i class="nav-icon fa-solid fa-list-ul"></i> <p>Danh sách khóa học</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('list_unit')}}" class="nav-link @if (strpos($currentUrl, 'unit') !== false) active @endif">
                                <i class="nav-icon fa-solid fa-list-ul"></i> <p>Danh sách unit</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>