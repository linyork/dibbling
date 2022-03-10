@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('/css/common/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/timeline_').strtolower( Request::cookie('mode') ?? 'default' ).'.css?'.time() }}">
@endsection

@section('pageJs')
<script src="{{ asset('/js/list.js?').time() }}"></script>
<script>
    list.initTimeline('#timeline')
</script>
@endsection

@section('content')
    <div class="container">
        <div class="css-list-text">{{ __('web.app.Timeline') }}</div>
        @include('common.timebar')

        <div class="timeline">
            <dl id="timeline"></dl>
            <dl>
                <dd class="pos-left clearfix">
                    <div class="circ"></div>
                    <div class="time">{{ date('Y-m-d', strtotime(Auth::user()->created_at)).' '.__('web.app.Register') }}</div>
                    <div class='events' style='visibility:hidden'></div>
                </dd>
            </dl>
        </div>
    </div>
@endsection
