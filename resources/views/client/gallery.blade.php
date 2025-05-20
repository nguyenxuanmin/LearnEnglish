@extends('client.layout.master-page')

@section('title')
    {{$titlePage}}
@endsection

@section('content')
    @include('client.layout.breadcrumb')
    <div class="container">
        <div class="row">
            @foreach ($galleries as $gallery)
                <div class="col-6 col-lg-4 col-xl-3 mb-3 mb-lg-4">
                    <div class="item-gallery-image">
                        <a href="{{asset('storage/galleries/'.$gallery->image)}}" data-fancybox="gallery" data-caption="{{$gallery->name}}">
                            <img src="{{asset('storage/galleries/'.$gallery->image)}}" alt="{{$gallery->name}}" class="w-100 h-100 object-fit-cover">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection