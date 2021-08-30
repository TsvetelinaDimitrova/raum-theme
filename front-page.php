<?php
  get_header();
?>
<div class="main">
  <article class="content-front"
    <?php
      if(have_posts()){
        while(have_posts()){
          the_post();
          the_content();
        }
      }
    ?>
  </article>
</div>

<?php
  get_footer();
?>
