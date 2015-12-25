var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var del = require('del');
var modernizr = require('gulp-modernizr');
var Q = require('q');

var config = {
    assetsDir: 'assets',
    sassPattern: 'sass/**/*.scss',
    cssPattern: 'css/**/*.min.css',
    cssDest: 'web/public/css',
    jsDest: 'web/public/js',
    imgDir: 'assets/images',
    imgDest: 'web/public/images',
    fontDest: 'web/public/fonts',
    production: !!plugins.util.env.production,
    sourceMaps: !plugins.util.env.production,
    bowerDir: 'bower_components',
    revManifestPath: 'app/Resources/assets/rev-manifest.json'
};

var app = {};

app.addStyle = function(paths, outputFilename) {
     
    return gulp.src(paths)   
        .pipe(plugins.plumber())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.init()))
        .pipe(plugins.sass())
        .pipe(plugins.concat('public/css/' + outputFilename))
        .pipe(config.production ? plugins.minifyCss() : plugins.util.noop())
        .pipe(plugins.rev())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.write('.')))
        .pipe(gulp.dest('web'))
        .pipe(plugins.rev.manifest(config.revManifestPath, {
            merge: true
        }))
        .pipe(gulp.dest('.'));
        
};

app.addScript = function(paths, outputFilename) {
    
    return gulp.src(paths)
        .pipe(plugins.plumber())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.init()))
        .pipe(plugins.concat('public/js/' + outputFilename))
        .pipe(config.production ? plugins.uglify() : plugins.util.noop())
        .pipe(plugins.rev())
        .pipe(plugins.if(config.sourceMaps, plugins.sourcemaps.write('.')))
        .pipe(gulp.dest('web'))
        .pipe(plugins.rev.manifest(config.revManifestPath, {
            merge: true
        }))
        .pipe(gulp.dest('.'));
        
};

app.copy = function(srcFiles, outputDir) {
    gulp.src(srcFiles)
        .pipe(gulp.dest(outputDir));
};

var Pipeline = function() {
    this.entries = [];
};

Pipeline.prototype.add = function() {
    this.entries.push(arguments);
};

Pipeline.prototype.run = function(callable) {
    
    var deferred = Q.defer();
    var i = 0;
    var entries = this.entries;
    
    var runNextEntry = function() {
        
        // see if we're all done looping
        if (typeof entries[i] === 'undefined') {
            deferred.resolve();
            return;
        }
        
        // pass app as this, though we should avoid using "this"
        // in those functions anyways
        callable.apply(app, entries[i]).on('end', function() {
            i++;
            runNextEntry();
        });
        
    };
    
    runNextEntry();
    
    return deferred.promise;
    
};

gulp.task('fonts', function() {
    app.copy(
        config.bowerDir + '/font-awesome/fonts/*',
        config.fontDest
    );
});

gulp.task('images', function() {
    app.copy(
        config.imgDir + '/*',
        config.imgDest
    );
});

gulp.task('styles', function() {
    
    var pipeline = new Pipeline();
    
    pipeline.add([
        config.bowerDir + '/bootstrap/dist/css/bootstrap.css',
        config.bowerDir + '/font-awesome/css/font-awesome.css',
        config.assetsDir + '/css/formValidation/formValidation.css'
    ], 'vendors.min.css');
    
    pipeline.add([
        config.assetsDir + '/sass/layout.scss',
        config.assetsDir + '/sass/styles.scss'
    ], 'main.min.css');
    
    pipeline.run(app.addStyle);
    
});

gulp.task('copy_js', function(){
    gulp.src([
        config.bowerDir + '/normalize-css/normalize.css',
        config.bowerDir + '/jquery/dist/jquery.min.js',
        config.bowerDir + '/bootstrap/dist/js/bootstrap.min.js'
    ])
    .pipe(gulp.dest(config.jsDest));
});

gulp.task('copy_css', function(){
    gulp.src([
        config.bowerDir + '/normalize-css/normalize.css'
    ])
    .pipe(gulp.dest(config.cssDest));
});

gulp.task('scripts', function() {
    
    var pipeline = new Pipeline();

    pipeline.add([
        config.assetsDir + '/js/formValidation/formValidation.min.js',
        config.assetsDir + '/js/formValidation/framework/bootstrap.framework.js',
        config.assetsDir + '/js/formValidation/language/en_US.js'
    ], 'vendors.min.js');
    
    pipeline.add([
        config.assetsDir + '/js/plugins.js'
    ], 'plugins.min.js');
    
    pipeline.add([
        config.assetsDir + '/js/main.js'
    ], 'main.min.js');
    
    pipeline.add([
        config.assetsDir + '/js/vendor/modernizr-custom.js',
        config.assetsDir + '/js/vendor/respond.js'
    ], 'modernizr-respond.min.js');
    
    pipeline.run(app.addScript);
    
});

gulp.task('watch', function() {
    gulp.watch(config.assetsDir  + '/' + config.sassPattern, ['styles'])
    gulp.watch(config.assetsDir + '/js/**/*.js', ['scripts']);
    gulp.watch(config.assetsDir + '/images/**/*', ['images']);
});

gulp.task('clean', function(){
    del.sync(config.revManifestPath);
    del.sync(config.cssDest + '/*');
    del.sync(config.jsDest + '/*');
    del.sync(config.fontDest + '/*');
    del.sync(config.imgDest + '/*');
});

gulp.task('default', ['clean', 'styles', 'scripts', 'copy_js', 'copy_css', 'fonts', 'images', 'watch']);
