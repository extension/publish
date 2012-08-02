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
<?php
    $options = get_option('sample_theme_options');
	if($options['sidebar_width'] != ''){
		echo '
#sidebar{
	width: '.$options['sidebar_width'].'px;
	margin-left: '.(930 - $options['sidebar_width']).'px;
}
.narrowcolumn{
	width: '.(860 - $options['sidebar_width']).'px;
}';
	}
?>
</style>
<?php
}

add_custom_image_header('header_style', 'eXtension_admin_header_style');





add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'sample_options', 'sample_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'eXtension' ), __( 'Theme Options', 'eXtension' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options', 'sampletheme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'sampletheme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'sample_options' ); ?>
			<?php $options = get_option( 'sample_theme_options' ); ?>

			<table class="form-table">

				<?php
				/**
				 * A sample text input option
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Right column width', 'eXtension' ); ?></th>
					<td>
						<input id="sample_theme_options[sidebar_width]" class="regular-text" type="text" name="sample_theme_options[sidebar_width]" value="<?php esc_attr_e( $options['sidebar_width'] ); ?>" />
						<label class="description" for="sample_theme_options[sidebar_width]"><?php _e( 'in pixels (between 100 and 400)', 'eXtension' ); ?></label>
					</td>
				</tr>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'sampletheme' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	
	// Say our text option must be safe text with no HTML tags
	$input['sidebar_width'] = (int) wp_filter_nohtml_kses( $input['sidebar_width'] );
	
	$input['sidebar_width'] = (($input['sidebar_width'] > 400 || $input['sidebar_width'] < 100) ? '' : $input['sidebar_width']);
	
	return $input;
}