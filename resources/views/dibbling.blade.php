<html>
<head>
    <link rel="stylesheet" href="{{ URL::asset('css/common/bootstrap.css') }}">
    <script src="{{ asset('js/common/jquery-3.4.1.js')}}"></script>
    <script src="{{ asset('js/common/bootstrap.js')}}"></script>
    <script src="{{ asset('js/dibbling.js')}}"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm">
            <h1>
                點播系統
                <button id="playing" type="button" class="btn btn-info"></button>
            </h1>
            <span class="badge badge-primary">Client</span>
            <span class="badge badge-secondary">v1.1</span>
            <div class="form-group">
                <input id="video-id" class="form-control">
                <small class="form-text text-muted">請輸入 youtube 影片代碼</small>
                <button type="button" class="btn btn-success">點播</button>
                <button id="refresh" type="button" class="btn btn-info">重新整理</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <h5 class="card-header">點播歌曲</h5>
                <ul class="list-group list-group-flush" id="list">

                </ul>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <h5 class="card-header">已播歌曲</h5>
                <ul class="list-group list-group-flush" id="played-list">
                    <li class='list-group-item'>

                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>

</body>
</html>
