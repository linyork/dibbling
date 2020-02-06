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
                                {{ __('web.controller.Cut') }}
                            </label>
                            <div class="col-md-8">
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
                                    <div class="col-lg-12">
                                        <input type="range" class="form-control" min="0" max="100" step="10" id="voice">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
