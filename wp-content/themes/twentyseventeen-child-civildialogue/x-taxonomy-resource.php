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

	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header><!-- .page-header -->
	<?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
category-resources
		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
      while($wp_query->have_posts()) {
        $wp_query->the_post();
        ?>
        <div class="card card-<?php echo $page_category; ?>">
        <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">

          <h2><?php the_title(); ?></h2></a>
          <p><?php echo excerpt(24); ?></p>
          <?php
            $posttags = get_the_tags();
          if ($posttags) {
            echo '<p class="card-tag-header">Keywords</p>';
            echo '<ul class="resource-tags">';
            foreach($posttags as $tag) {
              echo '<li class="resource-tag"><span>' . $tag->name . '</span></li>';
            }
            echo '</ul>';
          }
          ?>


        </div>
        <?php
      }

		else :

			get_template_part( 'template-parts/post/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
