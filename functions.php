<?php
//Подключает стили и скрипты на страницу
function enqueue_universal_style() {
  wp_enqueue_style('style', get_stylesheet_uri());
  wp_enqueue_style('universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style');
  wp_enqueue_style( 'Roboto-Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
}
add_action('wp_enqueue_scripts', 'enqueue_universal_style');

//Расширяет возможности
if ( ! function_exists('universal_theme_setup')):
  function universal_theme_setup() {
    //Добавляет тег - title
    add_theme_support('title-tag');

    add_theme_support('post-thumbnails', array( 'post' ) );

    //Добавляет пользовательский логотип
    add_theme_support('custom-logo', [
      'width'                => 163,
      'flex-height'          => true,
      'header-text'          => 'Universal',
      'unlink-homepage-logo' => false, 
    ]);

    //Регистрация меню
    register_nav_menus( [
      'header_menu' => 'Меню в шапке',
      'footer_menu' => 'Меню в подвале'
      ] );
  }
endif;
add_action('after_setup_theme', 'universal_theme_setup');

/**
 * Подключение сайдбара
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной', 'universal-theme' ),
			'id'            => 'main-sidebar',
			'description'   => esc_html__( 'Добавьте виджеты сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );

## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}
