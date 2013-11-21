<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage spectacular
 * @since spectacular 1.0
 */
?>
<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
            <div id="paginate">
              <div><?php previous_post_link('%link', '' . _x('','Previous post link','spectacular') . 'prev' ); ?></div>
              <div><?php next_post_link('%link','next' . _x('','Next post link','spectacular') . ''); ?></div>
            </div>
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
  <section id="error404">
    <h1><?php _e( 'Not Found', 'spectacular' ); ?></h1>
    <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'spectacular' ); ?></p>
    <?php get_search_form(); ?>
  </section><!-- #post-0 -->
<?php endif; ?>

<?php
  /* Start the Loop.
   *
   * In Twenty Ten we use the same loop in multiple contexts.
   * It is broken into three main parts: when we're displaying
   * posts that are in the gallery category, when we're displaying
   * posts in the asides category, and finally all other posts.
   *
   * Additionally, we sometimes check for whether we are on an
   * archive page, a search page, etc., allowing for small differences
   * in the loop on each template without actually duplicating
   * the rest of the loop that is shared.
   *
   * Without further ado, the loop:
   */ ?>
<?php while ( have_posts() ) : the_post(); ?>

<?php /* How to display posts in the asides category */ ?>

  <?php if ( in_category( _x('asides', 'asides category slug', 'spectacular') ) ) : ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
      <div class="entry-summary">
        <?php the_excerpt(); ?>
      </div><!-- .entry-summary -->
    <?php else : ?>
      <div class="entry-content">
        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'spectacular' ) ); ?>
      </div><!-- .entry-content -->
    <?php endif; ?>

      <div class="entry-utility">
        <?php the_date('m-j-Y'); ?>
        <span class="meta-sep">|</span>
        <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'spectacular' ), __( '1 Comment', 'spectacular' ), __( '% Comments', 'spectacular' ) ); ?></span>
        <?php edit_post_link( __( 'Edit', 'spectacular' ), '<span class="meta-sep">|</span> <span class="edit-link">', '</span>' ); ?>
      </div><!-- .entry-utility -->
    </div><!-- #post-## -->
  <?php else : ?>
    <section class="excerpt">
      <h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'spectacular' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
      <div>
        <?php spectacular_posted_on(); ?>
      </div><!-- .entry-meta -->
    </section>


  <?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
      <section class="excerpt">
        <?php the_excerpt(); ?>
      </section><!-- .entry-summary -->
  <?php endif; ?>

    <?php comments_template( '', true ); ?>

  <?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>

<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
            <div id="paginate">
              <div><?php previous_post_link('%link', '' . _x('','Previous post link','spectacular') . 'prev' ); ?></div>
              <div><?php next_post_link('%link','next' . _x('','Next post link','spectacular') . ''); ?></div>
            </div>
<?php endif; ?>