<?php
/**
/* Template Name: Contact */ 
/*
 * @package WordPress
 * @subpackage Spectacular
 * @since Spectacular 1.0
 */

get_header(); ?>
			<div id="main">
				<div id="article" class="module600 contactform">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<?php if ( is_front_page() ) { ?>
						<h2><?php the_title(); ?></h2>
					<?php } else { ?>
						<h1><?php the_title(); ?></h1>
					<?php } ?>
						<?php the_content(); ?>
						<section id="meta">
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
						</section>
<?php endwhile; ?>
				</div>
<?php get_sidebar(); ?>
			</div><!-- #content -->
</div><!-- #container -->
<?php get_footer(); ?>