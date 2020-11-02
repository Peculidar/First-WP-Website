<?php get_header();?>
<main class="front-page-header">
  <div class="container">
    <div class="hero">
      <div class="left-col">

      <!--Открываем функцию get_posts()-->
      <?php
      global $post;
      $myposts = get_posts([ 
        'numberposts'           => 1,
        'category_name'         => 'javascript, css, html, web-design'
        ]);

      // проверяем есть ли посты?
      if( $myposts ){
        foreach( $myposts as $post ){ 
          setup_postdata( $post );?>

        <!-- Выводим записи -->
        <img src="<?php the_post_thumbnail_url(); ?>" alt="" class="post-thumbnail">
        <?php $author_id = get_the_author_meta( 'ID' ); ?>
        <a href="<?php echo get_author_posts_url( $author_id ); ?>" class="author">
          <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="author-avatar">
            <div class="author-bio">
              <span class="author-name"><?php the_author();?></span>
              <span class="author-rank">Должность</span>
            </div> <!--/.author-bio-->
        </a> <!--/.author-->
        <div class="post-text">
        <?php the_category();?>
          <h2 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...'); ?></h2>
          <a href="<?php echo get_the_permalink();?>" class="read-more">Читать далее</a>
        </div> <!--/.post-text-->

        <!--Закрываем функцию get_posts()-->
        <?php } 
        } else {?>
        <p>Постов нет</p> <!--выводим сообщение, если постов нет-->
        <?php } wp_reset_postdata(); ?>

      </div> <!--/.left-col-->
      <div class="right-col">
        <h3 class="recommendations">Рекомендуем</h3>
        <ul class="post-list">

        <!--Открываем функцию get_posts()-->
        <?php
        global $post;
        $myposts = get_posts([ 
          'numberposts'         => 5,
          'offset'              => 1,
          'category_name'         => 'javascript, css, html, web-design'
          ]);

          // проверяем есть ли посты?
          if( $myposts ){
            foreach( $myposts as $post ){
              setup_postdata( $post );?>

          <!-- Выводим записи -->
          <li class="post">
            <?php
            foreach (get_the_category() as $category) {
              printf(
                '<a href="%s" class="post-categories %s">%s</a>', //задаем ссылку с переменными
                esc_url( get_category_link( $category ) ), //в первую переменную вставляем ссылку на категорию
                esc_html($category -> slug), //во вторую переменную подставляем id метки
                esc_html($category -> name)
              );
            }
            ?>
            <a class="post-permalink" href="<?php echo get_the_permalink() ?>">
              <h4 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...'); ?></h4>
            </a>
          </li>

          <!--Закрываем функцию get_posts()-->
          <?php }
          } else {?>
          <p>Постов нет</p> <!--выводим сообщение, если постов нет-->
          <?php } wp_reset_postdata(); ?>
        </ul> <!--/.post-list-->
      </div> <!--/.right-col-->
    </div> <!--/.hero-->
  </div> <!--/.container-->
