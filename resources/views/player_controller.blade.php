@extends('layouts.app')

@section('pageJs')
    <script src="/js/player_controller.js?{{ time() }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin-top: 5vh;">
            <div class="col-md-6">
                <div class="card">
                    <h4 class="card-header">{{ __('web.controller.Controller') }}</h4>
                    <div class="card-body">

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">
                                {{ __('web.controller.Controller') }}
                            </label>
                            <div class="col-md-2">
                                <button class="btn btn-success" type="button" value="playVideo" id="play">
                                    {{ __('web.controller.Play') }}
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-secondary" type="button" value="pauseVideo" id="pause">
                                    {{ __('web.controller.Pause') }}
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger" type="button" value="seekTo" id="cut">
                                    {{ __('web.controller.Cut') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">
                                {{ __('web.controller.Voice') }}
                            </label>
                            <div class="col-md-8">
                                <div class="form-group btnDiv">
                                    <div class="col-lg-10">
                                        <input type="range" class="form-control" min="0" max="100" step="5" id="voice" style="padding: unset;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">
                                {{ __('web.controller.Speed') }}
                            </label>
                            <div class="col-md-8">
                                <div class="form-group btnDiv row">
                                    <div class="col-lg-10">
                                        <input type="range" class="form-control" min="0.25" max="2" step="0.25" value="1" id="speed" style="padding: unset;">
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-primary">
                                             <span class="badge badge-light" id="show-speed">1</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-danger" role="alert">
                            群求善心人士幫大家做個好看一點的面板!
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
