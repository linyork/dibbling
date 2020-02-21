@foreach($list as $video)
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
        <div class="card css-list">
            <div class="css-list-img-group">
                <img src="{{ $video->seal }}" class="card-img-top">
                <span class="css-list-duration">{{ floor((($video->duration%86400)%3600)/60).":".str_pad(floor((($video->duration%86400)%3600)%60),2,'0',STR_PAD_LEFT) }}</span>
            </div>
            <div class="card-body container">
                <span class="css-list-name">{{ $video->name }}</span>
                <span class="css-list-title">{{ $video->title }}</span>
            </div>
            <div class="css-list-btn-group">
                <input class="css-list-remove js-remove" data-uid="{{ $video->list_id }}" type="button" value="{{ __('web.list.Remove') }}">
                <input class="css-list-cut js-cut" data-uid="{{ $video->list_id }}" type="button" value="{{ __('web.list.Cut') }}">
            </div>
        </div>
    </div>
@endforeach
