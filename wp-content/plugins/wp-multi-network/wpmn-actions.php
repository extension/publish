<?php
/**
 * Action calls for WP-Multi-Network
 */

add_filter( 'blog_option_upload_path', 'wpmn_fix_subsite_upload_path', 10, 2 );

/**
 * Blank out the value of upload_path when creating a new subsite
 */
if( ! function_exists( 'wpmn_fix_subsite_upload_path' ) ) {
	
	/**
	 * Keep uploads for a newly-created subsite from being stored under the parent site
	 *   when ms_files_rewriting is off
	 * 
	 * @since 1.4
	 */
	function wpmn_fix_subsite_upload_path( $value, $blog_id ) {
		global $current_site;
		
		if ( $blog_id == $current_site->blog_id ) {
			
			if( ! get_option( 'WPLANG' ) ) {
				return '';
			}
		}
		return $value;
	}
	
}

?>
