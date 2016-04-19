'use strict';

var autoprefixer = require('autoprefixer');
var path = require('path');
var webpack = require('webpack');
var HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
  devtool: 'eval-source-map',
  entry: [
    'babel-polyfill',
    'webpack-hot-middleware/client?reload=true',
    path.join(__dirname, 'app-front/index.js')
  ],
  output: {
    path: path.join(__dirname, '/app-front-dist/'),
    filename: '[name].js',
    publicPath: '/'
  },
  plugins: [
    new HtmlWebpackPlugin({
      template: 'app-front/index.tpl.html',
      inject: 'body',
      filename: 'index.html'
    }),
    new webpack.optimize.OccurenceOrderPlugin(),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoErrorsPlugin(),
    new webpack.DefinePlugin({'process.env.NODE_ENV': JSON.stringify('development')})
  ],
  module: {
    loaders: [
	{
      test: /\.js?$/,
      exclude: /node_modules/,
      loader: 'babel',
      query: {
        "presets": ["react", "es2015", "stage-0", "react-hmre"]
	  }
    },
	{test: /\.json?$/,loader: 'json' },
	{test: /\.scss$/,loaders: ["style", "css", "sass"]},
	{test: /\.(jpe?g|png|gif|svg)$/i,
        loaders: [
            'file?hash=sha512&digest=hex&name=[hash].[ext]',
            'image-webpack?bypassOnDebug&optimizationLevel=7&interlaced=false'
        ]
    }
	]
  },
  node: {fs: 'empty', net: 'empty', tls: 'empty'},
  sassLoader: {includePaths: [path.resolve(__dirname, "./app-front/stylesheets")]},
  resolve: {
    extensions: ['', '.js', '.scss'],
    root: [path.join(__dirname, './app-front')]
  }
};
