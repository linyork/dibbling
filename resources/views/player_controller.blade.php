@extends('layouts.app')

@section('pageJs')
    <script src="/js/player_controller.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="card">
                    <h5 class="card-header">Controller</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-truncate">
                            <button class="command btn btn-danger" type="button" value="seekTo">Cut</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
