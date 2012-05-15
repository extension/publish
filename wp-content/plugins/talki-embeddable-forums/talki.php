<?php
/**
 * @package Talki
 * @author Team Tal.ki 
 * @version 1.1.6
 */
/*
Plugin Name: Tal.ki Embeddable Forums
Plugin URI: http://wordpress.org/extend/plugins/talki-embeddable-forums/
Description: The easiest way to embed a forum onto your WordPress site.  Admin and Member roles are tightly integrated with WordPress.  Members are notified of new responses.  The forums are Search Engine Optimized (SEO) and have tons of core 'forum' features not available in other plugins.  Supports BBCode, Private & Public Forums, Permalinking, lockable & sticky topics, embedding of media and youtube videos and it will automatically bring a returning member to their last unread reply.
Author: Team Tal.ki
Version: 1.1.6
Author URI: http://tal.ki/
*/


function randstring($len) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $s='';
    for($i=0;$i<$len;$i++) $s.=$chars[rand(0,strlen($chars))];
    return $s;
}

function fetch_embed_code() {
    // default installation
    $shortname = randstring(5).time();
    $fullname = $shortname.".wordpress";
    $embed_data = array('shortname'=>$shortname, 'fullname'=>$fullname);

    $from_server = json_decode(wp_remote_fopen("http://tal.ki/new-embed-code/wordpress/?json=1"), $assoc=true);    
    if(is_array($from_server) && array_key_exists("shortname", $from_server)) {
        $embed_data = $from_server;
    }
    update_option('talki_embed_data', $embed_data);
    return $embed_data;
}

function get_embed_data() {
   $embed_data = get_option('talki_embed_data');
    if(!$embed_data) {
        $embed_data = fetch_embed_code();
    }
    return $embed_data;
}

function create_talki_page() {
    $embed_data = get_embed_data();
    $my_post = array();
    
    $page_named_forum = get_page_by_title('Forum');
    $title = "Forum";
    if($page_named_forum) $title = "Tal.ki Forum";
    
    $my_post['post_title'] = $title;
    $my_post['post_content'] = "Talki forum will be embedded on this page";
    $my_post['post_status'] = 'publish';
    $my_post['post_author'] = 1;
    $my_post['post_category'] = array(1);
    $my_post['post_type'] = 'page';
    $my_post['comment_status'] = 'closed';
    $my_post['ping_status'] = 'closed';
    
    $pid = wp_insert_post( $my_post );
    update_option('talki_pageid', $pid);
}

add_action('wp_head', 'talki_init');

function talki_lol($content) {    
    $embed_data = get_embed_data();    
    $fullname = $embed_data['fullname'];
    $args = "";
    
    $theme_name = get_current_theme();
    $theme_data = get_theme($theme_name);

    $wrap_pre = "<style>.nocomments { display: none; }</style>";
    $wrap_post = "";
    
    if($theme_data['Name']=="WordPress Default" && strpos($theme_data['Description'], '>Kubrick<')==90) {
        $wrap_pre .= "<div style='background-color: white;'>";
        $wrap_post .= "</div>";
    }
    
    if(array_key_exists('site_key',$embed_data) && is_user_logged_in()) {
        $site_key = $embed_data['site_key'];
       $user = wp_get_current_user();
       
       $args = array(
           'uid'=>$user->ID,
           'name'=>$user->display_name,
           'ap'=>'site',
           'expires'=>time()+60*2,
           'domain'=>$fullname,
           'email'=>$user->user_email           
           );

       if(isset($user->caps['administrator']) && $user->caps['administrator']) $args['level'] = 100;
       if(isset($user->caps['editor']) && $user->caps['editor']) $args['level'] = 50;
   
       $sig = generate_signature($args, $site_key);
       $data = serialize_fields($args);
       $args = $data."&sig=".$sig;
    }
    $extra="";
    $footer = get_option('talki_footer');
    if($footer) $extra = '<div style="font-size:80%; text-align:center;" class="talki_promo">get your own <a href="http://tal.ki/">embeddable forum</a> with Talki</div>';

    return <<<EMBED
$wrap_pre    
<script type="text/javascript" src="http://$fullname.embed.tal.ki/embed/1.js?$args"></script>
$wrap_post
$extra
EMBED;
}

function talki_init() {    
    $talkipage_id = get_option('talki_pageid');
    if(!$talkipage_id) { 
        create_talki_page();
    }
    
    $talkipage_id = get_option('talki_pageid');
    if(is_page($talkipage_id)) {
        
        $page = get_page($talkipage_id);
        if($page && $page->post_status!='publish') {
            $page->post_status = 'publish';
            wp_update_post($page);
        }
        add_filter("the_content", "talki_lol");
    }
}

