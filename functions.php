<?php
//Подключает стили и скрипты на страницу
function enqueue_universal_style() {
  wp_enqueue_style('style', get_stylesheet_uri());
	wp_enqueue_style('universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style');
	wp_enqueue_style('swiper-slider', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', 'style');
	wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', null, time(), true);
	wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/js/scripts.js', 'swiper', time(), true);
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
 * Подключение первого сайдбара
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной сверху', 'universal-theme' ),
			'id'            => 'main-sidebar-top',
			'description'   => esc_html__( 'Добавьте виджеты сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Второй сайдбар на главной снизу', 'universal-theme' ),
			'id'            => 'main-sidebar-botto~m',
			'description'   => esc_html__( 'Добавьте виджеты сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</ul>
													<a href="#" class="recent-posts-read-more">Read more</a>
													</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2><ul class="recent-posts-list">',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Меню в подвале', 'universal-theme' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Добавьте меню сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="footer-menu-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Текст в подвале', 'universal-theme' ),
			'id'            => 'sidebar-footer-text',
			'description'   => esc_html__( 'Добавьте текст сюда', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );

/**
 * Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: Downloader_Widget
			'Полезные файлы',
      array( 
        'description' => 'Файлы для скачивания', 
        'classname' => 'widget-downloader', 
      )
    );

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
    $title = $instance['title'];
    $description = $instance['description'];
    $link = $instance['link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
    }
    if ( ! empty( $description ) ) {
			echo '<p class="widget-description">' . $description . '</p>';
    }
    if ( ! empty( $link ) ) {
			echo '<a target="_blank" class="widget-link" href="' . $link . '">
			<img class="widget-link-icon" src="'. get_template_directory_uri() . '/assets/images/icon-download.svg">
			Скачать</a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 * 
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
    $title = @ $instance['title'] ?: 'Полезные файлы';
    $description = @ $instance['description'] ?: 'Описание';
    $link = @ $instance['link'] ?: 'https://yandex.ru';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
    <p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>
    <p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка на файл:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
    $instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_downloader_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('downloader_widget_script', $theme_url .'/downloader_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_downloader_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.downloader_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Downloader_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'downloader_widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );

// Добавление нового виджета под соцсети
class Social_Widget extends WP_Widget {

	function __construct() {
		// Запускаем родительский класс
		parent::__construct(
			'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: social_widget
			'Социальные сети',
      array(
        'description' => 'Ссылки на соцсети',
        'classname' => 'social-widget',
      )
		);

		// стили скрипты виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_social_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
    $title = $instance['title'];
    $facebook = $instance['facebook'];
    $twitter = $instance['twitter'];
		$youtube = $instance['youtube'];
		$instagram = $instance['instagram'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    if ( ! empty( $facebook ) ) {
			echo '<ul class="social-links-wrapper"><li><a target="_blank" class="widget-social-link widget-social-link-facebook" href="' . $facebook . '">
      <img class="widget-social-link-icon" alt="Логотип Facebook" src="'. get_template_directory_uri() . '/assets/images/icon-facebook.svg">
      </a></li>';
    }
    if ( ! empty( $twitter ) ) {
			echo '<li><a target="_blank" class="widget-social-link widget-social-link-twitter" href="' . $twitter . '">
      <img class="widget-social-link-icon" alt="Логотип Twitter" src="'. get_template_directory_uri() . '/assets/images/icon-twitter.svg">
      </a></li>';
    }
    if ( ! empty( $youtube ) ) {
			echo '<li><a target="_blank" class="widget-social-link widget-social-link-youtube" href="' . $youtube . '">
      <img class="widget-social-link-icon" alt="Логотип Youtube" src="'. get_template_directory_uri() . '/assets/images/icon-youtube.svg">
      </a></li>';
		}
		if ( ! empty( $instagram ) ) {
			echo '<li><a target="_blank" class="widget-social-link widget-social-link-instagram" href="' . $instagram . '">
      <img class="widget-social-link-icon" alt="Логотип Instagram" src="'. get_template_directory_uri() . '/assets/images/icon-instagram.svg">
      </a></li></ul>';
    }
    echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Наши соцсети';
    $facebook = @ $instance['facebook'] ?: 'https://facebook.com';
    $twitter = @ $instance['twitter'] ?: 'https://twitter.com';
		$youtube = @ $instance['youtube'] ?: 'https://youtube.com';
		$instagram = @ $instance['instagram'] ?: 'https://instagram.com';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок виджета:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Ссылка на Facebook:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>">
    </p>
    <p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Ссылка на Twitter:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>">
    </p>
    <p>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Ссылка на Youtube:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Ссылка на Instagram:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
    $instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
		$instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_social_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_social_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('social_widget_script', $theme_url .'/social_widget_script.js' );
	}

	// стили виджета
	function add_social_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_social_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.social_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Foo_Widget

// регистрация Foo_Widget в WordPress
function register_social_widget() {
	register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );

class Recent_Posts_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_posts_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: Recent_Posts_Widget
			'Недавние записи',
      array( 
        'description' => 'Последние новости', 
        'classname' => 'recent-posts-widget', 
      )
    );

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_recent_posts_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_recent_posts_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
    $title = $instance['title'];
    $count = $instance['count'];

		echo $args['before_widget'];

		if (! empty ($count) ) {
			if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
			}

			global $post;
				$postslist = get_posts( array( 'posts_per_page' => $count, 'order'=> 'DESC', 'orderby' => 'date' ) );
				foreach ( $postslist as $post ){
					setup_postdata($post);
					?>
					<li class="recent-posts-item">
						<a href="<?php the_permalink(); ?>" class="recent-posts-permalink">
							<img src="<?php 
          if( has_post_thumbnail() ) {
            the_post_thumbnail_url( null, 'thumb');
          }
          else {
            echo get_template_directory_uri().'/assets/images/img-default.png" ';
          }
          ?>" alt="" class="recent-posts-thumbnail">
							<div class="recent-posts-description">
								<h4 class="recent-posts-title"><?php echo mb_strimwidth  (get_the_title(), 0, 37, '...'); ?></h4>
								<p class="recent-posts-time">
								<?php $time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
								echo "$time_diff назад";
								//> Опубликовано 5 лет назад.?>
							</div>
							</p>
						</a>
					</li>
					<?php
				}
				wp_reset_postdata();
		}

		

		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
    $title = @ $instance['title'] ?: 'Недавно опубликованы';
    $count = @ $instance['count'] ?: '7';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
    <p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_recent_posts_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_recent_posts_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('recent_posts_widget_script', $theme_url .'/recent_posts_widget_script.js' );
	}

	// стили виджета
	function add_recent_posts_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_recent_posts_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.recent_posts_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Recent_Posts_Widget

// регистрация Recent_Posts_Widget в WordPress
function register_recent_posts_widget() {
	register_widget( 'recent_posts_widget' );
}
add_action( 'widgets_init', 'register_recent_posts_widget' );


//Меняем настройки виджета "облако меток"
add_filter( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args');
function edit_widget_tag_cloud_args($args){
	$args['unit'] = 'px';
	$args['smallest'] = '14';
	$args['largest'] = '14';
	$args['number'] = '11';
	$args['orderby'] = 'count';
	return $args;
}

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
