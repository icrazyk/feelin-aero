'use strict';

const del = require('del');
const gulp = require('gulp');
const ect = require('gulp-ect');
const watch = require('gulp-watch');
const usemin = require('gulp-usemin');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const stylus = require('gulp-stylus');
const plumber = require('gulp-plumber');
const sourcemaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync').create();

//
// functions
//

function styles()
{
  return gulp.src('./src/css/app.styl')
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(stylus())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./build/'));
}

function stylesWatch()
{
  return watch('./src/css/**/*.styl', function() 
  {
    styles();
  });
}

function js()
{
  return gulp.src('./src/js/**/*.js')
    .pipe(sourcemaps.init())
    .pipe(concat('app.js'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./build/'));
}

function startEct()
{
  return gulp.src('./src/*.ect')
    .pipe(ect())
    .pipe(gulp.dest('./build/'));
}

function startEctWatch()
{
  return watch('./src/**/*.ect', function() 
  {
    startEct();
  });
}

function images()
{
  return gulp.src('./src/img/*.{png,jpg,svg}')
    .pipe(gulp.dest('./build/img/'));
}

function imagesWatch()
{
  return watch('./src/img/*.{jpg,png,svg}', function() 
  {
    images();
  });
}

function startUsemin()
{
  return gulp.src('./build/index.html')
    .pipe(usemin())
    .pipe(gulp.dest('./build/'));
}


//
// tasks
//

gulp.task('clean', function()
{
  return del(['./build/']);
});

gulp.task('styles:build', ['clean'], styles);
gulp.task('styles:dev', stylesWatch);

gulp.task('js:build', ['clean'], js);
gulp.task('js:dev', js);

gulp.task('ect:build', ['clean'], startEct);
gulp.task('ect:dev', startEctWatch);

gulp.task('images:build', ['clean'], images);
gulp.task('images:dev', imagesWatch);

gulp.task('usemin:build', ['clean', 'ect:build'], startUsemin);

gulp.task('browser-sync', ['build'], function() 
{
  browserSync.init({
    server: {
      baseDir: "."
    }
  });
  gulp.watch("./build/**/*.*").on('change', browserSync.reload);
});

gulp.task('watch', ['build'], function()
{
  gulp.watch('./src/**/*.js', ['js:dev']);
});

gulp.task('build', ['clean', 'styles:build', 'js:build', 'ect:build', 'images:build', 'usemin:build']);
gulp.task('dev', ['build', 'images:dev', 'ect:dev', 'styles:dev', 'watch', 'browser-sync']);
