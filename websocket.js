#!/usr/bin/env node
const fs = require('fs');
const server = require('https').createServer({
    key: fs.readFileSync('/etc/ssl/private/selfsigned.key'),
    cert: fs.readFileSync('/etc/ssl/certs/selfsigned.crt')
});
const io = require('socket.io')(server);
io.set('origins', '*:*');


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
server.listen(8443, '');
