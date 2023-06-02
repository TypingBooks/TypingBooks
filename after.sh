#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.
#
# If you have user-specific configurations you would like
# to apply, you may also create user-customizations.sh,
# which will be run after this script.

# If you're not quite ready for Node 12.x
# Uncomment these lines to roll back to
# v11.x or v10.x

# Remove Node.js v12.x:
#sudo apt-get -y purge nodejs
#sudo rm -rf /usr/lib/node_modules/npm/lib
#sudo rm -rf //etc/apt/sources.list.d/nodesource.list

# Install Node.js v11.x
#curl -sL https://deb.nodesource.com/setup_11.x | sudo -E bash -
#sudo apt-get install -y nodejs

# Install Node.js v10.x
#curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
#sudo apt-get install -y nodejs


if sudo [ ! -f /etc/supervisor/conf.d/laravel-worker.conf ]; then

  laravel_worker_block="
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/vagrant/code/typing/artisan queue:work redis --sleep=3 --tries=3
autostart=true
autorestart=true
user=vagrant
numprocs=8
redirect_stderr=true
stdout_logfile=/home/vagrant/code/typing/storage/logs/worker.log
stopwaitsecs=3600
  
[program:horizon]
process_name=%(program_name)s
command=php /home/vagrant/code/typing/artisan horizon
autostart=true
autorestart=true
user=root
redirect_stderr=true
stdout_logfile=/home/vagrant/code/typing/storage/logs/horizon.log
stopwaitsecs=3600"


  sudo sh -c "echo '$laravel_worker_block' > '/etc/supervisor/conf.d/laravel-worker.conf'"
  cd /home/vagrant/code/typing/
  composer install
  sudo systemctl start redis-server
  sudo systemctl enable redis-server
  sudo supervisorctl reread
  sudo supervisorctl update
  sudo supervisorctl start horizon
  sudo supervisorctl start laravel-worker:*
  sudo php /home/vagrant/code/typing/artisan migrate:fresh --seed
  sudo php /home/vagrant/code/typing/artisan horizon:publish
  sudo php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
fi

cd /home/vagrant/code/typing
sudo crontab cron.txt
sudo service cron restart