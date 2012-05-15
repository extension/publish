set :deploy_to, '/services/apache/vhosts/blogs.extension.org/docroot/'
server 'blogs.extension.org', :app, :web, :db, :primary => true

