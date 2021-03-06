@foreach($list as $video)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
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
                <button data-uid="{{ $video->id }}" type="button" class="btn btn-sm btn-outline-danger js-remove css-record-btn">
                    {{ __('web.list.Remove') }}
                </button>
                <button data-uid="{{ $video->id }}" type="button" class="btn btn-sm btn-outline-secondary js-cut css-record-btn">
                    {{ __('web.list.Cut') }}
                </button>
                <button data-uid="{{ $video->id }}" type="button" class="btn btn-sm btn-outline-primary js-like css-record-btn">
                    <span>{{ $video->likes }}</span>
                    @if(array_key_exists($video->id, $likes))
                        <i class="fas fa-thumbs-up"></i>
                    @else
                        <i class="far fa-thumbs-up"></i>
                    @endif
                </button>
            </div>
        </div>
    </div>
@endforeach
