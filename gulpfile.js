var gulp = require('gulp'),
	browserify = require('browserify'),
	babelify = require('babelify'),
	source = require('vinyl-source-stream'),
	gutil = require('gulp-util'),
    eslint = require('gulp-eslint'),
	sass = require('gulp-sass'),
	sourcemaps = require('gulp-sourcemaps'),
	gzip = require('gulp-gzip'),
	uglify = require('gulp-uglify');

gulp.task('lint', function () {
    return gulp.src([
      './app-front/js/**/*.js',
      './app-front/js/**/*.jsx'
    ])
      .pipe(eslint())
      .pipe(eslint.format())
      .pipe(eslint.failOnError());
});

gulp.task('build-css', function() {
  return gulp.src('./resources/assets/sass/**/*.scss')
    .pipe(sourcemaps.init())
     .pipe(sass())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('../public_html/assets/styles'));
});	
	
gulp.task('es6', function() {
	browserify({
    	entries: './app-front/js/index.js',
    	debug: true
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

gulp.task('build-js', function() {
  return gulp.src('../public_html/assets/js/*.js')
    .pipe(uglify()) 
	//.pipe(gzip())
    .pipe(gulp.dest('../public_html/assets/js/min'));
});
 
gulp.task('watch',function() {
	gulp.watch('./app-front/js/**/*.js',['es6']);
	gulp.watch('./resources/assets/sass/**/*.scss', ['build-css']);
});
 
gulp.task('default', ['watch']);