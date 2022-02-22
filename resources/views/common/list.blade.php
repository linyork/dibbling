@foreach($list as $video)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card css-list">
            <div class="css-list-img-group">
                <a href="{{ App\Helpers\YoutubeHelper::YOUTUBE_LINK . $video->video_id }}" target="_blank"><img src="{{ $video->seal }}" class="card-img-top"></a>
                <span class="css-list-duration">{{ floor((($video->duration%86400)%3600)/60).":".str_pad(floor((($video->duration%86400)%3600)%60),2,'0',STR_PAD_LEFT) }}</span>
            </div>
            <div class="card-body container">
                <span class="css-list-name">{{ $video->name }}</span>
                <span class="css-list-title">{{ $video->title }}</span>
            </div>
            <div class="css-list-btn-group">
                <button data-title="{{ $video->title }}" onclick="javascript:list.info('{{ $video->id }}',this)" type="button" class="btn btn-sm btn-outline-info css-record-btn">
                    <i class="fa fa-info"></i>
                </button>
                <button onclick="javascript:list.remove('{{ $video->id }}',this,true)" type="button" class="btn btn-sm btn-outline-danger css-record-btn">
                    {{ __('web.list.Remove') }}
                </button>
                <button onclick="javascript:list.cut('{{ $video->id }}',this)" type="button" class="btn btn-sm btn-outline-secondary css-record-btn">
                    {{ __('web.list.Cut') }}
                </button>
                <button onclick="javascript:list.like('{{ $video->id }}',this)"
                        type="button"
                        data-toggle="tooltip"
                        data-placement="top"
                        data-html="true"
                        class="btn btn-sm btn-outline-primary css-record-btn js-like"
                        @if( $video->likes )
                        title="@foreach($likes as $like)@if($like->list_id == $video->id){{ $like->user->name.'<br>' }} @endif @endforeach"
                        @endif
                >
                    <span>{{ $video->likes }}</span>
                    @if(array_key_exists($video->id, $likes->where('user_id', Auth::user()->id)->keyBy('list_id')->toArray()))
                        <i class="fas fa-thumbs-up"></i>
                    @else
                        <i class="far fa-thumbs-up"></i>
                    @endif
                </button>
            </div>
        </div>
    </div>
@endforeach

@if(count($list) == 0)
    <div data-list="no-data" class="col-12">
        <div class="px-1 py-2 css-list-title">
            {{ __('web.list.NoData') }}
        </div>
    </div>
@endif