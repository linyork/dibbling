@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('/css/supporter_').strtolower( Request::cookie('mode') ?? 'default' ).'.css?'.time() }}">
@endsection

@section('pageJs')
@endsection

@section('content')
    <div class="container">
{{--        <div class="css-supporter-text">{{ __('web.app.Supporter') }}</div>--}}
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">{{ __('web.app.Supporter') }}</h4>
                    <hr>
                    <p class="mb-0">感謝他們的貢獻此紀錄來自Git</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">York</h4>
                    <hr>
                    <p class="mb-0">始作俑者</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Fisher</h4>
                    <hr>
                    <p class="mb-0">初版youtubeAPI</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Jason</h4>
                    <hr>
                    <p class="mb-0">打雜</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">白白</h4>
                    <hr>
                    <p class="mb-0">前端設計</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Ashley</h4>
                    <hr>
                    <p class="mb-0">文案翻譯</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Momoka</h4>
                    <hr>
                    <p class="mb-0">文案翻譯及功能建議</p>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Christine</h4>
                    <hr>
                    <p class="mb-0">增加諸多功能及翻新</p>
                </div>
            </div>
        </div>
    </div>
@endsection
