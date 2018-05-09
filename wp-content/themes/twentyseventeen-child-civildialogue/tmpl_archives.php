<?php
/* Template Name: Archive Page Custom */

get_header(); ?>

<div class="wrap">
	<div id="custom_archive" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/page/content', 'tmpl_archives' );

			endwhile; // End of the loop.

      $categories = get_the_category();
      $page_category = $categories[0]->slug;

      $how_many_last_posts = intval(get_post_meta($post->ID, 'archived-posts-no', true));
      if($how_many_last_posts > 200 || $how_many_last_posts < 2) $how_many_last_posts = 100;
      $args = array( 'posts_per_page' => 50, 'category_name' => $page_category, 'orderby'=> 'title', 'order' => 'ASC' );
      $wp_query = new WP_Query($args);

      if($wp_query->have_posts()) {
        echo '<h3 class="resource-count ' . $page_category . '">' .  $wp_query->found_posts . ' Resources</h3>';
        echo '<div class="flex-container">';
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
        echo '</div>';

        the_posts_pagination( array(
  				'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
  				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
  				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
  			) );


        wp_reset_postdata();


      }
      ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
