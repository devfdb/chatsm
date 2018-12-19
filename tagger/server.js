var express = require('express');

var express = require('express');
var serveStatic = require('serve-static');
var path = require('path');
var cors = require('cors');
const port = process.env.PORT || 5656;

var app = express();
app.use(serveStatic(path.join(__dirname,"dist")));
app.use(cors());

var mongoose = require('mongoose');
var uri = 'mongodb://192.168.1.113:27017/twitter';
const db = mongoose.connect(uri);

var bodyParser = require('body-parser');
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: true}));

var twitterRouter = require('./api/routes/twitterRouter');
app.use('/api/twitter', twitterRouter);

app.listen(port);
console.log('server started '+ port);
