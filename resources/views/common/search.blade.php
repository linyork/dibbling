<div class="card">
    <div class="card-body">
        <div class="container">
            <div class="form-group row">

                <div class="input-group col-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">{{ __('web.record.Name') }}</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01">
                        <option selected>{{ __('web.record.Choose') }}...</option>
                        @foreach(\App\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group col-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">{{ __('web.record.SongName') }}</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
            </div>

            <div class="form-group row justify-content-end">
                <div class="col-auto">
                    <button type="button" class="btn btn-secondary">{{ __('web.record.Reset') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('web.record.Search') }}</button>
                </div>
            </div>

        </div>
    </div>
</div>
