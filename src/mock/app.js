const path = require('path');
const fs = require('fs');
const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const glob = require('glob');
// const apiV = require('../js/dev.version.js').apiV;
 
app.engine('html', function (filePath, options, callback) { // define the template engine
    fs.readFile(filePath, function (err, content) {
        if (err) return callback(new Error(err));
        var rendered = content.toString().replace('{$signature}', ''+ JSON.stringify(options.signature)).replace('{$data}','' + JSON.stringify(options.data));
        return callback(null, rendered);
    });
});

app.set('views', './src/views/');
app.set("view engine", "html");
app.use(express.static('./src'));
app.use(bodyParser.json()); // for parsing application/json
app.use(bodyParser.urlencoded({ extended: true })); // for parsing application/x-www-form-urlencoded
app.all("*", function (req, res, next) {
    res.header('Access-Control-Allow-Origin', '*');
    res.header("Access-Control-Allow-Headers", "Content-Type,Content-Length, Authorization, Accept,X-Requested-With");
    res.header("Access-Control-Allow-Methods", "PUT,POST,GET,DELETE,OPTIONS");
    if (req.method == 'OPTIONS') {
        res.send(200);
    } else {
        next();
    }
});

var files = fs.readdirSync('./src/mock/controller/');
// 避免手动require controller文件
files.forEach(function (file) {
    if (file.indexOf('.js') < 0) return;
    require('./controller/' + file)(app);
});


app.listen(1515);
console.log('service is running in localhost:1515');
