// Load gulp and plugins
var gulp = require('gulp'),
    gulpLoadPlugins = require('gulp-load-plugins'),
    plugins = gulpLoadPlugins();

// Load non gulp plugins
var del = require('del'),
    browserSync = require('browser-sync'),
    pngquant = require('imagemin-pngquant');

//useful regular vars
var dest_folder = 'public/assets/',
    src_folder = 'public/assets/src/';

// Used paths
var paths = {
    // bower: {
    //     src:            'bower_components/',
    //     icons: {
    //         src: [
    //                     'bower_components/bootstrap-sass-official/assets/fonts/**/*',
    //                     'bower_components/fontawesome/fonts/*'
    //         ],
    //         dest:       dest_folder + 'fonts/'
    //     }
    // },
    // fonts: {
    //     src:            src_folder + 'fonts/**/*',
    //     dest:           dest_folder + 'fonts/'
    // },
    styles: {
        src: src_folder + 'styles/main.scss',
        include: [
            src_folder + 'styles/'
        ],
        dest: dest_folder + 'styles',
        // vendors:        src_folder + 'styles/vendors/**/*',
        // vendorsDest:    dest_folder + 'styles/vendors',
        watch: src_folder + 'styles/**/*.scss',
        style: dest_folder + 'styles/main.css',
        styleProd: dest_folder + 'styles/main.min.css'
    },
    jscripts: {
        src: src_folder + 'jscripts/**/*.js',
        // bundle: [
        //     'bower_components/jquery/dist/jquery.js',
        //     'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap.js',
        //     src_folder + 'jscripts/*.js'
        //
        // ],
        dest: dest_folder + 'jscripts',
        vendors: src_folder + 'jscripts/vendors/**/*',
        vendorsDest: dest_folder + 'jscripts/vendors',
        watch: src_folder + 'jscripts/**/*.js'
    },
    images: {
        src: src_folder + 'img/**/*',
        dest: dest_folder + 'img',
        watch: src_folder + 'img/**/*'
    },
    php: {
        watch: 'application/**/*.php'
    }
};

// Tasks

// Task to be executed before anything. First installs bower components and then copy assets to deploy dir
gulp.task('letsgo', ['fonts'], function() {
    return gulp.src(paths.bower.icons.src)
        .pipe(gulp.dest(paths.bower.icons.dest));
});

// Install fonts
gulp.task('fonts', function() {
    return gulp.src(paths.fonts.src)
        .pipe(gulp.dest(paths.fonts.dest));

});

// Install vendors javascript packages
gulp.task('js-vendors', function() {
    return gulp.src(paths.jscripts.vendors)
        .pipe(gulp.dest(paths.jscripts.vendorsDest));

});

// Install vendors css packages
gulp.task('styles-vendors', function() {
    return gulp.src(paths.styles.vendors)
        .pipe(gulp.dest(paths.styles.vendorsDest));

});

// Styles processing
gulp.task('styles-task', ['scss-task'], function() {
    return gulp.src(paths.styles.style)
        .pipe(plugins.rename({
            suffix: '.min'
        }))
        .pipe(plugins.cleanCss())
        .pipe(gulp.dest(paths.styles.dest));
});

gulp.task('scss-task', function() {
    return gulp.src(paths.styles.src)
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.sass({
            includePaths: paths.styles.include,
            errLogToConsole: false,
            onError: function(err) {
                return plugins.notify().write(err);
            }
        }))
        .pipe(plugins.sourcemaps.write({
            includeContent: false
        }))
        .pipe(plugins.sourcemaps.init({
            loadMaps: true
        }))
        .pipe(plugins.autoprefixer('last 2 versions'))
        .pipe(plugins.sourcemaps.write('.'))
        .pipe(gulp.dest(paths.styles.dest));
});


// Javascripts
gulp.task('jscripts-task', function() {
    return gulp.src(paths.jscripts.src)
        .pipe(plugins.concat('main.js'))
        .pipe(gulp.dest(paths.jscripts.dest))
        .pipe(plugins.rename({
            suffix: '.min'
        }))
        .pipe(plugins.uglify())
        .pipe(gulp.dest(paths.jscripts.dest));
});

// Images
gulp.task('images-task', function() {
    return gulp.src(paths.images.src)
        .pipe(plugins.newer(paths.images.dest))
        .pipe(plugins.cache(plugins.imagemin({
            optimizationLevel: 3,
            progressive: true,
            interlaced: true,
            use: [pngquant()]
        })))
        .pipe(gulp.dest(paths.images.dest));
});

// PHP
gulp.task('php-task', function() {
    return gulp.src(paths.php.watch);
});

// Browser Sync
gulp.task('browser-sync-task', function() {
    browserSync({
        proxy: "http://127.0.0.1:8020/",
        notify: false
    });
});

// Developmen task to watch assets and reload browser when they change
gulp.task('dev', ['browser-sync-task', 'styles-task', 'jscripts-task', 'images-task'], function() {
    // Watch backend PHPs, .scss, .js & image files
    gulp.watch(paths.php.watch, ['php-task', browserSync.reload]);
    gulp.watch(paths.styles.watch, ['styles-task', browserSync.reload]);
    gulp.watch(paths.jscripts.watch, ['jscripts-task', browserSync.reload]);
    gulp.watch(paths.images.watch, ['images-task', browserSync.reload]);
});

// Task to prepare all
gulp.task('build', ['styles-task', 'jscripts-task', 'images-task']);
