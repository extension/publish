set :deploy_to, "/services/blogs/"
set :branch, 'master'
set :vhost, 'blogs.extension.org'
set :deploy_server, 'blogs.aws.extension.org'
server deploy_server, :app, :web, :db, :primary => true
