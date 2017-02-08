var gulp = require('gulp');
var sftp = require('gulp-sftp');


var src = [
    '**',
    '!web/bundles/*',
    '!vendor/**',
    '!node_modules/**',
    '!tests/**',
    '!nbproject/**',
    '.ftppass'
    ];

gulp.task('upload', function () {
    return gulp.src(src)
        .pipe(sftp({
            host: '192.168.56.101',
            auth: 'key',
            remotePath: '/var/www/gulp/'
        }));
});

gulp.task('default', ['upload']);