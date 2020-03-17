@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/common/fontawesome.css') }}">
    <link rel="stylesheet" href="/css/record_{{ strtolower( Request::cookie('mode') ?? 'default' ) }}.css?{{ time() }}">
@endsection

@section('pageJs')
    <script src="/js/record.js?{{ time() }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="css-record-text">{{ __('web.record.Search') }}</div>
        @include('common.search')
        <div class="css-record-text">{{ __('web.record.Record') }}</div>
        <div class="row" id="record-list"></div>
    </div>
@endsection
