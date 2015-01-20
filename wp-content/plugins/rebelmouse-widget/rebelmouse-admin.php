<?php

// fix PHP Fatal error:  Call to undefined function wp_verify_nonce()
require_once( ABSPATH .'wp-includes/pluggable.php' );
// require template.php to use add_settings_error
require_once( ABSPATH .'wp-admin/includes/template.php' );
// to use theme functions
require_once( ABSPATH .'wp-includes/theme.php' );

add_action('admin_menu', 'rebelmouse_create_setting_menu');


rebelmouse_warnings();

/**
 * show error when:
 * we don't have permissions in theme directory and not have the template for fullwidth 
 * and to create home page.
 * 
 * show warning:
 * when don't have writable permission to create home page.
 */
function rebelmouse_warnings() {

    $rembelmouse_template = get_template_directory() . '/' .  REBELMOUSE_FULL_WIDTH_TEMPLATE;

    if ( ! file_exists( $rembelmouse_template ) ) {

        if ( ! is_writable( get_template_directory() ) )  {
            function rebelmouse_alert() {
                global $rebelmouse_admin_page;
                if ( get_current_screen()->id != $rebelmouse_admin_page )
                    return;
                ?>
                <div class='error'>
					<p><strong>RebelMouse Error</strong>: Theme directory is not writable.</p>
					<p><strong><?php echo get_template_directory();?></strong></p>
					<p>Please adjust its file permissions/ownership.</p>
				</div>
                <?php
            }
            add_action( 'admin_notices', 'rebelmouse_alert' );
        } else {
            rebelmouse_add_templates_to_theme();
        }
    }
}



/**
 * Setting link after install the plugin 
 * @return string
 */
function rebelmouse_plugin_action_links( $links, $file ) {
    if ( $file == plugin_basename( dirname(__FILE__) . '/rebelmouse-widget.php' ) ) {
        $links[] = '<a href="admin.php?page=rebelmouse-key-setting">' . __('Settings') . '</a>';
    }

    return $links;
}
add_filter( 'plugin_action_links', 'rebelmouse_plugin_action_links', 10, 2 );


function rebelmouse_load_js_and_css() {
    wp_enqueue_script( 'rebelmouse_widget_js', plugins_url( '/js/rebelmouse-plugin.js', __file__ ) );
    wp_enqueue_style( 'rebelmouse_widget_css', plugins_url( '/css/rebelmouse-plugin.css', __file__ ) );
}
add_action( 'admin_enqueue_scripts', 'rebelmouse_load_js_and_css' );


/**
 * Create the setting link and register settings
 */
function rebelmouse_create_setting_menu() {
    global $rebelmouse_admin_page;
    
    $rebelmouse_admin_page = add_options_page( 'RebelMouse settings', 'RebelMouse Settings', 'manage_options', 'rebelmouse-key-setting', 'rebelmouse_settings_page' );
    add_action( 'admin_init', 'rebelmouse_register_mysettings' );
}


function rebelmouse_register_mysettings() {
    register_setting( 'rebelmouse-settings-group', 'rebelmouse_sitename' );
    register_setting( 'rebelmouse-settings-group', 'rebelmouse_premium' );
    register_setting( 'rebelmouse-settings-group', 'rebelmouse_hide_about' );
    register_setting( 'rebelmouse-settings-group', 'rebelmouse_hide_following' );
}


/**
 * utility to create tabs
 * @param String $current, the current tab name.
 */
function rebelmouse_tabs_setting( $current = 'homepage' ) {
        $tabs = array( 
                    'homepage' => 'Make RebelMouse your Home',
                    'page'     => 'Create a new Page' );
        echo '<h2 class="nav-tab-wrapper">';
        foreach( $tabs as $tab => $name ){
            $class = ( $tab == $current ) ? ' nav-tab-active' : '';
            echo "<a class='nav-tab$class' href='?page=rebelmouse-key-setting&tab=$tab'>$name</a>";
        }
        echo '</h2>';
}


/**
 * The admin page for rebelmouse settings.
 */
