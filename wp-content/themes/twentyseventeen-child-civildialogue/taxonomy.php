<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="custom_archive" class="content-area">
		<main id="main" class="site-main" role="main">
      <!-- taxonomy.php -->
      <header class="page-header">
  			<?php
  				the_archive_title( '<h1 class="taxonomy-title">', '</h1>' );
  				the_archive_description( '<div class="taxonomy-description">', '</div>' );
  			?>
  		</header><!-- .page-header -->

		<?php
		if ( have_posts() ) : ?>
			<?php
      echo '<h3 class="resource-count ' . $page_category . '">' .  $wp_query->found_posts . ' Resources</h3>';
      echo '<div class="flex-container">';
			/* Start the Loop */
			while ( have_posts() ) : the_post();
        if (get_post_type() == 'post') {
          get_template_part( 'template-parts/post/content', 'card' );
        }
			endwhile;
      echo '</div> <!-- flex-container -->';

      the_posts_pagination( array(
        'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
        'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
      ) );
		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

</div><!-- .wrap -->

<?php get_footer();
