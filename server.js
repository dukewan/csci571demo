var http = require('http');

var hostname = '52.79.54.82';
var port = 45678;

http.createServer(function (req, res) {
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('Hello World CSCI571!\n');
}).listen(hostname, port, function () {
  console.log('Server running at http://' + hostname + ':' + port +'/');
});
