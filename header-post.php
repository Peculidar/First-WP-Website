<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
<header class="header header-light">
  <div class="container">
    <div class="header-wrapper header-wrapper-light">
      <?php 
        if(has_custom_logo()) {
          echo '<div class="logo">' . get_custom_logo() .  
          '<span class="logo-name logo-name-light">' . get_bloginfo('name') . '</span></div>';
        } else {
          echo '<span class="logo-name-dark">' . get_bloginfo('name') . '</span>';
        };
      ?>
      <?php
        wp_nav_menu( [
          'theme_location'  => 'header_menu',
          'nav'             => 'header-nav', 
          'menu_class'      => 'header-menu',
          'echo'            => true,
          ] );
      ?>
        <?php echo get_search_form(); ?>
        <a href="" class="header-menu-toggle header-menu-toggle-light">
          <span class=""></span>
          <span class=""></span>
          <span class=""></span>
        </a>
    </div>
  </div>
</header>