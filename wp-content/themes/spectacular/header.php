<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Spectacular
 * @since Spectacular 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;

  wp_title( '|', true, 'right' );

  // Add the blog name.
  bloginfo( 'name' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    echo " | $site_description";

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 )
    echo ' | ' . sprintf( __( 'Page %s', 'spectacular' ), max( $paged, $page ) );

  ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<script src="<?php bloginfo('template_url'); ?>/scripts/modernizr-1.6.min.js"></script>
<script src="<?php bloginfo('template_url'); ?>/scripts/plugins.js?v=1"></script>
<?php
  /* We add some JavaScript to pages with the comment form
   * to support sites with threaded comments (when in use).
   */
  if ( is_singular() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );

  /* Always have wp_head() just before the closing </head>
   * tag of your theme, or you will break many plugins, which
   * generally use this hook to add elements to <head> such
   * as styles, scripts, and meta tags.
   */
  wp_head();
?>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url' ); ?>">
<!--[if lt IE 9 ]><link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url' ); ?>/ltie9.css"><![endif]-->
</head>

<!--[if lt IE 7 ]> <body<?php mytheme_body_control(); ?> class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body<?php mytheme_body_control(); ?> class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body<?php mytheme_body_control(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body<?php mytheme_body_control(); ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body<?php mytheme_body_control(); ?>> <!--<![endif]-->
  <header>
    <section>
      <div id="site-name"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a><span><?php bloginfo( 'description' ); ?></span></div>
      <nav>
        <ul>
          <li><a href="<?php echo home_url( '/' ) ?>" rel="home">Home</a></li><?php wp_list_pages('title_li=&include=2,20,16,18'); ?>
        </ul>
      </nav>
<?php dynamic_sidebar( 'header-widget-area' ); ?>
</section>
  </header><!-- #header -->
  <div id="container">