@if(isset($playing))
    <div class="row justify-content-center card-margin-bottom css-video-interface">
        <div class="css-video-interface-bg" style="background-image: url('{{ $playing->seal }}');"></div>
        <div class="container css-video-interface-con">
            <div class="justify-content-center">
                <div class="container col-lg-6 justify-content-center ">
                    <div class="row justify-content-center css-video-interface-seal">
                        <div class="css-video-img-group">
                            <img src="{{ $playing->seal }}" style="margin-top: -32px; max-width: 336px;">
                            <span class="css-video-duration"><output id='duration'></output>{{ floor((($playing->duration%86400)%3600)/60).":".str_pad(floor((($playing->duration%86400)%3600)%60),2,'0',STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                    <div class="row justify-content-center css-video-interface-title">
                        <span>{{ $playing->title }}</span>
                    </div>
                    <div class="row justify-content-center css-video-interface-name">
                        <span class="css-video-interface-name-text">{{ $dibblingUser->name }}</span>
                    </div>
                    <div class="row justify-content-center css-video-interface-next">
                        <span><i class="fas fa-angle-double-right"></i>{{ __('web.dibbling.Next') }}: <output id='nextTitle' data-id="{{ $next->id ?? '' }}">{{ $next->title ?? __('web.dibbling.Random') }}</output></span>
                    </div>
                    <div class="row justify-content-center css-video-interface-btn-group">
                        <button id="play" type="button" class="col css-video-interface-btn btn btn-{{ strtolower(Request::cookie('mode') ?? 'light') }}"><i class="fas fa-play d-none d-sm-inline"></i> 
                            {{ __('web.controller.Play') }}
                        </button>
                        <button id="pause" type="button" class="col css-video-interface-btn btn btn-{{ strtolower(Request::cookie('mode') ?? 'light') }}" style="margin-left: 20px;margin-right: 10px;"><i class="fas fa-pause d-none d-sm-inline"></i> 
                            {{ __('web.controller.Pause') }}
                        </button>
                        <button id="cut" data-id="{{ $playing->id }}" type="button" class="col css-video-interface-btn btn btn-{{ strtolower(Request::cookie('mode') ?? 'light') }}" style="margin-left: 10px;margin-right: 20px;"><i class="fas fa-stop d-none d-sm-inline"></i> 
                            {{ __('web.controller.Cut') }}
                        </button>
                        <button id="like"
                                type="button"
                                class="col css-video-interface-btn btn btn-{{ strtolower(Request::cookie('mode') ?? 'light') }}"
                                data-id="{{ $playing->id }}"
                                data-toggle="tooltip"
                                data-placement="top"
                                @if( count($likes))
                                    title="@foreach($likes as $like){{ "#".$like->user->name }} @endforeach"
                                @endif
                        >
                            <span>{{ count($likes) }}</span>
                            @if( $isLike )
                                <i class="fas fa-thumbs-up"></i>
                            @else
                                <i class="far fa-thumbs-up"></i>
                            @endif
                        </button>
                    </div>
                    @can('admin')
                        <div class="row">
                            <span class=" css-video-interface-voice"><i class="fab fa-youtube"></i> {{ __('web.controller.Time') }} : <output id='durationRange'>0:00</output></span>
                        </div>
                        <div class="row">
                            <input type="range" class="css-interface-scroll" min="0" max="{{ $playing->duration }}" step="1" value="0" id="time" style="padding: unset;">
                        </div>
                    @endcan
                    <div class="row">
                        <span class=" css-video-interface-voice"><i class="fas fa-volume-up"></i> {{ __('web.controller.Voice') }} : <output id='voiceRange'>100</output>%</span>
                    </div>
                    <div class="row">
                        <input type="range" class="css-interface-scroll" min="0" max="100" step="1" value="100" id="voice" style="padding: unset;">
                    </div>
                    <div class="row">
                        <span class=" css-video-interface-speed"><i class="fas fa-forward"></i> {{ __('web.controller.Speed') }} : <output id='speedRange'>1</output>x</span>
                    </div>
                    <div class="row">
                        <input type="range" class="css-interface-scroll" min="0.25" max="2" step="0.25" value="1" id="speed" style="padding: unset;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
