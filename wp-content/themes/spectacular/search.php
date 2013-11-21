<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Spectacular
 * @since Spectacular 1.0
 */

get_header(); ?>
			<section id="main">
				<article class="module600">
<?php if ( have_posts() ) : ?>
					<h1><?php printf( __( 'Search Results for: %s', 'spectacular' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					<?php
					/* Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called loop-search.php and that will be used instead.
					 */
					 get_template_part( 'loop', 'search' );
					?>
<?php else : ?>
					<h2><?php _e( 'Nothing Found', 'spectacular' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'spectacular' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
<?php endif; ?>
				</article>
<?php get_sidebar(); ?>
      </section>
</div><!-- #container -->
<?php get_footer(); ?>