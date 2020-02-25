<div class="row justify-content-center card-margin-bottom css-video-interface">
    <div class="css-video-interface-bg" style="background-image: url('{{ $playing['seal'] }}');"></div>
    <div class="container css-video-interface-con">
        <div class="justify-content-center">
            <div class="container col-lg-5 justify-content-center ">
                <div class="row justify-content-center css-video-interface-seal">
                    <img src="{{ $playing['seal'] }}" style="margin-top: -32px; max-width: 336px;">
                </div>
                <div class="row justify-content-center css-video-interface-title">
                    <span>{{ $playing['title'] }}</span>
                </div>
                <div class="row justify-content-center css-video-interface-name">
                    <span class="css-video-interface-name-text">{{ $playing['name'] }}</span>
                </div>
                <div class="row justify-content-center css-video-interface-next">
                    <span>》下一首: {{ $next['title'] }}</span>
                </div>
                <div class="row justify-content-center css-video-interface-btn-group">
                    <button id="play" type="button" class="col css-video-interface-btn btn btn-light">
                        {{ __('web.controller.Play') }}
                    </button>
                    <button id="pause" type="button" class="col css-video-interface-btn btn btn-light" style="margin-left: 20px;margin-right: 10px;">
                        {{ __('web.controller.Pause') }}
                    </button>
                    <button id="cut" type="button" class="col css-video-interface-btn btn btn-light" style="margin-left: 10px;margin-right: 20px;">
                        {{ __('web.controller.Cut') }}
                    </button>
                    <button id="like" type="button" class="col css-video-interface-btn btn btn-light" data-id="{{ $playing['id'] }}">
                        <span>{{ count($likes) }}</span>
                        @if($isLike)
                            <i class="fas fa-thumbs-up"></i>
                        @else
                            <i class="far fa-thumbs-up"></i>
                        @endif
                    </button>
                </div>
                <div class="row">
                    <span class=" css-video-interface-voice">{{ __('web.controller.Voice') }}</span>
                </div>
                <div class="row">
                    <input type="range" class="css-interface-scroll" min="0" max="100" step="5" value="100" id="voice" style="padding: unset;">
                </div>
                <div class="row">
                    <span class=" css-video-interface-speed">{{ __('web.controller.Speed') }}</span>
                </div>
                <div class="row">
                    <input type="range" class="css-interface-scroll" min="0.25" max="2" step="0.25" value="1" id="speed" style="padding: unset;">
                </div>
            </div>
        </div>
    </div>
</div>
