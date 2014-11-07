set :deploy_to, "/services/blogs/"
set :vhost, 'blogs.extension.org'
server vhost, :app, :web, :db, :primary => true
