@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="/css/list_{{ strtolower( Request::cookie('mode') ?? 'default' ) }}.css?{{ time() }}">
@endsection

@section('pageJs')
    <script src="/js/list.js?{{ time() }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="css-list-text">{{ __('web.list.List') }}</div>
        <div class="row" id="list"></div>
    </div>
@endsection
