#!/usr/bin/env node
const fs = require('fs');
const server = require('https').createServer({
    key: fs.readFileSync('/etc/ssl/private/selfsigned.key'),
    cert: fs.readFileSync('/etc/ssl/certs/selfsigned.crt')
},(req, res) => {
    var headers = {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Methods': 'OPTIONS, POST, GET',
        'Access-Control-Max-Age': 2592000, // 30 days
        'Content-Type': contentType
    };
    fs.readFile(filePath, function(err, content) {
        if (err) {
            // if(err.code == 'ENOENT'){
            //     fs.readFile('./errpages/404.html', function(err, content) {
            //         res.writeHead(404, headers);
            //         res.end(content, 'utf-8');
            //     });
            // }
            // else {
            //     fs.readFile('./errpages/500.html', function(err, content) {
            //         res.writeHead(500, headers);
            //         res.end(content, 'utf-8');
            //     });
            // }
        }
        else {
            res.writeHead(200, headers);
            res.end(content, 'utf-8');
        }
    });

    if (req.method === 'OPTIONS') {
        res.writeHead(204, headers);
        res.end();
    }
});
const io = require('socket.io')(server);


const playerRoom = io.of('player');
playerRoom.on('connection',function(socket) {
    io.emit('log','player is ready');
});

// 當發生連線事件
io.on('connection', (socket) => {

    io.emit('log',' have one ready use connection.');

    // 當有人發送指令時
    socket.on('command', (command) => {
        playerRoom.emit('command',command);
    });

    // 當發生離線事件
    socket.on('disconnect', () => {
        io.emit('log',' have one disconnect.');
    });
});

// 注意，這邊的 server 原本是 app
server.listen(8443, () => {
    console.log("Server Started. http://localhost:8443");
});
