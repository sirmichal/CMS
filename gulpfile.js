var gulp = require('gulp');
var sftp = require('gulp-sftp');


var src = [
    '**',
    '!web/node_modules',
    '!web/.htaccess',
    '!vendor/**',
    '!node_modules/**',
    '!tests/**',
    '!nbproject/**',
    '!var/**',
    '!gulpfile.js',
    '!phpunit.xml.dist',
    '!LICENSE',
    '!README.md',
    ];

gulp.task('upload', function () {
    return gulp.src(src)
        .pipe(sftp({
            host: '192.168.56.102',
            auth: 'key',
            remotePath: '/var/www/cms'
        }));
});

gulp.task('default', ['upload']);