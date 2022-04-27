<p>
    <button class="btn btn-{{ isset($likePage) ? 'primary' : 'info' }}" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        {{ __('web.record.SearchBar') }}
    </button>
</p>
<div class="collapse" id="collapseExample">
    <div class="card card-body css-record-search-bar">
        <div class="container">
            <div class="form-group row">
                <div class="input-group col-lg-4 col-md-12">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="user_id">{{ isset($likePage) ? __('web.record.LikedName') : __('web.record.UserName') }}</label>
                    </div>
                    <select class="custom-select" id="user_id">
                        @if(!isset($likePage))
                            <option selected value="0">{{ __('web.record.Choose') }}...</option>
                        @endif
                        @foreach(\App\Model\UserModel::whereNotNull('email_verified_at')->orderBy('name')->get() as $user)
                            <option {{ (isset($likePage) && Auth::user()->id == $user->id) || (isset($user_id) && $user_id == $user->id) ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group col-lg-5 col-md-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ __('web.record.SongName') }}</span>
                    </div>
                    <input id="song_name" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
                <div class="input-group offset-lg-1 col-lg-2 offset-md-8 col-md-4">
                    <select class='custom-select order-list'>
                        <option value="default">{{ __('web.order.Default') }}</option>
                        <option value="played">{{ __('web.order.Played') }}</option>
                        <option value="dibbling">{{ __('web.order.DiCount') }}</option>
                        <option value="likes">{{ __('web.order.LikeCount') }}</option>
                    </select>
                </div>
            </div>

            <div class="form-group row justify-content-end">
                <div class="col-auto">
                    <button id="reset" type="button" class="btn btn-secondary">{{ __('web.record.Reset') }}</button>
                    <button id="search" type="button" class="btn btn-{{ isset($likePage) ? 'primary' : 'info' }}">{{ __('web.record.Search') }}</button>
                </div>
            </div>

        </div>
    </div>
</div>
