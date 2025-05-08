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
                        @php $disabled_line = false; @endphp
                        @if(isset($likePage))
                            @php
                                $users = \App\Model\UserModel::withTrashed()
                                    ->select('users.*', \DB::raw('COUNT(like.id) as count'))
                                    ->join('like', 'users.id', '=', 'like.user_id', 'left')
                                    ->whereNotNull('email_verified_at')->groupBy('users.id')->orderBy('deleted_at')->orderBy('name')->get();
                            @endphp
                        @else
                            <option selected value="0">{{ __('web.record.Choose') }}...</option>
                            @php
                                $users = \App\Model\UserModel::withTrashed()
                                    ->select('users.*', \DB::raw('COUNT(record.id) as count'))
                                    ->join('record', 'users.id', '=', 'record.user_id', 'left')
                                    ->where('record_type', 1)->whereNotNull('email_verified_at')->groupBy('users.id')->orderBy('deleted_at')->orderBy('name')->get();
                            @endphp
                        @endif
                        @foreach($users as $user)
                            @if (!$disabled_line && $user->deleted_at)
                                @php $disabled_line = true; @endphp
                                <option disabled>---------- {{__('web.record.Pending')}} ----------</option>
                            @endif
                            @if (is_null($user->deleted_at) || ($user->deleted_at && $user->count > 0))
                                <option {{ (isset($likePage) && Auth::user()->id == $user->id) || (isset($user_id) && $user_id == $user->id) ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
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
                        <option value="played">{{ __('web.order.Played') }}</option>
                        <option value="record">{{ __('web.order.Record') }}</option>
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
