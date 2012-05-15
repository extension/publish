<?php

// widgetize sidebar
if ( function_exists('register_sidebar') )
    register_sidebar();

//make changeable header

define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/eX_default.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 958);
define('HEADER_IMAGE_HEIGHT', 240);
define( 'NO_HEADER_TEXT', true );

function eXtension_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}

#headimg h1, #headimg #desc {
	display: none;
}

</style>
<?php
}

function header_style() {
?>
<style type="text/css">
#header{
	background: url(<?php header_image() ?>) no-repeat;
}
</style>
<?php
}

add_custom_image_header('header_style', 'eXtension_admin_header_style');

?>