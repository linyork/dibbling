@foreach($records as $record)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card css-record">
            <div class="css-record-img-group">
                <img src="{{ $record->seal }}" class="card-img-top">
                <span class="css-record-duration">{{ floor((($record->duration%86400)%3600)/60).":".str_pad(floor((($record->duration%86400)%3600)%60),2,'0',STR_PAD_LEFT) }}</span>
            </div>
            <div class="card-body container">
                <span class="js-record-name css-record-name" data-uid="{{ $record->user_id }}">{{ $record->name }}</span>
                <span class="css-record-title">{{ $record->title }}</span>
            </div>
            <div class="css-record-btn-group">
                <button data-uid="{{ $record->id }}" type="button" class="btn btn-sm btn-outline-warning js-dibbling css-record-btn">
                    {{ __('web.record.Dibbling') }}
                </button>
                <button data-uid="{{ $record->id }}" type="button" class="btn btn-sm btn-outline-danger js-remove css-record-btn">
                    {{ __('web.record.Remove') }}
                </button>
                <button data-uid="{{ $record->id }}"
                        type="button"
                        class="btn btn-sm btn-outline-primary js-like css-record-btn"
                        data-toggle="tooltip"
                        data-placement="top"
                        @if( ($record->name == Auth::user()->name || Auth::user()->role == \App\User::ROLE_ADMIN) && $record->likes )title="@foreach($likes as $like)@if($like->list_id == $record->id){{ "#".$like->user->name }} @endif @endforeach"@endif
                >
                    <span>{{ $record->likes }}</span>
                    @if(array_key_exists($record->id, $likes->where('user_id', Auth::user()->id)->keyBy('list_id')->toArray()))
                        <i class="fas fa-thumbs-up"></i>
                    @else
                        <i class="far fa-thumbs-up"></i>
                    @endif
                </button>
            </div>
        </div>
    </div>
@endforeach
