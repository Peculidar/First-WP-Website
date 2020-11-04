<?php get_header('post');?>

<main class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			//мы находим шаблон для вывода поста в папке template_parts
			get_template_part( 'template-parts/content', get_post_type() );

			// Если комментарии к записи открыты, выводим комментарии
      if ( comments_open() || get_comments_number() ) :
        //находим файл comment.php и выводим его
				comments_template();
			endif;

		endwhile; // конец цикла
		?>
</main>



<?php get_footer(); ?>