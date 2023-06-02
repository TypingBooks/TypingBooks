    @servers(['web' => ''])
    
    @setup
        $repository = '';
        $releases_dir = '/var/www/projects/bType/releases';
        $app_dir = '/var/www/projects/bType';
        $persistent_data = '/var/www/projects/bType/persistent_data';
        $release = date('Y-m-d-H:i:s');
        $new_release_dir = $releases_dir .'/'. $release;
    @endsetup
    
    @story('deploy')
        clone_repository
        run_composer
        update_symlinks
        migrate
        reload_files
    @endstory
    
    @task('clone_repository')
        echo 'Cloning repository'
        [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
        git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
        cd {{ $new_release_dir }}
    @endtask
    
    @task('run_composer')
        echo "Starting deployment ({{ $release }})"
        cd {{ $new_release_dir }}
        composer install --optimize-autoloader --no-dev
    @endtask
    
    @task('update_symlinks')
        echo "Linking storage directory"
        rm -rf {{ $new_release_dir }}/storage
        ln -nfs {{ $persistent_data }}/storage {{ $new_release_dir }}/storage
        
        echo 'Linking .env file'
        rm -rf {{ $new_release_dir }}/.env
        ln -nfs {{ $persistent_data }}/.env {{ $new_release_dir }}/.env
        
        echo 'Linking current release'
        ln -nfs {{ $new_release_dir }} {{ $app_dir }}/live
    @endtask
    
    @task('migrate')
        echo 'Migrating database.. well, not anymore. It probably is a good idea to do this manually anyway.'
        
        cd {{ $new_release_dir }}
    
    @endtask
    
    @task('reload_files')
        echo 'Reloading configuration, cache, views, etc.'

        cd {{ $new_release_dir }}
        php artisan config:clear
        php artisan cache:clear
        php artisan view:clear
        php artisan route:clear
        php artisan queue:restart
        php artisan horizon:publish
		php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
        sudo service php-fpm restart
        sudo service nginx restart
        sudo supervisorctl restart horizon
		php artisan config:cache
		php artisan view:cache
    @endtask