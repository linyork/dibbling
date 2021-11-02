@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('/css/common/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/record_').strtolower( Request::cookie('mode') ?? 'default' ).'.css?'.time() }}">
@endsection

@section('pageJs')
    <script src="{{ asset('/js/like.js?'.time()) }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="css-list-text">{{ __('web.like.Like') }}</div>
        <div class="row" id="like"></div>
    </div>
@endsection
