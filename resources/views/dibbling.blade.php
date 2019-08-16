<html>
<head>
    <link rel="stylesheet" href="{{ URL::asset('css/common/bootstrap.css') }}">
    <script src="{{ asset('js/common/jquery-3.4.1.js')}}"></script>
    <script src="{{ asset('js/common/bootstrap.js')}}"></script>
    <script src="{{ asset('js/dibbling.js')}}"></script>
</head>
<body>
<div class="row">
    <div class="col-5 col-md-5 col-xl-5 py-md-3 pl-md-5 bd-content">
        <h1>點播系統</h1>
        <span class="badge badge-primary">Client</span>
        <span class="badge badge-secondary">v1.1</span>
        <div class="form-group">
            <input class="form-control" id="video-id">
            <small class="form-text text-muted">請輸入 youtube 影片代碼</small>
            <button type="button" class="btn btn-success">點播</button>
        </div>
        <div class="card">
            <button type="button" class="btn btn-info">重新整理</button>
            <div class="card-body">
                <ul class="list-group" id="list">
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
