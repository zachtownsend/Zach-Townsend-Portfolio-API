<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'zach_townsend_portfolio_api');

// Project repository
set('repository', 'git@github.com:zachtownsend/Zach-Townsend-Portfolio-API.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
set('shared_files', ['.env', 'web/.htaccess']);
set('shared_dirs', ['web/app/uploads', 'web/app/cache']);

// Writable dirs by web server
set('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('api.zachtownsend.net')
    ->set('deploy_path', '~/{{application}}');


// Tasks

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
