<?php
/*
 * Plugin Name: RebelMouse Widget
 * Plugin URI: http://www.rebelmouse.com
 * Description: Add your RebelMouse to your blog. Add and edit in the widgets tab of WordPress or using shortcode.
 * Version: 1.5.9.1
 * Author: Francisco Lavin
 * Author URI: http://www.rebelmouse.com/flavin
 * License: GPLv2 or later
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define( 'REBELMOUSE_FULL_WIDTH_TEMPLATE', 'page-rebelmouse-4-columns.php' );

require_once( dirname(__FILE__) . '/rebelmouse-utils.php');
require_once dirname( __FILE__ ) . '/rebelmouse-admin.php';

/**
 * Templates functions
 **/
function rebelmouse_template_custom_activation() {
    rebelmouse_add_templates_to_theme();
}
register_activation_hook( __FILE__, 'rebelmouse_template_custom_activation' );


function rebelmouse_template_custom_deactivation() {
    rebelmouse_remove_template_from_theme();
}
register_deactivation_hook( __FILE__, 'rebelmouse_template_custom_deactivation' );


/**
 * copy the rebelmouse plugin template for page, to the current theme.
 */
function rebelmouse_add_templates_to_theme(){

    $src_template = dirname( __FILE__ ).'/templates/'.REBELMOUSE_FULL_WIDTH_TEMPLATE;
    $dst_template = get_template_directory().'/'.REBELMOUSE_FULL_WIDTH_TEMPLATE;

    if( ! file_exists( $dst_template ) ) {
        $data = file_get_contents($src_template);
        if ( ! rebelmouse_create_page_template( $data, get_template_directory(), REBELMOUSE_FULL_WIDTH_TEMPLATE) ) {
            //wp_die('plugin need write permissions on the template');
        }
    }
}


function rebelmouse_create_page_template($data, $dst_dir,  $dst_file){
    $result = false;
    
    $destination = get_template_directory().'/'.$dst_file;
    
    if ( file_exists($destination) ) {
        //backup home
        $bkp_file = tempnam($dst_dir, $dst_file);
        rename($destination, $bkp_file);
    }

    if ( !file_exists($destination) ){
        $handle = fopen($destination, "w");
        $result = fwrite($handle, $data);
        fclose($handle);
    } 
    
    return $result;
}


function rebelmouse_remove_template_from_theme(){
    
     rebelmouse_remove_templates_files( REBELMOUSE_FULL_WIDTH_TEMPLATE );
     
}

function rebelmouse_remove_templates_files( $file ) {
    
    //only remove home.php and REBELMOUSE_FULL_WIDTH_TEMPLATE
    if ( in_array( $file, array(REBELMOUSE_FULL_WIDTH_TEMPLATE)) ) {
    
        $dst_template = get_template_directory().'/'.$file;
        //$handle = fopen($dst_template);
        //fclose($handle);
        return unlink($dst_template);
    }
    return false;
}