/* admin menus */
add_action('admin_menu', 'talki_add_admin_menu');
function talki_add_admin_menu() {    
    add_options_page('Talki', 'Talki Options', 'administrator', 'talkioptions', 'talki_admin_options');
}

function talki_admin_options() {
    $pageurl = get_page_link(get_option('talki_pageid'));
    echo "<h2>Tal.ki - the easiest way to embed a forum</h2>";
    echo "Forum is visible at this address: <a target='_blank' href='$pageurl'>$pageurl</a>";
    
    if($_POST && $_POST['talki_options']) {  
        update_option('talki_footer', $_POST['talki_footer']=="on");        
    }

    $woot = "";
    if(get_option("talki_footer")) $woot='checked="checked"';
    echo <<<STUFF
     <form name="form_lol" method="post" action="options-general.php?page=talkioptions" style="margin: 15px 0">  
         <input type="hidden" name="talki_options" value="go"/>
         <input type="checkbox" name="talki_footer" $woot/>&nbsp;<strong>Keep Tal.ki free</strong>. Please support our plugin by displaying a link back to our site on your forum's footer
         <br>
         <input type="submit" name="submit" value="Update the setting" />  
    </form>
    
<p>Members will be automatically notified of their responses. You can promote members to moderator and admin status.

<p>Learn more at http://tal.ki/feature-tour/

Suggest a feature at http://talki.uservoice.com/

<h2>Features:</h2>
<ul>
    <li>Customizable with CSS</li>
    <li>BBCode</li>
    <li>Easy-to-use Admin Panel</li>
    <li>Private and Public forums</li>
    <li>Email Notifications on new replies</li>
    <li>Automatic Security Patches and upgrades</li>
    <li>Permalinking support for sharing topics easily between members</li>
    <li>Ability to make announcements at the top of the forum</li>
    <li>Lockable topics</li>
    <li>Create as many sub-forums as needed</li>
    <li>Drag and drop ordering of sub-forums</li>
    <li>Supports Embedding of media such as Images , Video, and Flash</li>
    <li>Automatically brings a returning member to their last unread reply</li>
</ul>    
STUFF;

}


/* Tal.ki SSO stuff */
function serialize_fields($fields) {
    ksort($fields);
    $data = array();
    foreach ($fields as $key => $value) {
        if ($value != "") {
            $data[] = "$key=" . urlencode($value);
        }
    }
    return join("&", $data);
}

function urlsafe_base64_encode($value) {
    $res = base64_encode($value);
    $res = str_replace("+", "-", $res);
    return str_replace("/", "_", $res);
}

function generate_signature($fields, $secret_key) {
    $data = serialize_fields($fields);
    $signature = hash_hmac("sha1", $data, $secret_key, TRUE);
    return urlsafe_base64_encode($signature);
}







function widget_talki_recent_posts($num) {
    $talkipage_id = get_option('talki_pageid');
    if($talkipage_id) {        
        $domain=get_page_link($talkipage_id);
        $embed_data = get_embed_data();
        $fullname = $embed_data['fullname'];
        echo '<script type="text/javascript" src="http://api.tal.ki/v1/widgetembed/?widget=recenttopics&fullname='.$fullname.'&uid=asdfasasd&numitems='.$num.'&target=_top&domain='.$domain.'"></script>';
    }    
}
 
class TalkiRecentPostsWidget extends WP_Widget {
    /** constructor */
    function TalkiRecentPostsWidget() {
        $options = array( 'description' => __( "Shows recent posts from your Tal.ki embedded forum") );
        parent::WP_Widget(false, $name = 'Talki Recent Posts', $options);	
    }

    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $num = $instance['num'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; 
                        widget_talki_recent_posts($num);
                        ?>
                        
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr(isset($instance['title']) ? $instance['title'] : "Tal.ki Recent Topics");
        $num = esc_attr(isset($instance['num']) ? $instance['num'] : 5);
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
            
            <p>
                <label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Number of recent posts:'); ?> </label></p>
	            <select id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>">
                <?php
        		for ( $i = 1; $i <= 20; ++$i )
        			echo "<option value='$i' " . ( $num == $i ? "selected='selected'" : '' ) . ">$i</option>";
                ?>
            	</select>
            </p>            
        <?php 
    }

} // class TalkiRecentPostsWidget

add_action('widgets_init', create_function('', 'return register_widget("TalkiRecentPostsWidget");'));
