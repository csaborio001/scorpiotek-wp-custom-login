const gulp    = require("gulp"),
  sass        = require("gulp-sass"),
  sourcemaps  = require("gulp-sourcemaps"),
  browserSync = require("browser-sync").create(),
  source      = "./process/",
  dest        = "./";

sass.compiler = require("node-sass");

function html() {
  return gulp.src(dest + "**/*.html");
}

function js() {
  return gulp.src(dest + "**/*.js");
}

function styles() {
  return gulp
	.src(source + "/sass/style.scss")
	// .pipe(sourcemaps.init())
	// .pipe(sass().on('error', sass.logError))
  // .pipe(sourcemaps.write())
  .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
	.pipe(gulp.dest(dest + "css"));
}

function watch() {
  gulp.watch(dest + "js/**/*.js", js).on("change", browserSync.reload);
  gulp.watch(source + "sass/**/*", styles).on("change", browserSync.reload);
  gulp.watch(dest + "index.html", html).on("change", browserSync.reload);
}

function server() {
  browserSync.init({
	notify: false,
	browser: "firefox developer edition",
	proxy: "http://localhost/connect.vinnies.org.au/wp-login.php",
	port:8886,
  });

  gulp
	.watch(source + "sass/**/*.scss", styles)
	.on("change", browserSync.reload);
  gulp.watch(dest + "js/**/*.js", js).on("change", browserSync.reload);
  gulp.watch(dest + "index.html", html).on("change", browserSync.reload);
}

var build = gulp.series(gulp.parallel(js, styles, html), server, watch);

gulp.task("default", build);
