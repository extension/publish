set :deploy_to, "/services/publish/"
set :branch, 'master'
set :vhost, 'publish.extension.org'
set :deploy_server, 'publish.awsi.extension.org'
server deploy_server, :app, :web, :db, :primary => true
