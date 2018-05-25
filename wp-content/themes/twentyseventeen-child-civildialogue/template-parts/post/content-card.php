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


$term_list = wp_get_post_terms($post->ID, 'resource', array("fields" => "all"));
?>
  <div id="post-<?php the_ID(); ?>" class="card resource-<?php echo $term_list[0]->slug; ?>">
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
