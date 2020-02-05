@extends('layouts.app')

@section('pageJs')
    <script src="/js/record.js?{{ time() }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="card">
                    <h5 class="card-header">Record</h5>
                    <ul class="list-group list-group-flush" id="played-list"></ul>
                </div>
            </div>
        </div>
    </div>
@endsection
