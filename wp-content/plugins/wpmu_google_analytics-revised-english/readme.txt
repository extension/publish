	Translation: French » English

	by George Abhishek Cherian

	 http://www.be-lifted.com
********************************************
********************************************

        WordPress Mu Google Analytics.

              Rafik Ouerchefani

       http://themajesty.asslema.net/



********************************************
********************************************

Description: A solution for Google Analytics for the entire site and for each blog!

************
Installation
************

Upload the files:

wp_content / mu-plugins / rafik_ga.php
wp_content / mu-plugins / rafik_ga / rafik_ga_admin.php


*************
Configuration
*************

To set up Google Analytics on this site:
> Admin. Site> Google Analytics.
Paste the Google Analytics (in the form "UA-xxxxxxx-x").

To set up Google Analytics on a specific blog, blog administrator can set his own blog:
> Options> Google Analytics.
Paste the Google Analytics (in the form "UA-xxxxxxx-x").

That's it!
 
Note: Make sure you have the wp_footer hook "<?php wp_footer(); ?> " in  your footer.php or else it wont work.