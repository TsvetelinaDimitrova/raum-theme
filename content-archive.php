<div class="container">
    <div class="media">
      <img id="bild" src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="image">
    </div>
    <div class="media-body">
      <h3 class="title"><?php the_title(); ?></h3>
        <div class="intro">
          <?php
          the_excerpt();
          ?>
        </div>
        <a class="more-link" href="<?php the_permalink(); ?>">Mehr...</a>
    </div>
</div>
