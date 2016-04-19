var gulp = require('gulp')
var browserify = require('browserify')
var babelify = require('babelify')
var source = require('vinyl-source-stream')
var gutil = require('gulp-util')
var sass = require('gulp-sass')
var sourcemaps = require('gulp-sourcemaps')
var uglify = require('gulp-uglify')

gulp.task('build-css', function (){
  return gulp.src('./resources/styles/**/*.scss')
	.pipe(sourcemaps.init())
	.pipe(sass())
	.pipe(sourcemaps.write())
	.pipe(gulp.dest('../public_html/assets/styles'));
});	
	
gulp.task('es6', function (){
	browserify({
	  entries: './app-front/index.js',
	  debug: true,
	})
	.transform(babelify,{
	  presets:["es2015", "react"]
	})
	.on('error',gutil.log)
	.bundle()
	.on('error',gutil.log)
	.pipe(source('app.min.js'))
	.pipe(gulp.dest('../public_html/assets/js'));
});

gulp.task('build-js', function (){
  return gulp.src('../public_html/assets/js/*.js')
    .pipe(uglify()) 
    .pipe(gulp.dest('../public_html/assets/js/min'));
});
 
gulp.task('watch',function (){
	gulp.watch('./app-front/**/*.js',['es6']);
	gulp.watch('./resources/styles/**/*.scss', ['build-css']);
});
 
gulp.task('default', ['watch']);