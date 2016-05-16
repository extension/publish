<?php

function remove_footer_admin () {
  echo 'Thank you for creating with <a href="https://wordpress.org/">WordPress</a> | <a href="http://www.extension.org/main/termsofuse" target="_blank">Terms of Use</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');


function extensionresponsive_customize_register( $wp_customize ) {
     $wp_customize->add_setting('ex_logo_color', array(
        'default'        => 'color',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control( 'example_select_box', array(
        'settings' => 'ex_logo_color',
        'label'   => 'eXtension Logo',
        'section' => 'title_tagline',
        'type'    => 'select',
        'choices'    => array(
            'white' => 'White logo',
            'color' => 'Color logo',
        ),
    ));
}
add_action( 'customize_register', 'extensionresponsive_customize_register' );

function extensionresponsive_customize_css()
{
  if (get_option('ex_logo_color') == "white") {
    $logo_image = "/assets/images/ex_logo_white.png";
  } else {
    $logo_image = "/assets/images/ex_logo_color.png";
  }
    ?>
    <style type="text/css">
    .site-header .home-link {
      background-image: url(<?php echo get_stylesheet_directory_uri(); ?><?php echo $logo_image; ?>) !important;
    }
    </style>
    <?php
}
add_action( 'wp_head', 'extensionresponsive_customize_css');
