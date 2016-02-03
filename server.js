const http = require('http');

http.createServer(function (req, res) {
  res.writeHead(200, { 'Content-Type': 'text/plain' });
  res.end('Hello World CSCI571!\n');
}).listen(process.env.PORT, process.env.IP, function () {
  console.log(`Server running at http://${process.env.IP}:${process.env.PORT}/`);
});