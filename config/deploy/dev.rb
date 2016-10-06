set :deploy_to, "/services/blogs/"
if(branch = ENV['BRANCH'])
  set :branch, branch
else
  set :branch, 'master'
end
set :vhost, 'dev-blogs.extension.org'
set :deploy_server, 'dev-blogs.aws.extension.org'
server deploy_server, :app, :web, :db, :primary => true
