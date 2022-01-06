@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('/css/common/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/video_interface.css?').time()  }}">
    <link rel="stylesheet" href="{{ asset('/css/dibbling_' . strtolower(Request::cookie('mode') ?? 'default')) . '.css?'.time() }}">
@endsection

@section('pageJs')
    <script src="{{ asset('/js/dibbling.js?'.time()) }}"></script>
@endsection

@section('content')
    <div id="video-interface"></div>

    <div class="container">

        <div class="row justify-content-center css-dibbling">
            <div class="col-12">
                <span class="bd-content-title text-secondary"><i class="fas fa-search-plus"></i> {{ __('web.dibbling.Dibbling') }}</span>
                <div class="card">
                    <div class="card-body bg-{{ strtolower(Request::cookie('mode') ?? 'light') }}">
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

        <div class="row justify-content-center css-dibbling">
            <div class="col-12">
                <span class="bd-content-title text-secondary"><i class="fas fa-comment-dots"></i> {{ __('web.dibbling.Danmu') }}</span>
                <div class="card">
                    <div class="card-body bg-{{ strtolower(Request::cookie('mode') ?? 'light') }}">
                        <div class="input-group">
                            <input id="danmu-text" type="text" class="form-control" placeholder="{{ __('web.dibbling.Saysomething') }}" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button id="danmu-button" type="button" class="btn btn-secondary">{{ __('web.dibbling.Enter') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
