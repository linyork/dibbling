#!/usr/bin/env node
const port = 8443;
const server = require('http').createServer();
const io = require('socket.io')(server);
const log = require('simple-node-logger').createSimpleFileLogger('/var/log/node/node.log');

const playerRoom = io.of('socket/player');
playerRoom.on('connection', function (socket) {
    log.info('some one connetion player.');

    socket.on('playing', () => {
        log.info('player change video.');
        otherRoom.emit('playing');
    });
});

const otherRoom = io.of('socket');
otherRoom.on('connection', (socket) => {
    // log
    log.info('some one connetion.');
    socket.on('intoDibbling', (name) => {
        log.info(name + ' into dibbling page.');
    });
    socket.on('intoController', (name) => {
        log.info(name + ' into controller page.');
    });


    // 當有人發送指令時
    socket.on('command', (command) => {
        log.info('command: ' + command + '.');
        playerRoom.emit('command', command);
    });

    // 當發生離線事件
    socket.on('disconnect', () => {
        log.info('some one disconnect.');
    });
});

// 注意，這邊的 server 原本是 app
server.listen(port, () => {
    log.info("Server Started. http://localhost:" + port + ".");
});
