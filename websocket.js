#!/usr/bin/env node
const port = 8443;
const server = require('http').createServer();
const io = require('socket.io')(server);
const log = require('simple-node-logger').createSimpleFileLogger('/var/log/node/node.log');

// player connection
const playerRoom = io.of('socket/player');
playerRoom.on('connection', function (socket) {
    log.info('some one connetion player.');

    socket.on('playing', () => {
        log.info('player change video.');
        otherRoom.emit('playing');
    });
});

// connection
const otherRoom = io.of('socket');
otherRoom.on('connection', (socket) => {
    // disconnect
    socket.on('disconnect', () => {
        log.info('some one disconnect.');
    });

    // log
    log.info('some one connetion.');
    socket.on('intoDibbling', (name) => {
        socket.name = name;
        log.info(name + ' into dibbling page.');
    });
    socket.on('intoController', (name) => {
        socket.name = name;
        log.info(name + ' into controller page.');
    });

    // command
    socket.on('command', (command) => {
        log.info('command: ' + command + '.');
        playerRoom.emit('command', command);
    });

    // chart
    socket.on('chat', (chat) => {
       log.info(socket.name + ': ' + chat + '.');
        otherRoom.emit('chat', socket.name + ': ' + chat + '.');
    });
});

// 注意，這邊的 server 原本是 app
server.listen(port, () => {
    log.info("Server Started. http://localhost:" + port + ".");
});
