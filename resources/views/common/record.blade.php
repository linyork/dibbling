@foreach($records as $record)
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card css-record">
            <div class="css-record-img-group">
                <a href="{{ App\Helpers\YoutubeHelper::YOUTUBE_LINK . $record->video_id }}" target="_blank"><img src="{{ $record->seal }}" class="card-img-top"></a>
                @if ($record->user_id === Auth::user()->id || Auth::user()->role === 'admin')
                <button type="button" class="css-record-duration left btn btn-sm" data-video_id="{{ $record->video_id }}" data-id="{{ $record->id }}" data-min="{{ $record->min }}" data-max="{{ $record->max }}" data-duration="{{ $record->duration }}" onclick="javascript:list.range('{{ $record->id }}', this)" title='{{ __('web.record.SetRange') }}' >
                    <i class="fa fa-clock"></i>
                </button>
                @endif
                <span class="css-record-duration">{{ floor((($record->duration%86400)%3600)/60).":".str_pad(floor((($record->duration%86400)%3600)%60),2,'0',STR_PAD_LEFT) }}</span>
            </div>
            <div class="card-body container">
                <span class="js-record-name css-record-name" data-uid="{{ $record->user_id }}">{{ $record->name }}</span>
                <span class="css-record-title">{{ $record->title }}</span>
            </div>
            <div class="css-record-btn-group">
                <button data-title="{{ $record->title }}" data-played="{{ $record->deleted_at }}" onclick="javascript:list.info('{{ $record->id }}',this)" type="button" class="btn btn-sm btn-outline-info css-record-btn">
                    <i class="fa fa-info"></i>
                </button>
                <button onclick="javascript:list.{{ !is_null($record->deleted_user) ? 'dibbling' : 'reDibbling' }}('{{ $record->id }}',this)" type="button" class="btn btn-sm btn-outline-warning css-record-btn">
                    {{ __('web.record.Dibbling') }}
                </button>
                <button onclick="javascript:list.remove('{{ $record->id }}',this,true)" type="button" class="btn btn-sm btn-outline-danger css-record-btn">
                    {{ __('web.record.Remove') }}
                </button>
                <button onclick="javascript:list.like('{{ $record->id }}',this)"
                        type="button"
                        class="btn btn-sm btn-outline-primary css-record-btn js-like"
                        data-toggle="tooltip"
                        data-placement="top"
                        data-html="true"
                        @if( $record->likes )
                            title="@foreach($likes as $like)@if($like->list_id == $record->id){{ $like->user->name.'<br>' }} @endif @endforeach"
                        @endif
                >
                    <span>{{ count($likes->where('list_id', $record->id)->toArray()) }}</span>
                    <i class="{{ count($likes->where('list_id', $record->id)->where('user_id', Auth::user()->id)->toArray()) > 0 ? 'fas':'far' }} fa-thumbs-up"></i>
                </button>
            </div>
        </div>
    </div>
@endforeach

@if(count($records) == 0)
    <div data-list="no-data" class="col-12">
        <div class="px-1 py-2 css-list-title">
            {{ __('web.list.NoRecord') }}
        </div>
    </div>
@endif
