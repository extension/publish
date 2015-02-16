<?php
# http://scottnelle.com/683/ssl-error-upgrading-wordpress-multisite-network/ 
add_filter('https_ssl_verify', '__return_false');
add_filter('https_local_ssl_verify', '__return_false');
?>
