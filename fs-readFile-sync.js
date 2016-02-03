var fs = require('fs');

var data = fs.readFileSync('./intro.txt', 'utf8');
console.log(data);