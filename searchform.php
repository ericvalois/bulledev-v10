<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" value="<?php echo get_search_query(); ?>" name="s" id="s"  placeholder="Rechercher">
	<button type="submit"><?php _e("Search","atom"); ?></button>
</form>