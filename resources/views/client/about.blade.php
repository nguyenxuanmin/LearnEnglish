@extends('client.layout.master-page')

@section('title')
    {{$titlePage}}
@endsection

@section('content')
    @include('client.layout.breadcrumb')
    @if (isset($aboutUs))
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 mb-3 mb-lg-4">@php echo $aboutUs->content @endphp</div>
                <div class="col-12 col-lg-6 mb-3 mb-lg-4">
                    <img src="{{asset('storage/abouts/'.$aboutUs->image)}}" alt="Giới thiệu" class="w-100 object-fit-cover">
                </div>
            </div>
        </div>
    @endif
@endsection