</main>
<div class="container">
  <ul class="article-list">

    <!--Открываем функцию get_posts()-->
    <?php
    global $post;
    $myposts = get_posts([ 
      'numberposts'        => 4,
      'category_name'         => 'articles'
      ]);

    // проверяем есть ли посты?
    if( $myposts ){
      foreach( $myposts as $post ){
        setup_postdata( $post );?>

    <!-- Выводим записи -->
    <li class="article-item">
      <a class="article-permalink" href="<?php echo get_the_permalink() ?>">
        <h4 class="article-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, '...'); ?></h4>
      </a>
      <img width="65" height="65" src="
      <?php 
          if( has_post_thumbnail() ) {
            the_post_thumbnail_url(null, 'thumb');
          }
          else {
            echo get_template_directory_uri().'/assets/images/img-default.png" ';
          }
          ?>" alt="">
    </li>
      <!--Закрываем функцию get_posts()-->
          <?php }
          } else {?>
          <p>Постов нет</p> <!--выводим сообщение, если постов нет-->
          <?php } wp_reset_postdata(); ?>
  </ul> <!--/.article-list-->
  <div class="main-grid">
    <ul class="article-grid">
      <?php		
      global $post;
      //формируем запрос в базу данных
      $query = new WP_Query( [
        //получаем 7 постов
        'posts_per_page' => 7,
        'tag' => 'popular',
        'category__not_in' => 26
      ] );
      //создаем переменную-счетчик постов
      $cnt = 0;
      //пока есть посты, мы их выводим
      if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
          $query->the_post();
          // увеличиваем счетчик постов
          $cnt++;
          switch ($cnt) {
            //выводим первый пост
            case '1':?> 
              <li class="article-grid-item article-grid-item-1">
                <a href="<?php the_permalink()?>" class="article-grid-permalink">
                  <span class="article-grid-category">
                    <?php
                    //перебирает массив
                      $category = get_the_category(); 
                      echo $category[0]->name;
                    ?>
                  </span>
                  <h4 class="article-grid-title"><?php the_title(); ?></h4>
                  <p class="article-grid-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 120, '...'); ?></p>
                  <div class="article-grid-info">
                    <div class="article-grid-author">
                      <?php $author_id = get_the_author_meta( 'ID' ); ?>
                      <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="article-grid-author-avatar">
                      <span class="article-grid-author-name">
                        <strong><?php the_author(); ?></strong>: <?php the_author_meta('description'); ?>
                      </span>
                    </div>
                    <div class="article-grid-comments">
                      <svg class="article-grid-comments-icon" fill="#BCBFC2" width="15" height="15">
                        <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#icon-comment"></use>
                      </svg>
                      <span class="article-grid-comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                    </div>
                  </div>
                </a>
              </li>
            <?php break;
            //закрываем первый пост, выводим второй
            case '2':?> 
              <li class="article-grid-item article-grid-item-2">
                <img src="
                <?php 
                  if( has_post_thumbnail() ) {
                    the_post_thumbnail_url();
                  }
                  else {
                    echo get_template_directory_uri().'/assets/images/img-default.png" ';
                  }
                ?>" alt="" class="article-grid-thumbnail">
                <a href="<?php the_permalink()?>" class="article-grid-permalink">
                  <span class="article-grid-tag">
                    <?php $posttags = get_the_tags();
                      if ($posttags) {
                        echo $posttags[0]->name . ' ';
                    } ?>
                  </span>
                  <span class="article-grid-category">
                    <?php
                    //перебирает массив
                    $category = get_the_category(); 
                    echo $category[0]->name;
                    ?>
                  </span>
                  <h4 class="article-grid-title"><?php the_title(); ?></h4>
                  <div class="article-grid-info">
                    <div class="article-grid-author">
                      <?php $author_id = get_the_author_meta( 'ID' ); ?>
                      <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="article-grid-author-avatar">
                      <div class="article-grid-author-info-wrapper">
                        <span class="article-grid-author-name"><?php the_author(); ?></span>
                        <span class="article-grid-date"><?php echo the_time('j F')?></span>
                        <div class="article-grid-comments">
                          <svg class="article-grid-comments-icon" fill="#fff" width="15" height="15">
                            <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#icon-comment"></use>
                          </svg>
                          <span class="article-grid-comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                        </div>
                        <div class="article-grid-likes">
                          <svg class="article-grid-heart-icon" fill="#fff" width="15" height="15">
                            <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#icon-heart"></use>
                          </svg>
                          <span class="article-grid-likes-counter"><?php comments_number('0', '1', '%'); ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </li>
            <?php break;
            //закрываем второй пост, выводим третий
            case '3':?>
              <li class="article-grid-item article-grid-item-3">
                <a href="<?php the_permalink()?>" class="article-grid-permalink">
                  <img src="
                  <?php 
                    if( has_post_thumbnail() ) {
                      the_post_thumbnail_url();
                    }
                    else {
                      echo get_template_directory_uri().'/assets/images/img-default.png" ';
                    }
                  ?>" alt="" class="article-grid-thumbnail">
                  <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, '...'); ?></h4>
                </a>
              </li>
            <?php break;
            default:?>
              <li class="article-grid-item article-grid-item-default">
                <div class="article-grid-item-wrapper">
                  <a href="<?php the_permalink()?>" class="article-grid-permalink">
                    <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 23, '...'); ?></h4>
                    <p class="article-grid-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 70, '...'); ?></p>
                    <p class="article-grid-date"><?php echo the_time('j F')?></p>
                  </a>
                </div>
              </li>
            <?php break;
          }
          ?>
          <!-- Вывода постов, функции цикла: the_title() и т.д. -->
          <?php 
        }
      } else {
      // Постов не найдено
      }

      wp_reset_postdata(); // Сбрасываем $post
      ?>
    </ul> <!--/.article-grid-->
    <!--подключаем сайдбар-->
    <?php echo get_sidebar('home-top'); ?>
  </div> <!--/.main-grid-->