/**
 * Register the Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget("rebelmouse_widget");' ) );

/**
 * Create the widget class and extend from the WP_Widget
 */
 class Rebelmouse_Widget extends WP_Widget {

	/**
	 * Set the widget defaults
	 */
	private $widget_title = "RebelMouse Social";
	private $site_name = "";
	private $scroll = "auto";

	private $height = "1500";
	private $features = "false";

	private $skip = array();
	private $hide_about = "1";
	private	$hide_following = "1";

    private $show_rebelnav = False;

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		parent::__construct(
			'Rebelmouse_Widget',// Base ID
			'RebelMouse ',// Name
			array(
				'classname'		=>	'Rebelmouse_Widget',
				'description'	=>	__('A widget to add your rebelmouse stream.', 'framework')
			)
		);

	} // end constructor

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$this->widget_title = apply_filters('widget_title', $instance['title'] );

		$this->scroll      = $instance['scroll'];
		$this->height      = $instance['height'];
		$this->site_name   = $instance['site_name'];
	    $this->features    = $instance['features'];

        $this->show_rebelnav = ($instance['show_rebelnav'] == "1" ? True : False );

        $skip_array = array();
        if ( $instance['hide_about'] == "1")
              $skip_array[] = "about-site";
        if ( $instance['hide_following'] == "1")
              $skip_array[] = "following";
        $skip = implode(',', $skip_array);

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $this->widget_title )
			echo $before_title . $this->widget_title . $after_title;

		/* RebelMouse Render*/
        $this->render( array('site_name' => $this->site_name
                            , 'skip' => $skip
                            , 'scroll' => $this->scroll
                            , 'height' => $this->height
                            , 'show_rebelnav' => $this->show_rebelnav
                            , 'embed_type' => 'sidebar'
                            ) );

		/* After widget (defined by themes). */
		echo $after_widget;
	}

    public function render( $args ) {
        echo $this->get_rm_render( $args );
    }

    public function get_rm_render( $args ) {
        $r = wp_parse_args( $args, array('site_name' => 'rebelmouse'
                                    , 'skip' => ''
                                    , 'height' => '0'
                                    , 'show_rebelnav' => False
                                    , 'scroll' => 'auto'
                                    , 'embed_type' => ''
                                    , 'limit' => ''
                                    , 'more_button' => False
                                    ) );

        $r['site_name'] = $this->clean_sitename( $r['site_name'] );

        if ( empty( $r['height'] ) ) {
            $is_flexible   = true;
            $r['height']   = '1500';
            $r['flexible'] = '1';
        } else {
            $is_flexible   = false;
            $r['flexible'] = '0';
        }

        $scrolling = '';
        if ( $r['scroll'] === 'no' )
            $scrolling = 'scrolling="no"';
        elseif ( $r['scroll'] === 'yes' )
            $scrolling = 'scrolling="yes"';

        $url = add_query_arg( array(
            'site'     => rawurlencode( $r['site_name'] ),
            'height'   => urlencode( $r['height'] ),
            'flexible' => urlencode( $r['flexible'] )
        ), 'https://www.rebelmouse.com/static/js-build/embed/embed.js' );

        if ( ! empty( $r['skip'] ) )
            $url = add_query_arg( 'skip', urlencode( $r['skip'] ), $url );

        if ( ! empty( $r['embed_type'] ) )
            $url = add_query_arg( 'embed_type', urlencode( $r['embed_type'] ), $url );

        if ( ! empty( $r['limit'] ) )
            $url = add_query_arg( 'post_limit', urlencode( $r['limit'] ), $url );

        if ( ! empty( $r['more_button'] ) ) {
            $url = add_query_arg( 'more_button', $r['more_button']? '1': '0', $url );
            // more button should be allways related to dont_load_more_posts
            $url = add_query_arg( 'dont_load_new_posts', '1', $url );
        }

        if ( ! empty( $r['show_rebelnav'] ) )
            $url = add_query_arg( 'show_rebelnav', '1', $url );

        $output = '<script type="text/javascript" class="rebelmouse-embed-script" src="' . esc_url( $url ) . '"></script>';

        return $output;
    }

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['site_name'] = strip_tags( $new_instance['site_name'] );
		$instance['scroll'] = strip_tags( $new_instance['scroll'] );
		$instance['features'] = strip_tags( $new_instance['features'] );

		$instance['height'] = strip_tags( $new_instance['height'] );

		$instance['hide_about'] = (bool)$new_instance['hide_about'];
		$instance['hide_following'] = (bool)$new_instance['hide_following'];

		$instance['show_rebelnav'] = (bool)$new_instance['show_rebelnav'];

		return $instance;
	}

    function clean_sitename($sitename) {
        if (! empty($sitename))
            return preg_replace('/^http(s)?:\/\/(www.)?rebelmouse.com\//', '', $sitename);
        else
            '';
    }

	/**
	 * Create the form for the Widget admin
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
                'title' => $this->widget_title,
                'site_name' => $this->site_name,
                'scroll' => $this->scroll,
                'features' => $this->features,

                'height' => $this->height,
                'hide_about' => $this->hide_about,
                'hide_following' => $this->hide_following,

                'show_rebelnav' => $this->show_rebelnav,
            );

		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<div class="rm-widget-content">
            <?php 
            if ( empty( $instance['site_name']) ) {
                $instance['features'] = "false";
            } else if ( ! in_array( $instance['features'], array('true', 'false') )  || $instance['features'] === 'false')  {
                $_response = rebelmouse_request( 'site/details/' . rawurlencode($instance['site_name']) );
                if ( ! empty($_response['paid_site']))
                    $instance['features'] = ($_response['paid_site']) ? "true" : "false";
            }
            ?>

            <!-- Widget Title: Text Input -->
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'framework') ?>: </label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
            </p>

            <!-- Page name: Text Input -->
            <p>
                <label for="<?php echo $this->get_field_id( 'site_name' ); ?>"><?php _e('RebelMouse Site Name', 'framework') ?>: </label>
                <input type="text" class="widefat rm-input-sitename" id="<?php echo $this->get_field_id( 'site_name' ); ?>" name="<?php echo $this->get_field_name( 'site_name' ); ?>" value="<?php echo $instance['site_name']; ?>" placeholder="SiteName"/>
                <br><span class="rm_description">For Rebelmouse.com/<strong>Paul</strong> simply enter <strong>Paul</strong>.</span>
            </p>

            <p>
            <strong>Advance Settings:</strong>
            </p>
            <!-- Show About: Checkbox -->
            <p>
                <input type="checkbox" id="<?php echo $this->get_field_id( 'show_rebelnav' ); ?>" name="<?php echo $this->get_field_name( 'show_rebelnav' ); ?>" value="1" <?php echo ($instance['show_rebelnav'] == True ? "checked='checked'" : ""); ?> />
                <label for="<?php echo $this->get_field_id( 'show_rebelnav' ); ?>"><?php _e('Show Rebel Pages', 'framework') ?></label>
            </p>

            <!-- Height: Text Input -->
            <p>
                <label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height', 'framework') ?>: </label>
                <input type="text" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" size="5" />px
                <br><!-- <span class="rm_description">Leave empty if you want RebelMouse to take the full height of your sidebar.</span> -->
            </p>

            <p>
                <strong>Premium features:</strong>
                <div id="<?php echo $this->get_field_id( 'explanation' );?>" class="rm-power-site-explanation" <?php if ( $instance['features'] === "true" ) { ?>style="display:none;"<?php }?>>
                    <p>Upgrade your Site to be able to remove the <strong>Following</strong> and <strong>About</strong> RebelMouse modules on your embed.</p>
                    <a class="rm-power-site" href="https://www.rebelmouse.com/core/users/pricing/">Upgrade Your Site</a>
                </div>
            </p>

            <p id="<?php echo $this->get_field_id('features-controls');?>" class="featured-controls<?php if ( $instance['features'] !== "true" ) { ?> inactive<?php }?>">
                <!-- Hide about: Checkbox -->
                <input type="checkbox" value="1" 
                        id="<?php echo $this->get_field_id( 'hide_about' ); ?>" 
                        name="<?php echo $this->get_field_name( 'hide_about' ); ?>" 
                        <?php if ( $instance['features'] !== "true" ) { ?>disabled="disabled"<?php } ?>
                        <?php echo ( $instance['hide_about'] ? "checked='checked'" : ""); ?> />
                <label for="<?php echo $this->get_field_id( 'hide_about' ); ?>"><?php _e('Hide About Site', 'framework') ?>.</label>
                <br>

                <!-- Hide Following: Checkbox -->
                <input type="checkbox" value="1" 
                        id="<?php echo $this->get_field_id( 'hide_following' ); ?>" 
                        name="<?php echo $this->get_field_name( 'hide_following' ); ?>" 
                        <?php if ( $instance['features'] !== "true" ) { ?>disabled="disabled"<?php } ?>
                        <?php echo ( $instance['hide_following'] ? "checked='checked'" : ""); ?> />
                <label for="<?php echo $this->get_field_id( 'hide_following' ); ?>"><?php _e('Hide Following', 'framework') ?>.</label>
                <br>

            </p>

            <input type="hidden" id="<?php echo $this->get_field_id('features'); ?>" name="<?php echo $this->get_field_name( 'features' )?>" value="<?php echo $instance['features']; ?>"/>
        </div>

	<?php
	}
 }


/**
 * Display the embed of rebelmouse stream
 *
 * The list of arguments is below:
 *     'site_name' (string) - You rebelmouse site name
 *     'skip' (String) - Element to hide in the stream: about-site
 *     'height' (int) - height of the iframe
 *
 * @param string|array $args Optional. Override the defaults.
 */ 
