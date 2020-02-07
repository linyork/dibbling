#!/usr/bin/env node
const express = require('express');
const app = express();
app.set('trust proxy', true);
app.get("/", (req, res, next) => {
    res.end(req.ip);
});

const server = require('http').Server(app);
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
        io.emit('log',' have one disconnect.');
    });
});

// 注意，這邊的 server 原本是 app
server.listen(8443, () => {
    console.log("Server Started. http://localhost:8443");
});