</div> <!--/.container-->

<?php 
global $post;

// запрос
$query = new WP_Query( [
  'posts_per_page' => 1,
  'category_name' => 'investigation'
] );

if ( $query->have_posts() ) {
  while ( $query->have_posts() ) {
    $query->the_post();
    ?>
    <section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.35), rgba(64, 48, 61, 0.35)), url(
      <?php 
          if( has_post_thumbnail() ) {
            the_post_thumbnail_url();
          }
          else {
            echo get_template_directory_uri().'/assets/images/img-default.png" ';
          }
          ?>
          ) no-repeat center center;">
      <div class="container">
        <h2 class="investigation-title"><?php the_title(); ?></h2>
        <a href="<?php echo get_the_permalink();?>" class="investigation-more">Читать статью</a>
      </div> <!--/.container-->
    </section> <!--/.investigation-->
  <?php
  }
} else {
  //no posts
}

wp_reset_postdata(); 
?>


<div class="news-and-sidebar-wrapper container">
  <section class="news">
    <ul class="news-list">
    <?php
    global $post;
    $myposts = get_posts([ 
      'numberposts'         => 6,
      'category_name'         => 'news, opinion, hot, recommended'
      ]);

    // проверяем есть ли посты?
    if( $myposts ){
      foreach( $myposts as $post ){
        setup_postdata( $post );?>

    <!-- Выводим записи -->

    <li class="news-post">
      <a href="<?php echo get_the_permalink() ?>" class="news-post-permalink">
        <img src="
        <?php 
          if( has_post_thumbnail() ) {
            the_post_thumbnail_url();
          }
          else {
            echo get_template_directory_uri().'/assets/images/img-default.png" ';
          }
          ?>" alt="" class="news-post-thumbnail">
        <div class="news-post-preview">
          <?php
            foreach (get_the_category() as $category) {
              printf(
                '<p class="news-post-category %s">%s</p>', //задаем ссылку с переменными
                esc_html($category -> slug), //во вторую переменную подставляем id метки
                esc_html($category -> name) //в третью переменную подставляем имя категории
              );
            }
          ?>
          <h4 class="news-post-title"><?php echo mb_strimwidth  (get_the_title(), 0, 65, '...'); ?></h4>
          <p class="news-post-excerpt"><?php echo mb_strimwidth (get_the_excerpt(), 0, 165, '...'); ?></p>
          <div class="news-post-info">
            <p class="news-post-date"><?php echo the_time('j F')?></p>
              <div class="news-post-comments">
                <svg class="news-post-comments-icon" fill="#BCBFC2" width="15" height="15">
                  <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#icon-comment"></use>
                </svg>
                <span class="news-post-comments-counter"><?php comments_number('0', '1', '%'); ?></span>
              </div>
              <div class="news-post-likes">
                <svg class="news-post-likes-icon" fill="#BCBFC2" width="15" height="15">
                  <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#icon-heart"></use>
                </svg>
                <span class="news-post-likes-counter"><?php comments_number('0', '1', '%'); ?></span>
              </div> <!-- /.news-post-likes -->
            </p> <!-- /.news-post-date -->
          </div> <!-- /.news-post-info -->
        </div> <!-- /.news-post-preview -->
      </a> <!--news-post-permalink-->     
    </li> <!-- /.news-post -->
      <!--Закрываем функцию get_posts()-->
      <?php }
      } else {?>
        <p>Постов нет</p> <!--выводим сообщение, если постов нет-->
      <?php } wp_reset_postdata(); ?>
    </ul>
  </section> <!--/.news-and-sidebar-wrapper-->
  <?php echo get_sidebar('home-bottom'); ?>
</div> <!-- /.news-and-sidebar-wrapper -->

