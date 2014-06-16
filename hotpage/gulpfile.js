var gulp = require('gulp'),
    minifyCSS = require('gulp-minify-css'),
    clean = require('gulp-clean'),
    rename = require("gulp-rename"),
    watch = require('gulp-watch'),
    distStyle = 'dist/css';

//minificar a folha de estilo da app
gulp.task('styles', function () {
    return gulp.src('assets/css/*.css')
        .pipe(minifyCSS())  
        .pipe(rename({ 
            basename: "style",
            suffix: '.min'
        }))
        .pipe(gulp.dest(distStyle));
    });

//limpa as pastas de destino
gulp.task('clean', function () {
    return gulp.src([distStyle], {read: false}).pipe(clean());
});

// constroi a aplicacao
gulp.task('build', ['styles']);


// Default task
gulp.task('default', ['clean'],  function () {
    gulp.start('build');
});


// Watch
gulp.task('watch', function () {
    // Watch .scss files app
    gulp.watch('assets/css/*.scss', ['styles']);
});