<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
<header class="header-post">
  <div class="container">
    <div class="header-post-wrapper">
      <?php 
        if(has_custom_logo()) {
          the_custom_logo();
        } else {
          echo 'Universal';
        };
      ?>
      <?php
        wp_nav_menu( [
          'theme_location'  => 'header-post_menu',
          'nav'             => 'header-post-nav', 
          'menu_class'      => 'header-post-menu',
          'echo'            => true,
          ] );
      ?>
        <?php echo get_search_form(); ?>
        <a href="" class="header-post-menu-toggle">
          <span class=""></span>
          <span class=""></span>
          <span class=""></span>
        </a>
    </div>
  </div>
</header>