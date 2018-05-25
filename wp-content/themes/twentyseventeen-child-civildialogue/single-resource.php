<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header();

// If a Page exists which is tagged with this resource term, it's the landing page for this term
$term_list = wp_get_post_terms($post->ID, 'resource', array("fields" => "all"));
?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main resource-post resource-<?php echo $term_list[0]->slug; ?>" role="main">
			<?php
      $inner_args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'resource', // the custom vocabulary
                'field'    => 'slug',
                'terms'    => $term_list[0]->slug,      // provide the term slugs
            )
          ),
          'post_type' => 'page'
      );
      $inner_query = new WP_Query($inner_args);

      while($inner_query->have_posts()) :
        $inner_query->the_post();
        ?>
        <div class="resource-term">
          <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php echo $term_list[0]->name; ?></a>
        </div>
        <?php
      endwhile;

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/post/content', 'resource' );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
