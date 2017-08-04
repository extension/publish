<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

?>

<hr />

<section class="nifa-usda">
  <div class="nifa-usda-primary">
    <p><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/usda-nifa.png" alt="<?php bloginfo( 'name' ); ?>" /></p>
    <p>This work is supported by the USDA National Institute of Food and Agriculture, New Technologies for Ag Extension project.</p>
  </div>
  <div class="nifa-usda-secondary">
    <p class="sidebar-image"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cooperative_extension.png" alt="<?php bloginfo( 'name' ); ?>" /></p>
  </div>
</section>

<div id="footer">
    <p>eXtension provides objective and research-based information and learning opportunities that help people improve their lives. eXtension is a critical part of the Cooperative Extension System and an educational partner of 75 land-grant universities in the United States.</p>

    <div class="extension-meta-footer">
      <ul>
        <li><a href="https://extension.org/membership/current/">eXtension Members</a></li>
        <li><a href="https://extension.org/privacy/">Privacy</a></li>
        <li><a href="https://extension.org/contact/">Contact Us</a></li>
        <li><a href="https://extension.org/terms-of-use/">Terms of Use</a></li>
      </ul>
      <p>&nbsp;© <?php echo date('Y'); ?> eXtension. All rights reserved.</p>
    </div>

</div>

</div>

<?php /* "Just what do you think you're doing Dave?" */ ?>

		<?php wp_footer(); ?>
</body>
</html>
