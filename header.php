<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php bloginfo('name'); ?><?php wp_title( '|', true, 'left' ); ?></title>
<!-- <script src = "http://code.jquery.com/jquery-1.11.2.min.js" type = "text / javascript"> </script>-->
<script>
</script>

<?php wp_head();  ?>

</head>

<body>
  <div align="center">
    <div id="inner">
      <header>
        <a href="<?php echo home_url( '/' ); ?>" title="<?php echo bloginfo('name'); ?>" rel="home">
        <h1><?php bloginfo( 'name' ); ?></h1>
        </a>
      </header>
    </div>
      <div class="navigation">
      	<nav>
      		<?php
      			wp_nav_menu(
      				array(
      				'container_class' => 'primary-menu',
      				'theme_location' => 'primary',
      				)
      			);
      		?>
      	</nav>
      </div>
