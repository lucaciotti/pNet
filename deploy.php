<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/php-fpm.php';
require 'contrib/npm.php';

set('application', 'pNet');;
set('repository', 'git@github.com:lucaciotti/pNet.git');
set('git_tty', true);
set('php_fpm_version', '8.0');

set('use_relative_symlink', false);
set('ssh_multiplexing', false);

host('prod')
    ->set('remote_user', 'root')
    ->set('hostname', 'pnet.lucaciotti.space')
    ->set('deploy_path', '/var/www/{{hostname}}');

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'npm:install',
    'npm:run:prod',
    'deploy:publish',
    'php-fpm:reload',
]);

task('npm:run:prod', function () {
    cd('{{release_path}}');
    run('npm run prod');
});

after('deploy:failed', 'deploy:unlock');