<?php

if ( ! is_active_sidebar( 'post-entry-sidebar' ) ) {
	return;
}
?>

<div class="sidebar-under-post">
	<?php dynamic_sidebar( 'post-entry-sidebar' ); ?>
</div><!-- #secondary -->