<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="css/common/bootstrap.css">
    <script src="js/common/jquery-3.4.1.js"></script>
    <script src="js/common/bootstrap.js"></script>
    <script src="js/dibbling.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm">
            <h1>
                點播系統
                <a id="playing" type="button" class="btn btn-info" target="_blank"></a>
            </h1>
            <span class="badge badge-primary">Client</span>
            <span class="badge badge-secondary">v1.2</span>
            <div class="form-group">
                <input id="video-id" class="form-control">
                <small class="form-text text-muted">請輸入 youtube 影片代碼</small>
                <button type="button" class="btn btn-success">點播</button>
                <button id="refresh" type="button" class="btn btn-info">重新整理</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <h5 class="card-header">點播歌曲</h5>
                <ul class="list-group list-group-flush" id="list"></ul>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <h5 class="card-header">已播歌曲</h5>
                <ul class="list-group list-group-flush" id="played-list"></ul>
            </div>
        </div>
    </div>
</div>

</body>
</html>