<div class="special">
  <div class="container">
    <div class="special-grid">
      <?php 
      global $post;

      // запрос
      $query = new WP_Query( [
        'posts_per_page' => 1,
        'category_name' => 'photo-report'
      ] );

      if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
          $query->the_post();
        ?>
        <div class="special-photo-report">
          <!-- Slider main container -->
          <div class="swiper-container photo-report-slider">
              <!-- Additional required wrapper -->
              <div class="swiper-wrapper">
                <?php 
                  $images = get_attached_media( 'image' );
                  foreach ($images as $image ) {
                    echo '<div class="swiper-slide"><img src="';
                    print_r($image -> guid);
                    echo '"></div>';
                  }
                ?>
              </div>
              <!-- If we need pagination -->
              <div class="swiper-pagination"></div>
          </div>
          <div class="special-author">
            <?php
            foreach (get_the_category() as $category) {
              printf(
                '<a href="%s" class="special-category-name %s">%s</a>', //задаем ссылку с переменными
                esc_url( get_category_link( $category ) ), //в первую переменную вставляем ссылку на категорию
                esc_html($category -> slug), //во вторую переменную подставляем id метки
                esc_html($category -> name)
              );
            }
            ?>
            <?php $author_id = get_the_author_meta( 'ID' ); ?>
            <a href="<?php echo get_author_posts_url( $author_id ); ?>" class="special-author-info">
              <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="special-author-avatar">
                <div class="special-author-bio">
                  <p class="special-author-name"><?php the_author();?></p>
                  <p class="special-author-rank">Должность</p>
                </div> <!--/.author-bio-->
            </a> <!--/.author-->
            <h3 class="special-report-title"><?php the_title()?></h3>
            <a href="<?php echo get_the_permalink(); ?>" class="button special-button-photo">
              <svg class="icon-photo-report" fill="#fff" width="19px" height="15px">
                <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#icon-photo-report"></use>
              </svg>
              Смотреть фото
              <span class="special-button-photo-counter"><?php echo count($images)?></span>
            </a> <!-- /.special-button-photo -->
          </div> <!-- /.special-author -->
        </div> <!-- /.special-photo-report -->

      <?php } 
        } else {?>
        <p>Постов нет</p> <!--выводим сообщение, если постов нет-->
      <?php } wp_reset_postdata(); ?>
  
        <div class="special-other">
          <div class="special-career">
            <?php
              global $post;
              $myposts = get_posts([ 
                'numberposts'           => 1,
                'category_name'         => 'career'
                ]);

              // проверяем есть ли посты?
              if( $myposts ){
                foreach( $myposts as $post ){ 
                  setup_postdata( $post );?>

                <!-- Выводим записи -->
                <a href="<?php echo get_the_permalink();?>" class="special-career-permalink">
                              <?php
                    foreach (get_the_category() as $category) {
                      printf(
                        '<p class="special-career-category %s">%s</p>',
                        esc_html($category -> slug), //во вторую переменную подставляем id метки
                        esc_html($category -> name)
                      );
                    }
                    ?>
                  <h3 class="special-career-title"><?php echo mb_strimwidth(get_the_title(), 0, 60, '...'); ?></h3>
                  <p class="special-career-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 85, '...'); ?></p>
                  <p class="special-career-read-more read-more">Читать далее</p>
                </a>

                <!--Закрываем функцию get_posts()-->
                <?php } 
                } else {?>
                <p>Постов нет</p> <!--выводим сообщение, если постов нет-->
                <?php } wp_reset_postdata(); ?>
          </div> <!-- /.special-career -->
          <ul class="special-random">
            <?php
              global $post;
              $myposts = get_posts([ 
                'numberposts'           => 2,
                'category_name'         => 'random'
                ]);

              // проверяем есть ли посты?
              if( $myposts ){
                foreach( $myposts as $post ){ 
                  setup_postdata( $post );?>

                <!-- Выводим записи -->
                <li class="special-random-item">
                  <a href="<?php echo get_the_permalink();?>" class="special-random-permalink">
                    <h3 class="special-random-title"><?php echo mb_strimwidth(get_the_title(), 0, 20, '...'); ?></h3>
                    <p class="special-random-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 40, '...'); ?></p>
                    <p class="special-random-date"><?php echo the_time('j F')?></p>
                  </a>
                </li>
                <!--Закрываем функцию get_posts()-->
                <?php } 
                } else {?>
                <p>Постов нет</p> <!--выводим сообщение, если постов нет-->
                <?php } wp_reset_postdata(); ?>
                </ul> <!-- /.special-random -->
        </div> <!-- /.other -->
    </div> <!-- /.special-grid -->
  </div> <!-- /.container -->
</div> <!-- /.special -->
<?php get_footer(); ?>


