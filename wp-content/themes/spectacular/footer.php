<?php
/*
 * @package WordPress
 * @subpackage Spectacular
 * @since Spectacular 1.0
 */
?>
  <section id="sub">
    <section>
    <h3 id="cat-heading">Browse by Topic</h3>
    <ul class="cat module600">
		 <?php wp_list_categories('title_li'); ?>
    </ul>
    <div id="quick-contact" class="module300">
<?php dynamic_sidebar( 'sub-content-widget-area' ); ?>
    </div>
    </section>
  </section>
  <footer>
    <section>
      <nav>
        <ul>
          <li><a href="<?php echo home_url( '/' ) ?>" rel="home" title="<?php bloginfo('name'); ?>">Home</a></li><?php wp_list_pages('title_li='); ?>
          <li class="rss"><a href="<?php bloginfo('rss2_url'); ?>">Subscribe to RSS 2.0 feed</a></li>
        </ul>
      </nav>
      <small>The<em> Spectacular Theme was created by <a href="http://rockatee.com/" title="Rockatee Design, Unique WordPress Themes">rockatee</a></em> for <a href="http://smashingmagazine.com/" title="The renowned online magazine for web designers and developers">Smashing Magazine</a> &amp; <a href="<?php echo esc_url( __('http://wordpress.org/', 'spectacular') ); ?>"
            title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'spectacular'); ?>" rel="generator">
          <?php printf( __('Proudly powered by %s.', 'spectacular'), 'WordPress' ); ?>
        </a></small>
    </section>
  </footer>
<?php wp_footer();?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-155321-40']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>