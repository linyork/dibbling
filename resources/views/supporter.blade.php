@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('/css/supporter_').strtolower( Request::cookie('mode') ?? 'default' ).'.css?'.time() }}">
    <link rel="stylesheet" href="{{ asset('/css/common/fontawesome.css') }}">
@endsection

@section('pageJs')
@endsection

@section('content')
    <div class="container">
{{--        <div class="css-supporter-text">{{ __('web.app.Supporter') }}</div>--}}
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="alert alert-{{ strtolower(Request::cookie('mode')) == 'dark' ? 'secondary' : 'warning' }}" role="alert">
                    <h4 class="alert-heading">{{ __('web.app.Supporter') }}</h4>
                    <hr>
                    <p class="mb-0 supporter-comment">{{ __('web.supporter.Title') }}</p>
                </div>
            </div>
            @foreach ($authors as $author => $value)
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="alert alert-{{ strtolower(Request::cookie('mode')) == 'dark' ? 'secondary' : 'warning' }}" role="alert">
                        <h4 class="alert-heading">{{ ucfirst($author) }}
                            @if ($value)
                                <span class="fab fa-github float-right git-space" title="git push {{ $value }} times"> </span>
                            @endif
                        </h4>
                        <hr>
                        <p class="mb-0 supporter-comment">{{ __("web.supporter.".ucfirst($author)) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
