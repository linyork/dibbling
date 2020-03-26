@extends('layouts.app')

@section('pageCss')

@endsection

@section('pageJs')
    <script src="/js/admin_interface.js?{{ time() }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
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
                    @foreach(\App\User::select(\DB::raw('count(record.user_id) as count'), \DB::raw('users.*'))->leftJoin('record', 'users.id', '=', 'record.user_id')->where('record.record_type', '=', \App\Model\RecordTable::DIBBLING)->groupBy('users.id')->get() as $user)
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
