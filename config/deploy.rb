set :stages, %w(prod)
set :default_stage, "prod"
require 'capistrano/ext/multistage'

require 'capatross'
require "delayed/recipes"
 
set :application, "blogs"
set :repository,  "git@github.com:extension/blogs.git"
set :branch, "master"
set :scm, "git"
set :user, "pacecar"
set :use_sudo, false
set :keep_releases, 3
ssh_options[:forward_agent] = true
set :port, 24
#ssh_options[:verbose] = :debug

after "deploy:update_code", "deploy:link_and_copy_configs"
after "deploy:update_code", "deploy:cleanup"


namespace :deploy do
  
  
  # Link up various configs (valid after an update code invocation)
  task :link_and_copy_configs, :roles => :app do
    run <<-CMD
    rm -rf #{release_path}/wp-config.php &&
    ln -nfs /services/config/#{application}/.htaccess #{release_path}/.htaccess &&
    ln -nfs /services/config/#{application}/wp-config.php #{release_path}/wp-config.php &&
    ln -nfs /services/config/#{application}/robots.txt #{release_path}/robots.txt &&
    rm -rf #{release_path}/wp-content/blogs.dir &&
    ln -nfs /services/wordpress/blogs.extension.org/blogs.dir #{release_path}/wp-content/blogs.dir
    CMD
  end
  


end



