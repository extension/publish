<?php
/*
Plugin Name: WordPress Mu Google Analytics.
Plugin URI: http://www.be-lifted.com/
Description: One solution for Google Analytics for the entire site and for each blog! Translated by <a href="http://www.be-lifted.com"> Be-lifted</a> 
Author: Rafik Ouerchefani, Translation by George Abhishek Cherian
Version: 0.1
Author URI: http://themajesty.asslema.net/
*/

if ( strpos($_SERVER['REQUEST_URI'], 'wp-admin') == true )
{
	include_once dirname(__FILE__) . '/rafik_ga/rafik_ga_admin.php';
}

function analytics_code_paster()
{
	global $current_site;
	if ( strpos($_SERVER['REQUEST_URI'], 'wp-admin') == true )
	{
	return ;
	}

	$blog_urchin = get_option('rafik_wpmu_analytics_blog_urchin');
	$site_urchin = get_site_option('rafik_wpmu_analytics_admin_urchin');

		if (!$blog_urchin) 
		{
			if ($site_urchin){
			
			// blog : non / site : oui
			echo '
				<!-- WordPress Mu Google Analytics by Rafik : http://themajesty.asslema.net/ Translated by George Abhishek Cherian : http://www.be-lifted.com/ -->

				<script type="text/javascript">
				var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
				document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
				</script>
				<script type="text/javascript">
				var pageTracker = _gat._getTracker("'.$site_urchin.'");
				pageTracker._trackPageview();
				</script> 
				';
			}
		}else{
			if (!$site_urchin){
			// blog : oui / site : non
			echo '
				<!-- WordPress Mu Google Analytics by Rafik : http://themajesty.asslema.net/  Translated by George Abhishek Cherian : http://www.be-lifted.com/ -->
                                <script type="text/javascript">
                                var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
                                document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
                                </script>
                                <script type="text/javascript">
                                var pageTracker = _gat._getTracker("'.$blog_urchin.'");
                                pageTracker._trackPageview();
                                </script>
				';
			}else{
			// blog : oui / site : oui
			echo '
				<!-- WordPress Mu Google Analytics by Rafik : http://themajesty.asslema.net/ Translated by George Abhishek Cherian : http://www.be-lifted.com/ -->
                                <script type="text/javascript">
                                var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
                                document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
                                </script>
 
				<script type="text/javascript">
				var firstTracker = _gat._getTracker("'.$site_urchin.'");
				firstTracker._trackPageview();
				var secondTracker = _gat._getTracker("'.$blog_urchin.'");
				secondTracker._trackPageview();
				</script>

				';
			}
		}// blog : non / site : non => on s'en fou
}
add_action('wp_footer','analytics_code_paster');
?>
