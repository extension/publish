<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Spectacular
 * @since Spectacular 1.0
 */
get_header(); ?>
      <section id="main">
          <article class="module600">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <div class="paginate">
              <div><?php next_post_link('%link','next' . _x('','Next post link','spectacular') . ''); ?></div>
              <div><?php previous_post_link('%link', '' . _x('','Previous post link','spectacular') . 'prev' ); ?></div>
            </div>
              <div class="entry-meta">
                <time><?php the_time('m-j-Y'); ?></time>
                <h1><?php the_title(); ?></h1>
              </div><!-- .entry-meta -->
              <div class="entry-content">
                <?php the_content(); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'spectacular' ), 'after' => '</div>' ) ); ?>
              </div><!-- .entry-content -->
    
    <?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
              <div id="entry-author-info">
                <div id="author-avatar">
                  <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'spectacular_author_bio_avatar_size', 60 ) ); ?>
                </div><!-- #author-avatar -->
                <div id="author-description">
                  <h2><?php printf( esc_attr__( 'About %s', 'spectacular' ), get_the_author() ); ?></h2>
                  <?php the_author_meta( 'description' ); ?>
                  <div id="author-link">
                    <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
                      <?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'spectacular' ), get_the_author() ); ?>
                    </a>
                  </div><!-- #author-link -->
                </div><!-- #author-description -->
              </div><!-- #entry-author-info -->
    <?php endif; ?>
    
              <div class="entry-utility">
                <?php spectacular_posted_in(); ?>
                <?php edit_post_link( __( 'Edit', 'spectacular' ), '<span class="edit-link">', '</span>' ); ?>
              </div><!-- .entry-utility -->
            <div class="paginate">
              <div><?php next_post_link('%link','next' . _x('','Next post link','spectacular') . ''); ?></div>
              <div><?php previous_post_link('%link', '' . _x('','Previous post link','spectacular') . 'prev' ); ?></div>
            </div>
            <?php comments_template( '', true ); ?>
<?php endwhile; // end of the loop. ?>
          </article>
<?php get_sidebar(); ?>
      </section><!-- #content -->
</div><!-- #container -->
<?php get_footer(); ?>