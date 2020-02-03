@extends('layouts.app')

@section('pageJs')
    <script src="/js/list.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="card">
                    <h5 class="card-header">List</h5>
                    <ul class="list-group list-group-flush" id="list"></ul>
                </div>
            </div>
        </div>
    </div>
@endsection
