<?php
  get_header();
?>
    <article class="content">
      <?php
      if ( is_page( array( 4, 27, 23 ) ) ) {
        if( have_posts() ){
          while ( have_posts() ){
            the_post();
            get_template_part('content', 'archive' );
          }
        }
      }else{
        $args = array('post_type' => 'raeume');
        $query = new WP_Query($args);
        while ($query -> have_posts()) {
          $query -> the_post();
          get_template_part('content', 'archive');
        }
      }
      ?>
    </article>
<?php
  get_footer();
?>
