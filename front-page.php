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
            <?php the_category() ?>
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
      <img width="65" height="65" src="<?php echo get_the_post_thumbnail_url(null, 'thumbnail'); ?>" alt="">
    </li>
      <!--Закрываем функцию get_posts()-->
          <?php }
          } else {?>
          <p>Постов нет</p> <!--выводим сообщение, если постов нет-->
          <?php } wp_reset_postdata(); ?>
  </ul> <!--/.article-list-->
  <ul class="article-grid">
    <?php		
    global $post;
    //формируем запрос в базу данных
    $query = new WP_Query( [
      //получаем 7 постов
      'posts_per_page' => 7,
      'tag' => 'popular',
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
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/icon-comment.svg' ?>" alt="icon: comment" class="article-grid-comments-icon">
                    <span class="article-grid-comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                  </div>
                </div>
              </a>
            </li>
          <?php break;
          //закрываем первый пост, выводим второй
          case '2':?> 
            <li class="article-grid-item article-grid-item-2">
              <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="" class="article-grid-thumbnail">
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
                        <img src="<?php echo get_template_directory_uri() . '/assets/images/icon-comment.svg' ?>" alt="icon: comment" class="article-grid-comments-icon">
                        <span class="article-grid-comments-counter"><?php comments_number('0', '1', '%'); ?></span>
                      </div>
                      <div class="article-grid-likes">
                        <img src="<?php echo get_template_directory_uri() . '/assets/images/icon-heart.svg' ?>" alt="icon: heart" class="article-grid-likes-icon">
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
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="" class="article-grid-thumbnail">
                <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, '...'); ?></h4>
              </a>
            </li>
          <?php break;
          default:?>
            <li class="article-grid-item article-grid-item-default">
              <div class="article-grid-item-wrapper">
                <a href="<?php the_permalink()?>" class="article-grid-permalink">
                  <h4 class="article-grid-title"><?php echo mb_strimwidth(get_the_title(), 0, 23, '...'); ?></h4>
                  <p class="article-grid-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 80, '...'); ?></p>
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
  </ul>
</div> <!--/.container-->