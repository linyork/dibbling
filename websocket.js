#!/usr/bin/env node
const port = 8443;
const server = require('http').createServer();
const io = require('socket.io')(server);
const log = require('simple-node-logger').createSimpleFileLogger('/var/log/node/node.log');
const video = {
    videoId: "建置中",
    title: "建置中",
    next: "建置中",
    duration: 0,
    seal: "建置中",
    volume: 50,
    speed: 1
};

const playerRoom = io.of('socket/player');
playerRoom.on('connection', function (socket) {
    socket.on('join_room', (channel) => {
        if(!socket.adapter.rooms[channel] && (channel === 'tw' || channel === 'jp') ) {
            socket.join(channel);
            socket.channel = channel;
        } else {
            socket.emit('error_room', channel);
        }
    })
    
    socket.on('disconnect', () => {
        socket.leave(socket.channel);
    });
    
    socket.on('playing', () => {
        otherRoom.to(socket.channel).emit('playing');
    });
    
    socket.on('setSync', (data) => {
        var sync = JSON.parse(data)
        video.volume = sync.volume
        video.speed = sync.speed
        video.duration = sync.duration
        otherRoom.to(socket.channel).emit('setSync', data)
    });
});

const otherRoom = io.of('socket');
otherRoom.on('connection', (socket) => {
    socket.on('join_room', (channel) => {
        socket.join(channel);
        socket.channel = channel;
    });
    
    socket.on('disconnect', () => {
        socket.leave(socket.channel);
    });
    
    socket.on('intoDibbling', (data) => {
        socket.user = data;
    });
    
    socket.on('command', (command) => {
        playerRoom.to(socket.channel).emit('command', command);
    });
    
    socket.on('danmu', (message) => {
        log.info(new Date() + ' '+ socket.user.name + ' : ' + message);
        otherRoom.to(socket.channel).emit('danmu', socket.user.name + ' : ' + message);
    });
    
    socket.on('chat', (chat) => {
        otherRoom.to(socket.channel).emit('chat', socket.user.name + ': ' + chat + '.');
    });
    
    socket.on('broadcast', (result) => {
        playerRoom.to(socket.channel).emit('broadcast', result);
    });
    
    socket.on('getSync', (_data) => {
        socket.to(socket.channel).emit('setSync', JSON.stringify(video));
    })
    
    socket.on('next', (title) => {
        otherRoom.to(socket.channel).emit('next', title);
    })

});

// 注意，這邊的 server 原本是 app
server.listen(port, () => {
    log.info("Server Started. http://localhost:" + port + ".");
});
