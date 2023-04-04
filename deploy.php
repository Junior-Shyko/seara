<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'seara');

set('composer_options', 'check-platform-reqs');
set('webroot', '/var/www/html');

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);
set('allow_anonymous_stats', false);

set('bin/composer', function () {
    if (commandExist('composer')) {
        $composer = locateBinaryPath('composer');
    }

    if (empty($composer)) {
        run("cd {{release_path}} && curl https://getcomposer.org/composer-1.phar -o composer.phar -LR -z composer.phar");
        $composer = '{{release_path}}/composer.phar';
    }

    return '{{bin/php}} ' . $composer;
});

// Hosts

host('production')
    ->hostname('seara')
    // ->multiplexing(false)
    ->set('deploy_path', '{{webroot}}/{{application}}');
    
// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

desc('Update code');
task('deploy:update_code', function () {
    upload('build/code/', '{{release_path}}');
});

desc('Create storage folders');
task('deploy:storage:folders', function () {
    run('mkdir -p {{release_path}}/storage/app/public');
    run('mkdir -p {{release_path}}/storage/framework/cache');
    run('mkdir -p {{release_path}}/storage/framework/sessions');
    run('mkdir -p {{release_path}}/storage/framework/views');
    run('mkdir -p {{release_path}}/storage/logs');
    run('mkdir -p {{release_path}}/public/storage');
});

before('deploy:writable', 'deploy:storage:folders');

desc('Caches the route');
task('artisan:route:cache', function () {
    run('php {{release_path}}/artisan route:cache');
});

desc('Clears all the cache');
task('cache:clear', function () {
    run('php {{release_path}}/artisan cache:clear');
    run('php {{release_path}}/artisan config:clear');
    run('php {{release_path}}/artisan route:clear');
    run('php {{release_path}}/artisan view:clear');
});

desc('Migrates database');
task('artisan:migrate', function () {
    run('php {{release_path}}/artisan migrate --force');
    run('php {{release_path}}/artisan migrate:view');
});

/**
 * Main task
 */
desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'cache:clear',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:route:cache',
    'artisan:optimize',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);
