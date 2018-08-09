set :stages, %w(prod)
set :default_stage, "prod"
require 'capistrano/ext/multistage'

require 'capatross'

set :application, "publish"
set :repository,  "git@github.com:extension/publish.git"
set :branch, "master"
set :scm, "git"
set :user, "pacecar"
set :gateway, 'deploy.extension.org'
set :use_sudo, false
set :keep_releases, 3
ssh_options[:forward_agent] = true
#ssh_options[:verbose] = :debug

after "deploy:update_code", "deploy:link_and_copy_configs"
after "deploy:update_code", "deploy:cleanup"
after 'deploy',             'deploy:restart'

namespace :deploy do

   # Override default restart task
   desc "Restart Apache"
   task :restart, :roles => :app do
     invoke_command '/usr/sbin/service apache2 restart', via: 'sudo'
   end

  # Link up various configs (valid after an update code invocation)
  task :link_and_copy_configs, :roles => :app do
    run <<-CMD
    rm -rf #{release_path}/wp-config.php &&
    ln -nfs /services/publish/shared/config/wp-config.php #{release_path}/wp-config.php &&
    ln -nfs /services/publish/shared/config/.htaccess #{release_path}/.htaccess &&
    ln -nfs /services/publish/shared/config/robots.txt #{release_path}/robots.txt &&
    rm -rf #{release_path}/wp-content/blogs.dir &&
    ln -nfs /services/publish/shared/uploads #{release_path}/wp-content/blogs.dir
    CMD
  end

  [:start, :stop].each do |t|
    desc "#{t} task is a no-op with this application"
    task t, :roles => :app do ; end
  end


  # Override default web enable/disable tasks
  namespace :web do

    desc "Put Apache and Cronmon in maintenancemode by touching the maintenancemode file"
    task :disable, :roles => :app do
      invoke_command "touch /services/maintenance/#{vhost}.maintenancemode"
      invoke_command "touch /services/maintenance/CRONMONHALT"
    end

    desc "Remove Apache and Cronmon from maintenancemode by removing the maintenancemode file"
    task :enable, :roles => :app do
      invoke_command "rm -f /services/maintenance/#{vhost}.maintenancemode"
      invoke_command "rm -f /services/maintenance/CRONMONHALT"
    end

  end

end
