<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'my_project');

// Project repository
set('repository', '');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Stage default
set('default_stage', 'hml');

// Hosts
host('production')
    ->hostname('deploy@173.82.186.231')
    ->port(22)
    ->stage('prod')
    ->set('keep_releases', 6)
    ->set('branch', 'master')
    ->set('deploy_path', '/var/www/html/production-my-app');

host('homolog')
    ->hostname('deploy@173.82.186.231')
    ->port(22)
    ->stage('hml')
    ->set('keep_releases', 3)
    ->set('branch', 'develop')
    ->set('deploy_path', '/var/www/html/homolog-my-app');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

