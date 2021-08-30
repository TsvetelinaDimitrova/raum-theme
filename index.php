<?php
get_header();
?>
<div id="contentArea">
  <div id="mainContent">
    <?php
    if ( is_page( array( 4, 27, 23 ) ) ) {
      if (have_posts()){
        while ( have_posts() ) {
          the_post(); ?>
          <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a></h2>
          <?php the_content();
        }
      }
      the_posts_pagination();
    } else {
        $args = array('post_type' => 'raeume');
        $query = new WP_Query($args);
        while ($query -> have_posts()) {
          $query -> the_post();
          get_template_part('content', 'archive');
       }
    } ?>
        </div>
</div>
<?php
get_footer();
?>
