var gulp = require('gulp'),
	browserify = require('browserify'),
	babelify = require('babelify'),
	source = require('vinyl-source-stream'),
	gutil = require('gulp-util'),
 
    jshint = require('gulp-jshint'),
    sass   = require('gulp-sass');
 
gulp.task('es6', function() {
	browserify({
    	entries: './app-front/js/app.js',
    	debug: true
  	})
    .transform(babelify,{
	  presets:["es2015", "react"]
	})
    .on('error',gutil.log)
    .bundle()
    .on('error',gutil.log)
    .pipe(source('app.min.js'))
    .pipe(gulp.dest('../../public_html/assets/js'));
});

gulp.task('build-sass-to-css', function() {
  return gulp.src('resources/assets/sass/**/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('../../public_html/assets/styles'));
});
 
/*Using jshint library example */ 
//gulp.task('jshint', function() {
//  return gulp.src('source/javascript/**/*.js')
//    .pipe(jshint())
//    .pipe(jshint.reporter('jshint-stylish'));
//});

 
gulp.task('watch',function() {
	gulp.watch('./app-front/js/**/*.js',['es6']);
	gulp.watch('resources/assets/sass/**/*.scss', ['build-sass-to-css']);
});
 
gulp.task('default', ['watch']);