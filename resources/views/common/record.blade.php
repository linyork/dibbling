@foreach($records as $record)
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
        <div class="card css-record">
            <div class="css-record-img-group">
                <img src="{{ $record->seal }}" class="card-img-top">
                <span class="css-record-duration">{{ floor((($record->duration%86400)%3600)/60).":".str_pad(floor((($record->duration%86400)%3600)%60),2,'0',STR_PAD_LEFT) }}</span>
            </div>
            <div class="card-body container">
                <span class="css-record-name">{{ $record->name }}</span>
                <span class="css-record-title">{{ $record->title }}</span>
            </div>
            <div class="css-record-btn-group">
                <input class="css-record-remove js-remove" data-uid="{{ $record->list_id }}" type="button" value="{{ __('web.record.Remove') }}">
                <input class="css-record-dibbling js-dibbling" data-uid="{{ $record->list_id }}" type="button" value="{{ __('web.record.Dibbling') }}">
            </div>
        </div>
    </div>
@endforeach
