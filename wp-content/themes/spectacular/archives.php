<?php /* Template Name: Archives */ 
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Spectacular
 * @since Spectacular 1.0
 */

get_header(); ?>
      <section id="main">
        <section id="archives" class="module600">
          <h1><?php the_title(); ?></h1>
          <div class="group">
            <h2>Archives by Year &amp; Month:</h2>
            <ul class="module60 yearly"><?php wp_get_archives('type=yearly'); ?></ul>
            <ul class="module420"><?php wp_get_archives('type=monthly'); ?></ul>
          </div>
          <div class="group">
            <h2>Archives by Category:</h2>
            <ul><?php wp_list_categories('title_li='); ?></ul>
          </div>
          <div class="group">
            <h2>Archives by Tag:</h2>
            <?php wp_tag_cloud(); ?>
          </div>
        </section>
<?php get_sidebar(); ?>
      </section>
</div><!-- #container -->
<?php get_footer(); ?>