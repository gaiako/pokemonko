var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

http.listen(3000, function(){
	console.log('listening on *:3000');
});

var PLAYERS = {};
var SOCKETS = {};

var Player = function(id){
	var self = {
		x:0,
		y:0,
		look:'down',
		id:id
	}
}

io.on('connection', function(socket){
	socket.id = Math.random();

	var player = Player(socket.id);
	PLAYERS[socket.id] = player;

	socket.on('disconnect', function(){
		delete PLAYER[socket.id];
	});
});

setInterval(function(){
	var pack = [];
	for(var i in PLAYERS){

	}
},1000/25);