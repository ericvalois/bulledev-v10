<nav class="main-nav">
    
    <span id="menu">
    	<?php if( !is_home() ): ?>
        	<a href='<?php echo esc_url( home_url( '/' ) ); ?>'> <span class="arrow">←</span> <?php _e("Home","atom"); ?></a>
	    <?php endif; ?>

	    <?php
	    	$menuParameters = array(
			'container'       => false,
			'echo'            => false,
			'items_wrap'      => '%3$s',
			'depth'           => 0,
			'theme_location' => 'header',
			'menu' => 'header',
			);

			echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
		?>


		<a href="<?php echo esc_url( home_url( '/' ) ); ?>?s=" class="icon-search2 icon  "> <?php _e("Search","atom"); ?></a>
    </span>


	<span class="icon-bars icon item" id="icon-bars"></span>

    <a class="cta" href="https://atom.us1.list-manage.com/subscribe?u=7264b91f91da7aa36c6142ac0&id=8bbcc78d1e"><span class="icon-envelope icon"></span> <?php _e("Subscribe","atom"); ?></a>


</nav>