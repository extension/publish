<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

		</div><!-- #main -->




		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'main' ); ?>

      <section class="nifa-usda">
        <div class="nifa-usda-primary">
          <p><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/usda-nifa.png" alt="<?php bloginfo( 'name' ); ?>" /></p>
          <p>This work is supported by the USDA National Institute of Food and Agriculture, New Technologies for Ag Extension project.</p>
        </div>
        <div class="nifa-usda-secondary">
          <p class="sidebar-image"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cooperative_extension.png" alt="<?php bloginfo( 'name' ); ?>" /></p>
        </div>
      </section>

      <div class="extension-meta-footer">
        <ul>
          <li><a href="https://extension.org/membership/current/">eXtension Members</a></li>
          <li><a href="https://extension.org/privacy/">Privacy</a></li>
          <li><a href="https://extension.org/contact/">Contact Us</a></li>
          <li><a href="https://extension.org/terms-of-use/">Terms of Use</a></li>
        </ul>
        <p>&nbsp;© <?php echo date('Y'); ?> eXtension. All rights reserved.</p>
      </div>

			<div class="site-info">
				<?php do_action( 'twentythirteen_credits' ); ?>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
