var http = require('http');

// var hostname = '52.79.54.82';
// var port = Math.random() * 88888 + 10000;
var hostname = '127.0.0.1';
var port = 1337;

var server = http.createServer(function (req, res) {
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('Hello World CSCI571!\n');
});

server.listen(port, function () {
  console.log('Server running at http://' + hostname + ':' + port +'/');
});
