@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('/css/setting_').strtolower( Request::cookie('mode') ?? 'default' ).'.css?'.time() }}">
@endsection

@section('pageJs')
    <script src="{{ asset('/js/setting.js?').time() }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 10vh;">
            <div class="col-md-8">
                <div class="card">
                    <h4 class="card-header">{{ __('web.setting.Setting') }}</h4>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('web.setting.Language')}}</label>
                            <div class="col-md-6">
                                @include('common.localebutton')
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('web.setting.Mode')}}</label>
                            <div class="col-md-6">
                                @include('common.mode')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
