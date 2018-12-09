var express = require('express');
var app = express();
var http = require('http').Server(app);
var io = require('socket.io')(http);

// app.use('/', express.static('www'));

http.listen(8080, function(){
    console.log('listening on *:8080');
});

var redis = require('redis');
var url = "course-redis";
var client1 = redis.createClient(6379, url);

client1.on('message', function(chan, msg) {
    io.sockets.emit("message",msg);
    console.log("emitted message:"+msg);
});

client1.subscribe('messages');