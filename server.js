var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'student',
  password : 'dcdbi1969',
  database : 'exchange'
});

connection.connect();

connection.query('SELECT * from users', function(err, rows, fields) {
  if (!err)
    console.log('The solution is: ', rows);
  else
    console.log('Error while performing Query.',err);
});

connection.end();


/////


/*
require('babel-core/register');
require("babel-polyfill");
*/
/* eslint no-console: 0 */
/*
const path = require('path');
const express = require('express');
const webpack = require('webpack');
const webpackMiddleware = require('webpack-dev-middleware');
const webpackHotMiddleware = require('webpack-hot-middleware');
const config = require('./webpack.config.js');
const graphqlHTTP = require('express-graphql');
const mongoose = require('mongoose');
const schema = require('./graphql');
const isDeveloping = process.env.NODE_ENV !== 'production';
const port = isDeveloping ? 3000 : process.env.PORT;

const app = express();

function req(){
	return {schema: schema, pretty: true};
}

app.use('/graphql', graphqlHTTP(req()));

// Connect mongo database
//mongoose.connect('mongodb://localhost/graphql');

if (isDeveloping) {
  const compiler = webpack(config);
  const middleware = webpackMiddleware(compiler, {
    publicPath: config.output.publicPath,
    contentBase: 'app-front',
    stats: {
      colors: true,
      hash: false,
      timings: true,
      chunks: false,
      chunkModules: false,
      modules: false
    }
  });
  app.use(express.static('app-front-dist/assets'));
  app.use('/', express.static('app-front-dist/assets'));
  app.use(middleware);
  app.use(webpackHotMiddleware(compiler));
  app.get('*', function response(req, res) {
    res.write(middleware.fileSystem.readFileSync(path.join(__dirname, 'app-front-dist/index.html')));
    res.end();
  });
} else {
  app.use(express.static(__dirname + '/app-front-dist'));
  app.get('*', function response(req, res) {
    res.sendFile(path.join(__dirname, 'app-front-dist/index.html'));
  });
}

app.listen(port, '0.0.0.0', function onStart(err) {
  if (err) {
    console.log(err);
  }
  console.info('==> 🌎 Listening on port %s. Open up http://0.0.0.0:%s/ in your browser.', port, port);
});
