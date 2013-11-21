<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Spectacular
 * @since Spectacular 1.0
 */

get_header(); ?>
			<section id="main">
				<article class="module600">
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
				</article>
<aside class="module320">
        <ul>
			<li id="widget_search"><form role="search" method="get" id="searchform" action="http://workshop.extension.org/" >
	<div><label class="screen-reader-text" for="s">Search for:</label>
	<input type="text" value="" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="Search" />
	</div>
	</form></li>
	
	
	<li id="widget_categories"><h3>Subcategories</h3>
		<ul>
			<?php wp_list_pages('title_li=&child_of='.$post->ID); ?>
		</ul>
	</li>
</aside>			
				
				
<?php //get_sidebar(); ?>
			</section><!-- #content -->
</div><!-- #container -->
<?php get_footer(); ?>