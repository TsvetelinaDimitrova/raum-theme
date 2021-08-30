<?php
if (have_posts()){
    the_post();
    rewind_posts();
}
?>
  <?php
  if ('raueme' == get_post_type()){
    include('single-raeume.php');
  }
  ?>
