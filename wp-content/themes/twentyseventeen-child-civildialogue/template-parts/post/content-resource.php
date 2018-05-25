<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php

		if ( 'post' === get_post_type() ) {
			echo '<div class="entry-meta">';
      twentyseventeen_posted_on();
			echo '</div><!-- .entry-meta -->';
		};

		the_title( '<h1 class="entry-title">', '</h1>' );
    twentyseventeen_edit_link();
		?>
	</header><!-- .entry-header -->


  <?php
  // $post_target_audience_terms = get_the_tags();
  $post_target_audience_term_list = wp_get_post_terms($post->ID, 'target_audience', array("fields" => "all"));
  if ($post_target_audience_term_list) {

    echo '<div class="resource-post-tags clearfix"><p class="card-tag-header">Target Audiences</p>';
    echo '<ul class="resource-tags">';
    foreach($post_target_audience_term_list as $tag) {
      echo '<li class="resource-tag"><span><a href="' . get_term_link($tag) . '">' . $tag->name . '</a></span></li>';
    }
    echo '</ul></div>';
  }
  ?>

  
  <?php
  $posttags = get_the_tags();
  if ($posttags) {

    echo '<div class="resource-post-tags clearfix"><p class="card-tag-header">Keywords</p>';
    echo '<ul class="resource-tags">';
    foreach($posttags as $tag) {
      echo '<li class="resource-tag"><span><a href="' . get_term_link($tag) . '">' . $tag->name . '</a></span></li>';
    }
    echo '</ul></div>';
  }
  ?>



	<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'twentyseventeen-featured-image' ); ?>
			</a>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>

	<div class="entry-content">
		<?php
		/* translators: %s: Name of current post */
		the_content( sprintf(
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
			get_the_title()
		) );
		?>
	</div><!-- .entry-content -->



	<?php
	if ( is_single() ) {
		resource_post_entry_footer();
	}
	?>

</article><!-- #post-## -->
