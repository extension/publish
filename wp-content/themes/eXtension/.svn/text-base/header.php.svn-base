<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>





<?php
$js_dir = get_bloginfo('template_directory') . '/js';
$im_dir = get_bloginfo('template_directory') . '/images/';
wp_enqueue_script('jquery_min', "$js_dir/jquery-1.3.2.min.js"); 


wp_enqueue_script('ddsmoothmenu', "$js_dir/ddsmoothmenu.js");

?> 
 <?php wp_head(); ?>
<script type='text/javascript'> 










ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	arrowimages: {down:['downarrowclass', '<?=$im_dir ?>down.gif', 23], right:['rightarrowclass', '<?=$im_dir ?>right.gif']},
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})





$(document).ready(function() { 
	
	
	
	
	
}); 
</script> 


</head>
<body <?php body_class(); ?>>
<ul id="extensionNav">
        <li style="padding-left: 10px; background-image:url(<?php echo $im_dir; ?>ex_logo_header.gif); background-repeat:no-repeat;"><a href="http://www.extension.org/">Public Site</a></li>

        <li><a href="https://www.extension.org/main/about">About</a></li>
        <li><a href="https://www.extension.org/main/communities">Resource Areas</a></li>
        <li><a href="https://www.extension.org/all/news">News</a></li>
        <li><a href="https://www.extension.org/all/articles">Articles</a></li>
        <li><a href="https://www.extension.org/all/faqs">Answers</a></li>
        <li><a href="https://www.extension.org/all/events">Calendar</a></li>
		<li><a href="https://www.extension.org/all/learning_lessons">Learning Lessons</a></li>
</ul>
<div id="page">


<div id="header" role="banner">
	<div id="headerimg">
		<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div class="description"><?php bloginfo('description'); ?></div>
	</div>


<div id="smoothmenu1" class="ddsmoothmenu navbar">
<div class = "searchbar">
				<?php get_search_form(); ?>
	</div>
 <ul> 
           <?php 
		   
		   
		   wp_list_pages('sort_column=menu_order&title_li=');
		   
		   
		   ?>
         </ul> 
		 
	
<br style="clear: left" />
</div>

</div>		
		 
		 
		 
		 
<hr />
