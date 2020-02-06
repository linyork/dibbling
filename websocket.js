#!/usr/bin/env node
const express = require('express');
const app = express();
const server = require('http').Server(app);
const io = require('socket.io')(server);


const playerRoom = io.of('player');
playerRoom.on('connection',function(socket) {
    console .log('player ready');
});

// 當發生連線事件
io.on('connection', (socket) => {
    console.log('welcome');

    // 當有人發送指令時
    socket.on('command', (command) => {
        playerRoom.emit('command',command);
    });

    // 當發生離線事件
    socket.on('disconnect', () => {
        console.log('Bye');
    });
});

// 注意，這邊的 server 原本是 app
server.listen(8443, () => {
    console.log("Server Started. http://localhost:8443");
});
