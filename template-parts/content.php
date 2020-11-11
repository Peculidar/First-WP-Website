<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <!-- шапака поста -->
  <header class="entry-header <?php echo get_post_type();?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url(
    <?php 
      if( has_post_thumbnail() ) {
        the_post_thumbnail_url();
      }
      else {
        echo get_template_directory_uri().'/assets/images/img-default.png" ';
        }
      ?>); background-size: cover;">
  <div class="container">
    <div class="post-header-wrapper">
      <div class="post-header-nav">
        <?php
          foreach (get_the_category() as $category) {
            printf(
              '<a href="%s" class="content-category-name %s">%s</a>', //задаем ссылку с переменными
              esc_url( get_category_link( $category ) ), //в первую переменную вставляем ссылку на категорию
              esc_html($category -> slug), //во вторую переменную подставляем id метки
              esc_html($category -> name)
            );
          }
        ?>
        <a href="<?php echo get_home_url();?>" class="post-home-link">
          <svg class="post-header-comments-icon" fill="#ffffff" width="18" height="17">
            <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#icon-home"></use>
          </svg>
          На главную
        </a>
        <?php
        //выводим ссылки на предыдущий и следующий посты
        the_post_navigation(
          array(
            'prev_text' => '<span class="post-nav-prev">
              <svg width="15" height="7" class="icon prev-icon" fill="white">
                <use xlink:href="'. get_template_directory_uri().'/assets/images/sprite.svg#icon-left-arrow"></use>
              </svg>
            ' . esc_html__( 'Назад', 'universal-theme' ) . '</span>',
            'next_text' => '<span class="post-nav-next">
            ' . esc_html__( 'Вперед', 'universal-example' ) . '</span>
            <svg width="15" height="7" class="icon prev-icon" fill="white">
                <use xlink:href="'. get_template_directory_uri().'/assets/images/sprite.svg#icon-right-arrow"></use>
              </svg>',
          )
        );
        ?>
      </div> <!--/.post-header-nav-->
      <div class="post-header-title-wrapper">
        <?php
        // проверяем, точно ли мы на странице поста?
        if ( is_singular() ) :
          the_title( '<h1 class="post-entry-title">', '</h1>' );
        else :
          the_title( '<h2 class="post-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '<a></h2>' );
        endif; 
        ?>
        <a href="#" class="post-header-bookmark-link">
          <svg class="post-header-bookmark-icon" fill="#fff" width="30" height="30" opacity="0.4">
            <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#icon-bookmark"></use>
          </svg>
        </a>
      </div> <!-- /.post-header-title-wrapper -->
      <p class="post-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 240, '...'); ?></p>
      <div class="post-header-info">
        <p class="post-header-date"><?php echo the_time('j F , G:i')?></p>
        <div class="post-header-likes">
          <svg class="post-header-likes-icon" fill="#BCBFC2" width="15" height="15">
            <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#icon-heart"></use>
          </svg>
          <span class="post-header-likes-counter"><?php comments_number('0', '1', '%'); ?></span>
        </div> <!-- /.post-heeader-likes -->
        <div class="post-header-comments">
          <svg class="post-header-comments-icon" fill="#BCBFC2" width="15" height="15">
            <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#icon-comment"></use>
          </svg>
          <span class="post-header-comments-counter"><?php comments_number('0', '1', '%'); ?></span>
        </div> <!--/.post-header-comments-->
      </div> <!--/.post-heeader-info-->
      <div class="post-header-author">
        <div class="post-header-author-info">
          <?php $author_id = get_the_author_meta( 'ID' ); ?>
          <img src="<?php echo get_avatar_url($author_id); ?>" alt="" class="post-header-author-avatar">
            <span class="post-header-author-name"><?php the_author();?></span>
            <span class="post-header-author-rank">Должность</span>
            <span class="post-header-post-counter">
              <?php echo plural_form(
                count_user_posts($author_id),
                /* варианты написания для количества 1, 2 и 5 */
                array('статья','статьи','статей')
              );
              ?>
            </span>
        </div> <!--post-header-author-info-->
        <a href="<?php echo get_author_posts_url( $author_id ); ?>" class="post-header-author-link">Страница автора</a>
      </div> <!--/ post-header-author -->
    </div> <!--post-header-wrapper-->
  </div> <!--/container-->
	</header><!-- .entry-header -->
  <div class="post-entry-wrapper container">
    <div class="post-entry-content">
      <?php
      the_content(
        sprintf(
          wp_kses(
            /* translators: %s: Name of current post. Only visible to screen readers */
            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal-theme' ),
            array(
              'span' => array(
                'class' => array(),
              ),
            )
          ),
          wp_kses_post( get_the_title() )
        )
      );

      wp_link_pages(
        array(
          'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'universal-theme' ),
          'after'  => '</div>',
        )
      );
      ?>
    </div><!-- .entry-content -->
  <footer class="entry-footer">
		<?php $tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'universal-theme' ) );
		if ( $tags_list ) {
		/* translators: 1: list of tags. */
		printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal-example' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
    // Поделитесь в соц сетях
    meks_ess_share();
    
    ?>
    
	</footer><!-- .entry-footer -->
  </div>

</article>