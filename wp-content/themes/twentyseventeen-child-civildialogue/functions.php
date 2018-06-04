<?php


function my_theme_enqueue_styles() {

    $parent_style = 'twentyseventeen-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


function categorize_page_settings() {
  // Add category metabox to page
  register_taxonomy_for_object_type('category', 'page');
}
add_action( 'init', 'categorize_page_settings' );


function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}




function add_posttype_slug_template( $single_template ){
  if( has_term( '', 'resource' ) ) {
    $single_template = locate_template( 'single-resource.php' );
  }
  return $single_template;
}
add_filter( 'single_template', 'add_posttype_slug_template' );

/**
 * Custom template tags for this theme.
 */
require get_stylesheet_directory() . '/inc/template-tags.php';



function list_terms_custom_taxonomy( $atts ) {

  extract( shortcode_atts( array(
    'custom_taxonomy' => ''
  ), $atts ) );

  // arguments for function wp_list_categories
  $args = array(
    taxonomy => $custom_taxonomy,
    title_li => ''
  );

  echo '<ul>';
  echo wp_list_categories($args);
  echo '</ul>';
}
add_shortcode( 'ct_terms', 'list_terms_custom_taxonomy' );

//Allow Text widgets to execute shortcodes
// add_filter('widget_text', 'do_shortcode');

?>
