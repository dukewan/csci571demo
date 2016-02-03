const http = require('http');

http.createServer(function (req, res) {
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('Hello World CSCI571!\n');
}).listen('127.0.0.1', '45678', function () {
  console.log(`Server running at port: 45678`);
});