function rebelmouse_settings_page() { 
    global $rebelmouse_admin_page;

    if ( get_current_screen()->id != $rebelmouse_admin_page)
        return;
   ?>
<div id="rebelmouse_settings_content" class="wrap rebelmouse-settings">
    
    <div class="icon32" style="background-image:url(<?php echo plugin_dir_url( __FILE__ ) . 'img/TheMouse-32-32.png'?>)" ><br></div>
    <h2>RebelMouse Settings</h2>
RebelMouse makes a great front page for your blog, instantly making it dynamic and social. If you haven't already, you'll need to quickly sign up at <a href="https://www.rebelmouse.com/">rebelmouse.com</a> to use our plugin. <br>
Simply enter your Site name below and we can make it your home page in one step! If you'd prefer you can also choose to set it as a new page. 

    <?php 
    if ( function_exists( 'wp_get_theme' ) ) {
        $theme = wp_get_theme();
        if (  in_array( $theme->get('ThemeURI'), array('http://diythemes.com/thesis/') ) ) {
    ?>
        <div class="rebelmouse-special-themes">
            <h3>Special instruction for your theme "<?php echo $theme->Name ?>":</h3>
            <p>To add RebelMouse in your theme you need</p>
            <ol>
                <li>
                 Add a new <strong>page</strong>. 
                </li>
                <li>
                    <p>then edit and add one shortcode like the following.
                        For example to display RebelMouse.com/Megan
                        <pre><code>[rebelmouse sitename="Megan" height="1500"]</code></pre> 
                    <p>
                    <p>
                        parameters supported
                        <ul>
                            <li> 'sitename' You rebelmouse site name </li>
                            <li> 'height' height of the iframe, empty by default set auto-adjusting.  </li>
                            <li> 'skip' help you to hide modules (only for <a href="https://www.rebelmouse.com/core/users/pricing/" target="_blank">premium sites</a>)
                                <ul>
                                    <li>
                                    about-site: will hide your About Site.
                                    </li>
                                    <li>
                                    following: will hide your following.
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </p>
                </li>
                <li>
                 Then choose one of the template in the "Page Attribute" section. for example "No Sidebars" to have a full widt rebelmouse.
                </li>
            </ol>
        </div>
    <?php } //end theme detector 
    } ?>
<form method="post" action="options.php">
    <?php 
    
    if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
    else $tab = 'homepage';
    
    rebelmouse_tabs_setting( $tab );
    
    settings_fields( 'rebelmouse-settings-group' );
    wp_nonce_field( plugin_basename( __FILE__ ), 'rebelmouse_noncename' );
    
    switch ( $tab ){
        case 'homepage' : 
            $rebelmouse_sitename        = get_option('rebelmouse_sitename');
            $rebelmouse_premium         = get_option('rebelmouse_premium');
            $rebelmouse_hide_about      = get_option('rebelmouse_hide_about');
            $rebelmouse_hide_following  = get_option('rebelmouse_hide_following');

            if ( empty( $rebelmouse_sitename) ) {
                $rebelmouse_premium = "false";
            } else if ( ! in_array( $rebelmouse_premium ,array('true', 'false' ) ) || $rebelmouse_premium === "false" ) {
                $_response = rebelmouse_request( 'site/details/' . rawurlencode($rebelmouse_sitename) );
                if ( ! empty($_response['paid_site']))
                    $rebelmouse_premium = ($_response['paid_site']) ? "true" : "false";
            }
            ?>
    
            <table class="form-table">
                <tr valign="top">
                    <td colspan="2">
                        <h3>Make RebelMouse your Home</h3>
                        <p>Set RebelMouse as your homepage. Just enter your Site Name below.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">RebelMouse Site Name: </th>
                    <td>
                        <input type="text" id="rebelmouse_home_sitename" name="rebelmouse_sitename" style="width:80%;" value="<?php echo $rebelmouse_sitename; ?>" placeholder="rebelmouse"><br/>
                        <span class="description rm_description">If your site is at rebelmouse.com/<strong>Paul</strong> then you should simply enter "Paul" (without the quotes) in the field above. </em>
                    </td>
                </tr>
                <tr valign="top">
                    <td id="rebelmouse-home-features-controls" <?php if ( $rebelmouse_premium !== "true" ) { ?>class="inactive"<?php }?>>
                        <h3>Premium features:</h3>
                        <!-- Hide About: Checkbox -->
                        <input type="checkbox" value="1" 
                                id="rebelmouse_hide_about" 
                                name="rebelmouse_hide_about" 
                                <?php if ( $rebelmouse_premium !== "true" ) { ?>disabled="disabled"<?php } ?>
                                <?php echo ( $rebelmouse_hide_about ? "checked='checked'" : ""); ?> />
                        <label for="rebelmouse_hide_about"><?php _e('Hide About Site', 'framework') ?>.</label>
                        <br>
                        <!-- Hide Following: Checkbox -->
                        <input type="checkbox" value="1" 
                                id="rebelmouse_hide_following" 
                                name="rebelmouse_hide_following" 
                                <?php if ( $rebelmouse_premium !== "true" ) { ?>disabled="disabled"<?php } ?>
                                <?php echo ( $rebelmouse_hide_following? "checked='checked'" : ""); ?> />
                        <label for="rebelmouse_hide_following"><?php _e('Hide Following', 'framework') ?>.</label>
                        <br>
                    </td>
                    <td>
                        <div id="rebelmouse-home-explanation" class="rm-power-site-explanation" <?php if ( $rebelmouse_premium === "true" ) { ?>style="display:none;"<?php }?>>
                            <p>Upgrade your Site to be able to remove the <strong>Following</strong> and <strong>About</strong> RebelMouse modules on your embed.</p>
                            <a class="rm-power-site" href="https://www.rebelmouse.com/core/users/pricing/" target="_blank">Upgrade Your Site</a>
                        </div>
                    </td>
                </tr> 
                </table>
        
            <p class="submit">
                <input type="hidden" id="rebelmouse-home-features" name="rebelmouse_premium" value="<?php echo $rebelmouse_premium ?>"/>
                <?php 
                    $rebelmouse_on_front = get_option( 'rebelmouse_on_front', false );
                    if ($rebelmouse_on_front) {
                        ?>
                        <input type="submit" class="button-secundary" name="submit_button" value="<?php _e('Remove current home') ?>" />
                        <?php 
                    }
                ?>
                <input type="submit" class="button-primary" name="submit_button" value="<?php _e('Set as Home') ?>" />
            </p>

        <?php
		break; 
		
		case 'page' :  
		    ?>
            <table class="form-table">
                <tr valign="top">
                    <td colspan="2">
                        <h3>Create a new Page</h3>
                        <p>Quickly add a new page powered by RebelMouse.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">RebelMouse Site Name: </th>
                    <td>
                        <input type="text" id="rebelmouse_page_sitename" name="rebelmouse_page_sitename" style="width:600px;" value="" placeholder="rebelmouse"><br/>
                        <span class="description rm_description">If your site is at rebelmouse.com/<strong>Paul</strong> then you should simply enter "Paul" (without the quotes) in the field above. </em>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Wordpress Page Title: </th>
                    <td>
                        <input type="text" name="rebelmouse_page_title" style="width:600px;" value="" placeholder="Social stream">
                    </td>
                </tr>
                <tr valign="top">
                    <td id="rebelmouse-page-features-controls" class="inactive">
                        <h3>Premium features:</h3>
                        <!-- Hide About: Checkbox -->
                        <input type="checkbox" value="1" 
                                id="rebelmouse_page_hide_about" 
                                name="rebelmouse_page_hide_about" 
                                disabled="disabled"
                                />
                        <label for="rebelmouse_page_hide_about"><?php _e('Hide About Site', 'framework') ?>.</label>
                        <br>
                        <!-- Hide Following: Checkbox -->
                        <input type="checkbox" value="1" 
                                id="rebelmouse_page_hide_following" 
                                name="rebelmouse_page_hide_following" 
                                disabled="disabled" />
                        <label for="rebelmouse_page_hide_following"><?php _e('Hide Following', 'framework') ?>.</label>
                        <br>
                    </td>
                    <td>
                        <div id="rebelmouse-page-explanation" class="rm-power-site-explanation">
                            <p>Upgrade your Site to be able to remove the <strong>Following</strong> and <strong>About</strong> RebelMouse modules on your embed.</p>
                            <a class="rm-power-site" href="https://www.rebelmouse.com/core/users/pricing/" target="_blank">Upgrade Your Site</a>
                        </div>
                    </td>
                </tr> 
            </table>
        
            <p class="submit">
                <input type="submit" class="button-primary" name="submit_button" value="<?php _e('Add page') ?>" />
            </p>
        <?php 
        break;
        }
        ?>

</form>
</div>
<?php 

}


