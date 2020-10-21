#!/usr/bin/env node
const port = 8443;
const server = require('http').createServer();
const io = require('socket.io')(server);
const log = require('simple-node-logger').createSimpleFileLogger('/var/log/node/node.log');

// player connection
const playerRoom = io.of('socket/player');
playerRoom.on('connection', function (socket) {
    socket.on('playing', () => {
        otherRoom.emit('playing');
    });
});

// connection
const otherRoom = io.of('socket');
otherRoom.on('connection', (socket) => {
    // disconnect
    socket.on('disconnect', () => {
    });

    // log
    socket.on('intoDibbling', (data) => {
        socket.user = data;
        // console.log(new Date() + ' '+ socket.user.name + ' into dibbling page.');
        // log.info(socket.user.name + ' into dibbling page.');
    });

    // command
    socket.on('command', (command) => {
        // console.log(new Date() + ' '+ socket.user.name + ' command: ' + command + '.');
        // log.info(socket.user.name + ' command: ' + command + '.');
        playerRoom.emit('command', command);
    });

    // danmu
    socket.on('danmu', (message) => {
        // console.log(new Date() + ' '+ socket.user.name + ' message: ' + message + '.');
        log.info(new Date() + ' '+ socket.user.name + ' : ' + message);
        otherRoom.emit('danmu', socket.user.name + ' : ' + message);
    });

    // chart
    socket.on('chat', (chat) => {
        // console.log(new Date() + ' '+ socket.user.name + ': ' + chat + '.');
        // log.info(socket.user.name + ': ' + chat + '.');
        otherRoom.emit('chat', socket.user.name + ': ' + chat + '.');
    });

    // broadcast
    socket.on('broadcast', (result) => {
        playerRoom.emit('broadcast', result);
    });
});

// 注意，這邊的 server 原本是 app
server.listen(port, () => {
    // console.log(new Date() + ' '+  "Server Started. http://localhost:" + port + ".");
    log.info("Server Started. http://localhost:" + port + ".");
});
