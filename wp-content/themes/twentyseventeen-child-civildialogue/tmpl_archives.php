<?php
/* Template Name: Resource Card Gallery Template  */

get_header(); ?>

<div class="wrap">
	<div id="custom_archive" class="content-area">
		<main id="main" class="site-main" role="main">
      <!-- tmpl_archives.php -->
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/page/content', 'tmpl_archives' );

			endwhile; // End of the loop.

      // $categories = get_the_category();
      // $page_category = $categories[0]->slug;
      $term_list = wp_get_post_terms($post->ID, 'resource', array("fields" => "all"));
      $term = $term_list[0]->slug;
      // echo $term;

      // $how_many_last_posts = intval(get_post_meta($post->ID, 'archived-posts-no', true));
      // if($how_many_last_posts > 200 || $how_many_last_posts < 2) $how_many_last_posts = 100;

      if ($term) {
        // echo "<br/>has term";
        $args = array(
          'posts_per_page' => 50,
          'tax_query' => array(
              array(
                  'taxonomy' => 'resource', // the custom vocabulary
                  'field'    => 'slug',
                  'terms'    => $term,      // provide the term slugs
              )
            ),
            'post_type' => 'post',
            'orderby'=> 'title', 'order' => 'ASC'
        );
        $post_query = new WP_Query($args);

        if($post_query->have_posts()) {
          // echo "<br/>have_posts";
          echo '<h3 class="resource-count resource-' . $term . '">' .  $post_query->found_posts . ' Resources</h3>';
          echo '<div class="flex-container">';
          while($post_query->have_posts()) {
            $post_query->the_post();
            get_template_part( 'template-parts/post/content', 'card' );
          }
          echo '</div>';


          wp_reset_postdata();
        }

      }
      ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();
