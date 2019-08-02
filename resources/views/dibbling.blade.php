<html>
    <head>
        <script>
            let ws = new WebSocket('ws://local.dibbling.tw:9502');

            //開啟後執行的動作，指定一個 function 會在連結 WebSocket 後執行
            ws.onopen = () => {
                console.log('open connection')
            };

            //關閉後執行的動作，指定一個 function 會在連結中斷後執行
            ws.onclose = () => {
                console.log('close connection')
            };

        </script>
    </head>
    <body>
        <h1>Hello</h1>
    </body>
</html>
