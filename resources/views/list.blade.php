@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('/css/common/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/list_').strtolower( Request::cookie('mode') ?? 'default' ).'.css?'.time() }}">
@endsection

@section('pageJs')
    <script src="{{ asset('/js/trigger.js?'.time()) }}"></script>
    <script src="{{ asset('/js/list.js?'.time()) }}"></script>
    <script>
        list.init('#list')
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="css-list-text">{{ __('web.list.List') }}</div>
        <div class="row" id="list"></div>
    </div>
@endsection
