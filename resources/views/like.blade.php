@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('/css/common/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/record_').strtolower( Request::cookie('mode') ?? 'default' ).'.css?'.time() }}">
@endsection

@section('pageJs')
    <script src="{{ asset('/js/list.js?'.time()) }}"></script>
    <script>
        list.initLiked('#like')
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="css-record-text">{{ __('web.like.Like') }}</div>
        <div class="row" id="like"></div>
    </div>
    @include('common.go_to_top')
@endsection
