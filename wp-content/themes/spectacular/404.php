<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Spectacular
 * @since Spectacular 1.0
 */

get_header(); ?>
			<section id="main">
				<article class="module600">
					<h1><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'spectacular' ); ?></h1>
					<?php get_search_form(); ?>
			</article>
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>
<?php get_sidebar(); ?>
</div><!-- #container -->
<?php get_footer(); ?>