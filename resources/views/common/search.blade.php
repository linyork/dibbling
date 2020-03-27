<p>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        {{ __('web.record.SearchBar') }}
    </button>
</p>
<div class="collapse" id="collapseExample">
    <div class="card card-body css-record-search-bar">
        <div class="container">
            <div class="form-group row">
                <div class="input-group col-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="user_id">{{ __('web.record.UserName') }}</label>
                    </div>
                    <select class="custom-select" id="user_id">
                        <option selected value="0">{{ __('web.record.Choose') }}...</option>
                        @foreach(\App\User::select(\DB::raw('count(record.user_id) as count'), \DB::raw('users.*'))->leftJoin('record', 'users.id', '=', 'record.user_id')->where('record.record_type', \App\Model\RecordTable::DIBBLING)->orWhere('record.record_type', NULL)->groupBy('users.id')->orderBy('count', 'DESC')->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group col-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ __('web.record.SongName') }}</span>
                    </div>
                    <input id="song_name" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
            </div>

            <div class="form-group row justify-content-end">
                <div class="col-auto">
                    <button id="reset" type="button" class="btn btn-secondary">{{ __('web.record.Reset') }}</button>
                    <button id="search" type="button" class="btn btn-primary">{{ __('web.record.Search') }}</button>
                </div>
            </div>

        </div>
    </div>
</div>
