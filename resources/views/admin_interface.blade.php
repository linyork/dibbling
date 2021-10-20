@extends('layouts.app')

@section('pageCss')

@endsection

@section('pageJs')
    <script src="/js/admin_interface.js?{{ time() }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="visibility:hidden">
            <div class="col-12">
                <span class="bd-content-title text-secondary">{{ __('web.admin.Broadcast') }}</span>
                <div class="card">
                    <div class="card-body bg-light">
                        <div class="input-group">
                            <input id="broadcast" type="text" class="form-control" placeholder="{{ __('web.admin.PleaseEnter') }}">
                            <div class="input-group-append">
                                <button id="broadcast-button" type="button" class="btn btn-secondary">{{ __('web.admin.Broadcast') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <span class="bd-content-title text-secondary">{{ __('web.admin.Member') }}</span>
                <table class="table table-sm table-hover {{ (Request::cookie('mode') === 'Dark') ? 'table-dark' : ''}}">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('web.admin.Name') }}</th>
                        <th scope="col">{{ __('web.admin.Amount') }}</th>
                        <th scope="col">{{ __('web.admin.Email') }}</th>
                        <th scope="col">{{ __('web.admin.Delete') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\User::select(\DB::raw('count(record.user_id) as count'), \DB::raw('users.*'))->leftJoin('record', 'users.id', '=', 'record.user_id')->groupBy('users.id')->get() as $user)
                        <tr id="user-{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->count }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger {{ ($user->id == Auth::user()->id) ? 'disabled' : 'delete' }}" value="{{ $user->id }}">
                                    {{ __('web.admin.Delete') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
