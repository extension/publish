set :deploy_to, "/services/publish/"
if(branch = ENV['BRANCH'])
  set :branch, branch
else
  set :branch, 'master'
end
set :vhost, 'dev-publish.extension.org'
set :deploy_server, 'dev-publish.aws.extension.org'
server deploy_server, :app, :web, :db, :primary => true
