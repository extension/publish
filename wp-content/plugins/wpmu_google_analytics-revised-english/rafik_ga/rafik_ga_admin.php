<?php
// Site Admin
function admin_urchin_page(){
				// only allow site admins to come here.
	if( is_site_admin() == true ) 	{
		add_submenu_page('wpmu-admin.php',__('Google Analytics'),__('Google Analytics'), 'administrator', basename(__FILE__), 'admin_urchin_options');
					}
}

function admin_urchin_options()
{
	if ( isset($_POST['action'])&& ( $_POST['action'] == 'update_rafik_wpmu_analytics_admin_urchin' )){
	
		update_site_option('rafik_wpmu_analytics_admin_urchin', $_POST['rafik_wpmu_analytics_admin_urchin']);
		
		?><div id="message" class="updated fade"><p><?php _e('Options saved.') ?></p></div><?php
	}
	$admin_urchin = get_site_option('rafik_wpmu_analytics_admin_urchin');

	if (!admin_urchin){
		$admin_urchin = '';
	}
?>
<div class="wrap">
<h2><?php  _e('Configuration Google Analytics'); ?></h2>
<form method="post" action="">
<input type="hidden" name="action" value="update_rafik_wpmu_analytics_admin_urchin" />
<fieldset class="options">
<p>
<label for="script">Enter your account number for Google Analytics (looks like "UA-xxxxxxx-xx" or "UA-xxxxxxx-x" )</label>
</p>
<input maxlength="13" name="rafik_wpmu_analytics_admin_urchin" value="<?php echo $admin_urchin ?>" />
</fieldset>
<p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options') ?>" /></p>
 
</form>
</div>
<?php
}

add_action('admin_menu', 'admin_urchin_page');

// Blog Options
function blog_urchin_options()
{
	if ( isset($_POST['action'])&& ( $_POST['action'] == 'update_rafik_wpmu_analytics_blog_urchin' )){
	
		update_option('rafik_wpmu_analytics_blog_urchin', $_POST['rafik_wpmu_analytics_blog_urchin']);
		
		?><div id="message" class="updated fade"><p><?php _e('Options saved.') ?></p></div><?php
	}
	$blog_urchin = get_option('rafik_wpmu_analytics_blog_urchin');

	if ( !$blog_urchin ){
		$blog_urchin = '';
	}
?>
<div class="wrap">
<h2><?php  _e('Configuration Google Analytics'); ?></h2>
<form method="post" action="">
<input type="hidden" name="action" value="update_rafik_wpmu_analytics_blog_urchin" />
<fieldset class="options">
<p>
<label for="script">Enter your account number for <a href="http://www.google.com/analytics/">Google Analytics</a> (looks like "UA-xxxxxxx-x" or "UA-xxxxxxx-xx" ) :</label>
</p>
<input maxlength="13" name="rafik_wpmu_analytics_blog_urchin" value="<?php echo $blog_urchin ?>" />
</fieldset>
<p class="submit"><input type="submit" name="Submit" value="<?php _e('Update Options') ?>" /></p>
 
</form>
</div>
<div class="wrap"> 
  <h2>Utilisation</h2>
      <fieldset class="options">
		<p>Google Analytics gives you a code like this one :</p>
		<p>
	  <textarea style="height:100px; width:500px;"><?php _e(htmlspecialchars('
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-xxxxxxx-xx";
urchinTracker();
</script>')); ?></textarea></p>
		<p>Your account number is UA-xxxxxxx-xx. Copy and paste it into the fields above ..
	</fieldset>
</div>
<?php
}

function blog_urchin_page(){
	add_options_page(__('Google Analytics'),__('Google Analytics'),8,basename(__FILE__),'blog_urchin_options');
} 
add_action('admin_menu','blog_urchin_page');
?>
