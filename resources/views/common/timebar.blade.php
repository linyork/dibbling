<p>
    <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapse" aria-expanded="false" aria-controls="collapse">
        {{ __('web.record.SearchBar') }}
    </button>
</p>
<div class="collapse" id="collapse">
    <div class="card card-body css-record-search-bar">
        <div class="container">
            <div class="form-group row">
                <div class="input-group col-lg-8 col-md-12">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="start_date">{{  __('web.timeline.Startdate') }}</label>
                    </div>
                        <input type="date" class="form-control start-date" name="start_date" value="{{ $start_date }}">
                        <label class="input-group-text" for="end_date">{{ __('web.timeline.Enddate') }}</label>
                        <input type="date" class="form-control end-date" name="end_date" value="{{ $end_date }}">
                </div>
                <div class="input-group offset-lg-2 col-lg-2 offset-md-8 col-md-4">
                    <select class='custom-select order-list' name="order">
                        <option value="0">{{ __('web.order.All') }}</option>
                        <option value="1">{{ __('web.order.Dibbling') }}</option>
                        <option value="2">{{ __('web.order.ReDibbling') }}</option>
                        <option value="3">{{ __('web.order.Cut') }}</option>
                        <option value="5">{{ __('web.order.Liked') }}</option>
                    </select>
                </div>
            </div>

            <div class="form-group row justify-content-end">
                <div class="col-auto">
                    <button type="button" class="btn btn-dark collapse-all">{{ __('web.timeline.Collapse') }}</button>
                    <button id="reset" type="button" class="btn btn-secondary">{{ __('web.record.Reset') }}</button>
                    <button id="search" type="button" class="btn btn-info">{{ __('web.record.Search') }}</button>
                </div>
            </div>

        </div>
    </div>
</div>

