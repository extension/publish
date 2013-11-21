<?php 
/**
 * The template for displaying Category pages.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Spectacular
 * @since Spectacular 1.0
 */

get_header(); ?>
      <section id="main">
        <section id="archives" class="module600">

				<h1><?php
					printf( __( 'Category Archives: %s', 'spectacular' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?></h1>
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '<div class="archive-meta">' . $category_description . '</div>';

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
				?>
        </section>
<?php get_sidebar(); ?>
      </section>
</div><!-- #container -->
<?php get_footer(); ?>