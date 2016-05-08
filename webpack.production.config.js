'use strict';

var path = require('path');
var webpack = require('webpack');
var HtmlWebpackPlugin = require('html-webpack-plugin');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var StatsPlugin = require('stats-webpack-plugin');
var autoprefixer = require('autoprefixer');

module.exports = {
  entry: [
	'babel-polyfill',
    path.join(__dirname, 'app-front/index.js')
  ],
  output: {
    path: path.join(__dirname, '/app-front-dist/'),
    filename: '[name]-[hash].min.js',
    publicPath: '/'
  },
  plugins: [
    new webpack.optimize.OccurenceOrderPlugin(),
    new HtmlWebpackPlugin({
      template: 'app-front/index.tpl.html',
      inject: 'body',
      filename: 'index.html'
    }),
    new ExtractTextPlugin('[name]-[hash].min.css'),
    new webpack.optimize.UglifyJsPlugin({
      compressor: {
        warnings: false,
        screw_ie8: true
      }
    }),
    new StatsPlugin('webpack.stats.json', {
      source: false,
      modules: false
    }),
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV)
    })
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
	{test: /\.scss$/,loaders: ["style", "css","postcss-loader","sass"]},
	{ test: /\.css$/, loaders: [ 'style', 'css', 'postcss-loader' ] },
	{
	test: /\.woff2?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
	loader: "url?limit=10000"
	},
	{
	test: /\.(ttf|eot|svg)(\?[\s\S]+)?$/,
	loader: 'file'
	},
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
  postcss: [ autoprefixer ],
  resolve: {
    extensions: ['', '.js', '.scss'],
    root: [path.join(__dirname, './app-front')]
  }
};
