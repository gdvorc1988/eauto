var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

var paths = {
    styles: {
        folder: "./local/templates/eauto/scss/**/*.scss",
        src: "./local/templates/eauto/scss/template_styles.scss",
        dest: "./local/templates/eauto"
    }
};

function style() {
    return gulp
        .src(paths.styles.src)
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            cascade: false
        }))
        .pipe(gulp.dest(paths.styles.dest));
}

function watch() {
    style();
    gulp.watch(paths.styles.folder, style);
}

exports.watch = watch