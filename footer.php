  <footer class="footer">
    <div class="container">
      <div class="footer-menu-bar">
        <?php dynamic_sidebar( 'sidebar-footer' ); ?>
      </div><!-- /.footer-menu-bar -->
      <div class="footer-info">
        <?php
          if (has_custom_logo()) {
            echo '<div class="logo logo-footer">' . get_custom_logo() . '</div>';
          } else {
            echo '<span class="logo-name logo-name-footer">' . get_bloginfo('name') . '</span>';
          }

          wp_nav_menu( [
            'theme_location'  => 'footer_menu',
            // 'container'             => 'nav', 
            'container_class'             => 'footer-nav-wrapper', 
            'menu_class'      => 'footer-nav',
            'echo'            => true,
            ] );

          $instance = array(
            'facebook' => 'https://fb.com',
            'twitter' => 'https://twitter.com',
            'youtube' => 'https://youtube.com',
            'instagram' => 'https://instagram.com',
            'title' => ''
          );
          $arggs = array(
            'before_widget' => '<div class="footer-social">',
            'after_widget' => '</div>'
          );
          the_widget('Social_Widget', $instance, $args)?>
      </div> <!-- /.footer-info -->
      <div class="footer-text-wrapper">
        <?php dynamic_sidebar( 'sidebar-footer-text' );?>
        <p class="footer-copyright"><?php echo the_time('Y') . ' © ' . get_bloginfo('name')?></p>
      </div>
    </div> <!-- /.container -->
  </footer>
  
  <?php wp_footer(); ?>
  </body>
</html>