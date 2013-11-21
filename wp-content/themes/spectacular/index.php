<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Spectacular
 * @since Spectacular 1.0
 */
get_header(); ?>

      <section id="featured">
      <?php // Display Featured post on homepage only ?>
          <section>
            <mark>The Workshop Venue</mark>
  <?php $my_query = new WP_Query('category_name=featured&posts_per_page=1');
  while ($my_query->have_posts()) : $my_query->the_post();
  $do_not_duplicate = $post->ID; ?>
            <?php the_post_thumbnail(); ?>
            <div>
            <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s'), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            <time><span><?php the_date('M j'); ?></span></time>
            <?php the_excerpt(); ?>
            </div>
          </section>
        </section>
    <?php endwhile; ?>
        <section id="main">
        <?php /* Add heading if on homepage */ if ( is_home());?>
      <h1 id="blog-intro"><span class="before">Be, Grow, Create, Explore</span><span class="ampersand"><img src="wp-content/themes/spectacular/images/ampersand.png" alt="And"></span><span class="after"> Transform</span></h1>
  <?php if (have_posts()) : while (have_posts()) : the_post(); 
  if( $post->ID == $do_not_duplicate ) continue;?>
      <section class="entry module460">
      <div class="excerpt">
        <div class="excerpt-thumb">
        <?php the_post_thumbnail('thumbnail'); ?>
        </div>
        <div class="excerpt-body">
      <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'Spectacular' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        <time><?php the_time('m-j-Y'); ?></time><em><?php the_author(); ?></em>
        <?php the_excerpt(); ?>
        </div>
      </div>
    </section><!-- #post-## -->
<?php endwhile; endif; ?>
    </section><!-- #main -->
      </div><!-- #container -->
    <?php get_footer(); ?>