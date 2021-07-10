<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/php-fpm.php';
require 'contrib/npm.php';

set('application', 'pNet');;
set('repository', 'git@github.com:lucaciotti/pNet.git');
set('git_tty', true);
set('php_fpm_version', '8.0');
set('php_fpm_command', 'echo "RJ6SMfkPZa9qBcoN" | sudo -S /usr/sbin/service {{php_fpm_service}} reload');

set('use_relative_symlink', false);
set('ssh_multiplexing', false);

host('prod')
    ->set('remote_user', 'PNet-User')
    ->set('hostname', 'pnet.ferramentaparide.it')
    ->set('port', 2289)
    ->set('deploy_path', '/var/www/html/{{hostname}}');

host('dev')
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
    'migrate:pNet',
    // 'npm:install',
    // 'npm:run:prod',
    'deploy:publish',
    'php-fpm:reload',
    'supervisor:reload:dbSeed',
    'supervisor:reload:email',
    'supervisor:reload:dataMining',
    'setPermission:bootstrap',
    'setPermission:storage'
]);

task('npm:run:prod', function () {
    cd('{{release_path}}');
    run('npm run prod');
});

task('migrate:pNet', function () {
    cd('{{release_path}}');
    run('php artisan migrate --database=pNet_DATA --path=./database/migrations/pNet_DB --force');
});

task('supervisor:reload:dbSeed', function () {
    run('echo "RJ6SMfkPZa9qBcoN" | sudo -S supervisorctl restart pnet-worker-dbSeed:*');
});

task('supervisor:reload:email', function () {
    run('echo "RJ6SMfkPZa9qBcoN" | sudo -S supervisorctl restart pnet-worker-email:*');
});

task('supervisor:reload:dataMining', function () {
    run('echo "RJ6SMfkPZa9qBcoN" | sudo -S supervisorctl restart pnet-worker-dataMining:*');
});

task('setPermission:storage', function () {
    cd('{{release_path}}');
    run('echo "RJ6SMfkPZa9qBcoN" | sudo -S chown -R $USER:www-data storage');
    run('echo "RJ6SMfkPZa9qBcoN" | sudo -S chmod -R 777 storage');
});

task('setPermission:bootstrap', function () {
    cd('{{release_path}}');
    run('echo "RJ6SMfkPZa9qBcoN" | sudo -S chown -R $USER:www-data bootstrap/cache');
    run('echo "RJ6SMfkPZa9qBcoN" | sudo -S chmod -R 777 bootstrap/cache');
});

after('deploy:failed', 'deploy:unlock');