function rebelmouse_embed( $args ) {
    $rm_widget = new Rebelmouse_Widget();
    $rm_widget->render( $args );
}

/**
 * Shortcode to diplay rebelmouse in your site.
 * 
 * The list of arguments is below:
 *     'site_name' (string) - You rebelmouse site name
 *                    Default: rebelmouse
 *     'skip' (String) - Element to hide in the stream: about-site
 *     'height' (int) - height of the iframe
 *                    Default: initial auto adjustable to 20 posts.
 * 
 * Usage: 
 * [rebelmouse sitename="rebelmouse"]
 * [rebelmouse sitename="rebelmouse" h="1500"]
 * [rebelmouse sitename="rebelmouse" height="1500" type="sidebar"]
 * [rebelmouse sitename="rebelmouse" height="1500" type="sidebar" more_button=true]
 */
function rebelmouse_shortcode( $atts ) {
    $rm_widget = new Rebelmouse_Widget();

    $skip          = ( ! empty( $atts['skip'] ) ) ? $atts['skip'] : '';
    $limit         = ( ! empty( $atts['limit'] ) ) ? $atts['limit'] : '';
    $scroll        = ( ! empty( $atts['scroll'] ) ) ? $atts['scroll'] : 'auto';
    $show_rebelnav = ( ! empty( $atts['show_rebelnav'] ) ) ? $atts['show_rebelnav'] : false;
    $more_button   = ( ! empty( $atts['more_button'] ) ) ? $atts['more_button'] : false;
    $height = '0';
    if ( isset($atts['h']) && ! empty( $atts['h'] ) ) {
        $height = $atts['h'];
    } else if ( isset($atts['height']) && ! empty($atts['height'])) {
        $height = $atts['height'];
    }
    $site_name = '';
    if (isset($atts['sitename']) && ! empty( $atts['sitename'] ) ) {
        $site_name = $atts['sitename'];
    } else if (isset($atts['site_name']) && ! empty( $atts['site_name'] )){
        $site_name = $atts['site_name'];
    }
    $embed_type = '';
    if (isset($atts['type']) && ! empty( $atts['type'] ) ) {
        $embed_type = $atts['type'];
    } else if (isset($atts['embed_type']) && ! empty( $atts['embed_type'] )){
        $embed_type = $atts['embed_type'];
    }

    return $rm_widget->get_rm_render( array(
        'site_name'     => $site_name,
        'skip'          => $skip,
        'limit'         => $limit,
        'more_button'   => $more_button,
        'height'        => $height,
        'scroll'        => $scroll,
        'embed_type'    => $embed_type,
        'show_rebelnav' => $show_rebelnav
    ) );
}
add_shortcode( 'rebelmouse', 'rebelmouse_shortcode' );

?>
