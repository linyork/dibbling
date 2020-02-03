@extends('layouts.app')

@section('pageJs')
    <script src="/js/dibbling.js"></script>
@endsection

@section('content')
<div class="container">
    <div class="row" style="margin-top: 15vh;">
        <div class="col-sm">
            <div class="card">
                <h4 class="card-header">Dibbling</h4>
                <div class="card-body">
                    <input id="video-id" class="form-control">
                    <small class="form-text text-muted">Please enter youtube video code or url</small>
                    <button id="dibbling-button" type="button" class="btn btn-success">Enter</button>
                </div>
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
