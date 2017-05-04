<?php get_header(); ?>

<div id="primary" class="content-area">
  <div id="content" class="site-content" role="main">

    <div id="cse" class="search-page">


      <h2 class="search-title">Search results</h2>



      <div class="search-list-item">
      <script>
      (function() {
        var cx = '002594610894210374936:hggphannnzi';
        var gcse = document.createElement('script');
        gcse.type = 'text/javascript';
        gcse.async = true;
        gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
            '//cse.google.com/cse.js?cx=' + cx;
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(gcse, s);
      })();
      </script>
      <gcse:search queryParameterName="s" enableAutoComplete="true"></gcse:search>

      </div>



    </div>
  </div><!-- #content -->
</div><!-- #primary -->






<?php get_footer(); ?>
