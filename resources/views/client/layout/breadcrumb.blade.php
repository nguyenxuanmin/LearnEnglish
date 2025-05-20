<div class="item-breadcrumb" style="background-image: url({{asset('library/client/bg_breadcrumb.webp')}});">
        <div class="container">
                <div class="item-breadcrumb-content">
                        <h2 class="item-title-breadcrumb">{{$titlePage}}</h2>
                        <div class="item-list-breadcrumb">
                                <a href="{{route('index')}}">Trang chủ</a> / @if (isset($category)) <a href="{{route($categoryLink)}}">{{$category}}</a> / @endif <span>{{$titlePage}}</span>
                        </div>
                </div>
        </div>
</div>