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
                    <input id="play" class="col css-video-interface-btn" type="button" value="{{ __('web.controller.Play') }}">
                    <input id="pause" class="col css-video-interface-btn" type="button" value="{{ __('web.controller.Pause') }}" style="margin-left: 20px;margin-right: 20px;">
                    <input id="cut" class="col css-video-interface-btn" type="button" value="{{ __('web.controller.Cut') }}">
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
