@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="/css/video_interface.css?{{ time() }}">
    <link rel="stylesheet" href="/css/dibbling_{{ strtolower( Request::cookie('mode') ?? 'default' ) }}.css?{{ time() }}">
@endsection

@section('pageJs')
    <script src="/js/dibbling.js?{{ time() }}"></script>
@endsection

@section('content')
    <div id="video-interface"></div>

    <div class="container">

    <div class="row justify-content-center css-dibbling">
        <div class="col-12">
            <span class="bd-content-title text-secondary">{{ __('web.dibbling.Dibbling') }}</span>
            <div class="card">
                <div class="card-body bg-light">
                    <div class="input-group">
                        <input id="video-id" type="text" class="form-control" placeholder="{{ __('web.dibbling.PleaseEnterUrl') }}" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id="dibbling-button" type="button" class="btn btn-secondary">{{ __('web.dibbling.Enter') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
