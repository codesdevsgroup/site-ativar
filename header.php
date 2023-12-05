<!doctype html>
<html>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

  <link href="//www.google-analytics.com" rel="dns-prefetch">
  <link href="<?php echo get_template_directory_uri(); ?>/img/icons/favicon.ico" rel="shortcut icon">
  <link href="<?php echo get_template_directory_uri(); ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php bloginfo('description'); ?>">

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="top-menu">
  <nav class="navbar navbar-expand-md navbar-light">
    <div class="container-fluid container-sm">
      <a class="navbar-brand animate__bounce" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo.png" alt="Quantic 3D" width="230" height="auto">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>    
      <div class="collapse navbar-collapse" id="main-menu">
        <?php
          wp_nav_menu(array(
          'theme_location' => 'main-menu',
          'container' => false,
          'menu_class' => '',
          'fallback_cb' => '__return_false',
          'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto %2$s">%3$s</ul>',
          'depth' => 2,
          'walker' => new bootstrap_5_wp_nav_menu_walker()
          ));
          
          /* if (is_user_logged_in()) {
            echo '<ul class="navbar-nav">';
            echo '<li class="nav-item"><a class="nav-link text-primary" href="' . home_url('./index.php/produtosadmin/') . '">ADMPro</a></li>';
            echo '</ul>';
          } */
        ?>
      </div>
    </div>
  </nav>
</div>