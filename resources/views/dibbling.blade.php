@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm">
            <h1>
                點播系統
                <a id="playing" type="button" class="btn btn-info" target="_blank"></a>
            </h1>
            <span class="badge badge-primary">Client</span>
            <span class="badge badge-secondary">v1.2</span>
            <div class="form-group">
                <input id="video-id" class="form-control">
                <small class="form-text text-muted">請輸入 youtube 影片代碼</small>
                <button type="button" class="btn btn-success">點播</button>
                <button id="refresh" type="button" class="btn btn-info">重新整理</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <h5 class="card-header">點播歌曲</h5>
                <ul class="list-group list-group-flush" id="list"></ul>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <h5 class="card-header">已播歌曲</h5>
                <ul class="list-group list-group-flush" id="played-list"></ul>
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
