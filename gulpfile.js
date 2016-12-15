'use strict';

const del = require('del');
const gulp = require('gulp');
const ect = require('gulp-ect');
const exec = require('gulp-exec');
const watch = require('gulp-watch');
const usemin = require('gulp-usemin');
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const stylus = require('gulp-stylus');
const plumber = require('gulp-plumber');
const sourcemaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync').create();

const options  = {
  build : './build/',
  src: './src/',
  css: './src/css/',
  js: './src/js/',
  img: './src/img/',
  dev: './dev/'
};

//
// functions
//

function styles()
{
  return gulp.src(options.css + 'app.styl')
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(stylus())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(options.dev));
}

function stylesWatch()
{
  return watch(options.css + '**/*.styl', function() 
  {
    styles();
  });
}

function js()
{
  return gulp.src(options.js + '**/*.js')
    .pipe(sourcemaps.init())
    .pipe(concat('app.js'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(options.dev));
}

function startEct()
{
  return gulp.src(options.src + '*.ect')
    .pipe(ect())
    .pipe(gulp.dest(options.dev));
}

function startEctWatch()
{
  return watch(options.src + '**/*.ect', function() 
  {
    startEct();
  });
}

function images()
{
  return gulp.src(options.img + '*.{png,jpg,svg}')
    .pipe(gulp.dest(options.dev + 'img/'));
}

function imagesWatch()
{
  return watch(options.img + '*.{jpg,png,svg}', function() 
  {
    images();
  });
}

function startBasisjsToolsBuild()
{
  return gulp.src(options.dev + 'index.html')
    .pipe(exec('node ./node_modules/basisjs-tools-build/bin/build build -b . -f <%= file.path %> -o <%= options.build %>', options))
    .pipe(exec.reporter());
}

//
// tasks
//

gulp.task('clean', function()
{
  return del([options.build, options.dev]);
});

gulp.task('clean:html', ['basisjs-tools-build'], function()
{
  return del([options.build + '*.html']);
});

gulp.task('styles:build', ['clean'], styles);
gulp.task('styles:dev', stylesWatch);

gulp.task('js:build', ['clean'], js);
gulp.task('js:dev', js);

gulp.task('ect:build', ['clean'], startEct);
gulp.task('ect:dev', startEctWatch);

gulp.task('images:build', ['clean'], images);
gulp.task('images:dev', imagesWatch);

gulp.task('basisjs-tools-build', ['clean', 'ect:build'], startBasisjsToolsBuild);

gulp.task('browser-sync', ['init'], function() 
{
  browserSync.init({
    server: {
      baseDir: './dev/',
      routes: {
        '/node_modules':'node_modules'
      }
    }
  });
  gulp.watch(options.dev + '**/*.*').on('change', browserSync.reload);
});

gulp.task('watch', ['init'], function()
{
  gulp.watch('./src/**/*.js', ['js:dev']);
});

gulp.task('init', ['clean', 'styles:build', 'js:build', 'ect:build', 'images:build']);

gulp.task('build', ['init', 'basisjs-tools-build', 'clean:html']);
gulp.task('dev', ['init', 'images:dev', 'ect:dev', 'styles:dev', 'watch', 'browser-sync']);
