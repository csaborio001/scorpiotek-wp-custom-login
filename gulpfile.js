const gulp    = require("gulp"),
sass          = require("gulp-sass"),
uglify        = require('gulp-uglify'),
rename        = require('gulp-rename'),
imagemin      = require('gulp-imagemin'),
sourcemaps    = require("gulp-sourcemaps"),
browserSync   = require("browser-sync").create(),
rsync         = require("gulp-rsync");
build_folder  = "./";
source        = "./process/",
dest          = "./dist/"
sass.compiler = require("node-sass");


function php() {
  return gulp.src(["./src/**/*.php"]);
}

function js() {
  return gulp
  .src(source + "/scripts/*.js")
  .pipe(uglify())
  .pipe(rename({ suffix: '.min' }))
  .pipe(gulp.dest(dest + "scripts"));
}

function styles() {
  return gulp
	.src(source + "/sass/*.scss")
	.pipe(sourcemaps.init())
	.pipe(sass().on('error', sass.logError))
  .pipe(sourcemaps.write())
  .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
	.pipe(gulp.dest(dest + "css"));
}

function images() {
  return gulp
  .src(source + "/img/**/*.*")
  .pipe(imagemin())
  .pipe(gulp.dest(dest + "img"));
}

function sync_test_dir() {
  return gulp
    .src(build_folder)
    .pipe(rsync({
      root: build_folder,
      recursive: true,
      destination: test_folder,
      exclude: ['process', 'tests', '**/node_modules/*', '**/.git/*', '.DS_Store','package-lock.json','gulpfile.js','codeception.dist.yml','.env','composer.lock','doctrine','.env.testing','.gitignore','scorpiotek-testing-plugin',]
    }));
}

function watch() {
  // Processes the JS files inside process/scripts and sends minimized output to dist/scripts.
  gulp.watch(source + "scripts/**/*.js", gulp.parallel(js)).on("change", browserSync.reload);
  // Processes the SASS files inside process/sass and sends minimized output to dist/css.
  gulp.watch(source + "sass/**/*", gulp.parallel(styles)).on("change", browserSync.reload);
  // Keep an eye for changed PHP files.
  gulp.watch(["./src/**/*.php"], gulp.parallel(php)).on("change", browserSync.reload);
  // Keep an eye for changed images.
  gulp.watch([source + "img/**/*.png", source + "img/**/*.jpg"], gulp.parallel(images)).on("change", browserSync.reload);
}

function server() {
  browserSync.init({
	notify: false,
	browser: "firefox developer edition",
	proxy: "http://localhost:19203",
	port:80,
  });
  watch();
}

var build = gulp.series(gulp.parallel(js, styles, php, images), server );
var deploy = gulp.series(gulp.parallel(sync_test_dir));

gulp.task("default", build);
gulp.task("deploy", deploy);