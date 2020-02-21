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
        // log.info(socket.name + ' disconnect.');
    });

    // log
    socket.on('intoDibbling', (data) => {
        socket.user = data;
        // log.info(name + ' into dibbling page.');
    });

    // command
    socket.on('command', (command) => {
        log.info('command: ' + command + '.');
        playerRoom.emit('command', command);
    });

    // chart
    socket.on('chat', (chat) => {
       log.info(socket.name + ': ' + chat + '.');
        otherRoom.emit('chat', socket.user.name + ': ' + chat + '.');
    });
});

// 注意，這邊的 server 原本是 app
server.listen(port, () => {
    log.info("Server Started. http://localhost:" + port + ".");
});
