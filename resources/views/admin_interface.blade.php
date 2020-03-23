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
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('web.admin.Name') }}</th>
                        <th scope="col">{{ __('web.admin.Email') }}</th>
                        <th scope="col">{{ __('web.admin.Delete') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\User::get() as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button type="button" class="btn btn-danger delete" value="{{ $user->id }}">
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