/**
 * 
 * @param string $site_name
 * @param string $page_title
 * @param string $skip
 * @return int|boolean new page post_id, or false.
 */
function rebelmouse_add_page( $site_name, $page_title, $skip) {
    global $rebelmouse_admin_page;

    $skip = ( ! empty( $skip ) ) ? 'skip=' . $skip : '';
    
    $new_page_content = '[rebelmouse site_name="' . $site_name . '" ' . $skip . ']';
    $new_page_template = REBELMOUSE_FULL_WIDTH_TEMPLATE;
    
    $page_check = get_page_by_title($page_title);
    
    $new_page = array(
            'post_type'    => 'page',
            'post_title'   => $page_title,
            'post_content' => $new_page_content,
            'post_status'  => 'publish',
            'post_author'  => 1,
    );
    
    $GLOBALS['wp_rewrite'] = new WP_Rewrite();
    $new_page_id = wp_insert_post($new_page);
    if ( is_wp_error($new_page_id) )
        add_settings_error( $rebelmouse_admin_page, 'rebelmouse_page_error', 'something happen try again.', 'error');
    elseif(!empty($new_page_template)){
        update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
        return $new_page_id;
    }
    return false;
}


if ( isset($_POST['action']) && $_POST['action'] == 'update' && (isset( $_POST['rebelmouse_noncename'] ) && wp_verify_nonce( $_POST['rebelmouse_noncename'], plugin_basename( __FILE__ ) )) ) {

    if ( $_POST['submit_button'] === translate( 'Add page' ) ){

        $rebelmouse_page_sitename = esc_html( $_POST['rebelmouse_page_sitename'] );
        $rebelmouse_page_sitename = ( !empty($rebelmouse_page_sitename) )? $rebelmouse_page_sitename: 'rebelmouse';
        $rebelmouse_page_title    = esc_html( $_POST['rebelmouse_page_title'] );
        $rebelmouse_page_title    = ( !empty($rebelmouse_page_title) )? $rebelmouse_page_title: $rebelmouse_page_sitename;

        $rebelmouse_hide_about      = (!isset($_POST['rebelmouse_page_hide_about'])) ? "0": $_POST['rebelmouse_page_hide_about'];
        $rebelmouse_hide_following  = (!isset($_POST['rebelmouse_page_hide_following'])) ? "0": $_POST['rebelmouse_page_hide_following'];

        $skip_array = array();
        if ( $rebelmouse_hide_about == "1")
              $skip_array[] = "about-site";
        if ( $rebelmouse_hide_following == "1")
              $skip_array[] = "following";
        $skip = implode(',', $skip_array);
        
        $page_id = rebelmouse_add_page($rebelmouse_page_sitename, $rebelmouse_page_title, $skip);
        
        if ( !empty($page_id) ){
            add_settings_error( $rebelmouse_admin_page, 'rebelmouse_page_created', sprintf('Page created, you can edit <a href="%s">as other pages</a>, and see in action <a href="%s">here</a>.',  get_admin_url(null, 'edit.php?post_type=page'), get_permalink($page_id)), 'updated');
        }

    } elseif ( $_POST['submit_button'] === translate( 'Set as Home' ) ){

        update_option('rebelmouse_sitename', esc_html( $_POST['rebelmouse_sitename'] ) );
        $rebelmouse_sitename = esc_html( $_POST['rebelmouse_sitename'] );
        $rebelmouse_sitename = ( !empty($rebelmouse_sitename) )? $rebelmouse_sitename: 'rebelmouse';

        $rebelmouse_premium = esc_html( $_POST['rebelmouse_premium'] );
        update_option('rebelmouse_premium', $rebelmouse_premium);

        $rebelmouse_hide_about      = (!isset($_POST['rebelmouse_hide_about'])) ? "0": $_POST['rebelmouse_hide_about'];
        $rebelmouse_hide_following  = (!isset($_POST['rebelmouse_hide_following'])) ? "0": $_POST['rebelmouse_hide_following'];
        update_option('rebelmouse_hide_about', $rebelmouse_hide_about);
        update_option('rebelmouse_hide_following', $rebelmouse_hide_following);

        $skip_array = array();
        if ( $rebelmouse_hide_about == "1")
              $skip_array[] = "about-site";
        if ( $rebelmouse_hide_following == "1")
              $skip_array[] = "following";
        $skip = implode(',', $skip_array);

        $page_id = rebelmouse_add_page($rebelmouse_sitename, $rebelmouse_sitename, $skip);

        if ( !empty($page_id) ){
            
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $page_id );
            update_option( 'rebelmouse_on_front', $rebelmouse_sitename );
            update_option( 'rebelmouse_page_on_front', $page_id );
            
            add_settings_error( $rebelmouse_admin_page, 'rebelmouse_home_created', sprintf('Home created, check it out <a href="%s">here</a>.', get_bloginfo('url')), 'updated');
        }

    } elseif ( $_POST['submit_button'] === translate( 'Remove current home' ) ){

        $homepage_id = get_option( 'page_on_front');
        
        update_option( 'show_on_front', 'posts' );
        update_option( 'page_on_front', 0 );
        update_option( 'rebelmouse_on_front', '' );
        update_option( 'rebelmouse_page_on_front', 0 );
        
        wp_delete_post( $homepage_id, true );
        
    }
}

?>
