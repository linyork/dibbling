#!/usr/bin/env node
const fs = require('fs');
const server = require('https').createServer({
    key: fs.readFileSync('/etc/ssl/private/selfsigned.key'),
    cert: fs.readFileSync('/etc/ssl/certs/selfsigned.crt'),
    origins: '*:*'
});
const io = require('socket.io')(server);

const playerRoom = io.of('socket/player');
playerRoom.on('connection',function(socket) {
    console.log('some one connetion player');
});

const otherRoom = io.of('socket');
otherRoom.on('connection', (socket) => {
    console.log('some on connetion');

    // 當有人發送指令時
    socket.on('command', (command) => {
        console.log(command);
        playerRoom.emit('command',command);
    });

    // 當發生離線事件
    socket.on('disconnect', () => {
        console.log('some on disconnect');
    });
});

// 注意，這邊的 server 原本是 app
server.listen(8443, () => {
    console.log("Server Started. https://localhost:8443");
});
