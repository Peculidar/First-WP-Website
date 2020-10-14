<?php get_header();?>
<main class="front-page-header">
  <div class="container">
    <div class="hero">
      <div class="left-col">

      <!--Открываем функцию get_posts()-->
      <?php
      global $post;
      $myposts = get_posts([ 
        'numberposts'        => 1,
        'category-name'      => 'javascript'
        ]);

      // проверяем есть ли посты?
      if( $myposts ){
        foreach( $myposts as $post ){ 
          setup_postdata( $post );?>

        <!-- Выводим записи -->
        <img src="<?php the_post_thumbnail_url()?>" alt="" class="post-thumbnail">
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
          <h2 class="post-title"><?php the_title()?></h2>
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
            'numberposts'        => 5,
            'offset' => 1]);

            // проверяем есть ли посты?
            if( $myposts ){
              foreach( $myposts as $post ){
              setup_postdata( $post );?>

            <!-- Выводим записи -->
            <li class="post">
              <?php the_category() ?>
              <a class="post-title" href="<?php echo get_the_permalink() ?>"><?php the_title(); ?></a>
            </li>
          </ul>

          <!--Закрываем функцию get_posts()-->
          <?php }
          } else {?>
          <p>Постов нет</p> <!--выводим сообщение, если постов нет-->
          <?php } wp_reset_postdata(); ?>
      </div> <!--/.right-col-->
    </div> <!--/.hero-->
  </div> <!--/.container-->
</main>
