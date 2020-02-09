@extends('layouts.app')

@section('pageCss')
    <style>
        .card-margin-bottom {
            margin-bottom: 20px;

        }

        .playing {
            width: 100%;
        }
    </style>
@endsection

@section('pageJs')
    <script src="/js/dibbling.js?{{ time() }}"></script>
@endsection

@section('content')
<div class="container">

    <div class="row justify-content-center card-margin-bottom">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <a id="playing" type="button" class="btn btn-dark playing" target="_blank"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center card-margin-bottom">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{ __('web.dibbling.PleaseEnterUrl') }}" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id="dibbling-button" type="button" class="btn btn-success">{{ __('web.dibbling.Enter') }}</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center card-margin-bottom">
        <div class="col-md-6">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">公告</h4>
                <p>有興趣製作Dibblig的大大請私訊York 已有 白白 DZ 相繼參與</p>
                <p>音量功能暫無效果 因<a href="https://developers.google.com/youtube/iframe_api_reference" target="_blank">youtubeSDK</a> 調整音量不支援移動裝置</p>
                <hr>
                <p class="mb-0">考慮新增功能</p>
                <p class="mb-0">1) Google 小姐廣播功能</p>
                <p class="mb-0">2) 彈幕功能</p>
            </div>
        </div>
    </div>
    
</div>


<!-- Modal -->
<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <iframe style="width: auto;" id="YouTubeVideoPlayer" frameborder="0" allowfullscreen="1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" title="YouTube video player" width="640" height="360" src="https://www.youtube.com/embed/H4vrIS2gc4k?autoplay=0&amp;controls=1&amp;showinfo=0&amp;modestbranding=1&amp;loop=0&amp;fs=0&amp;cc_load_policty=0&amp;iv_load_policy=3&amp;autohide=0&amp;enablejsapi=1&amp;origin=http%3A%2F%2Flocal.dibbling.tw&amp;widgetid=1"></iframe>
        </div>
    </div>
</div>
@endsection
