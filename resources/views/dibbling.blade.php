<html>
<head>
    <link rel="stylesheet" href="{{ URL::asset('css/common/bootstrap.css') }}">
    <script src="{{ asset('js/common/jquery-3.4.1.js')}}"></script>
    <script src="{{ asset('js/common/bootstrap.js')}}"></script>
    <script>
        var ws = new WebSocket('ws://local.dibbling.tw:9502');

        //開啟後執行的動作，指定一個 function 會在連結 WebSocket 後執行
        ws.onopen = () => {
            console.log('WebSocket open connection')
            ws.send("asdf");
        };

        //關閉後執行的動作，指定一個 function 會在連結中斷後執行
        ws.onclose = () => {
            console.log('WebSocket close connection');
        };

        // dibbling
        $(document).on('click', '.btn-success', function(event){
            var vidoId = $("#video-id").val();
            dibbling(vidoId);
            $("#video-id").val("");
        });

        // onmessage  監聽
        ws.onmessage = (evt) => {
            console.log(evt);
        };

        function dibbling(id) {
            var promise = $.ajax({
                url: '/dibbling/' + id,
                method: "GET",
                dataType: "json",
            });

            promise.done(SuccessMethod);
            promise.fail(FailMethod);
        }

        function SuccessMethod(e) {
            if(e['status'] == 1) {
                console.log('send');
                ws.send("{id:"+e['videoId']+",title:"+e['title']+"}");
            }
            alert(e['msg']);
            console.log(e);
        }

        function FailMethod(e) {
            alert(e);
            console.log(e);
        }
    </script>
    <script>
    </script>
</head>
<body>

<div class="col-5 col-md-5 col-xl-5 py-md-3 pl-md-5 bd-content">
    <h1>點播系統</h1>
    <span class="badge badge-primary">Client</span>
    <span class="badge badge-secondary">v1.0</span>
    <div class="form-group">
        <input class="form-control" id="video-id">
        <small id="emailHelp" class="form-text text-muted">請輸入 youtube 影片代碼</small>
        <button type="button" class="btn btn-success">點播</button>
    </div>
</div>
</body>
</html>
