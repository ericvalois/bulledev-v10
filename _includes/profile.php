<?php if( is_home() ): ?>
	<div class="profile">
	        <header id="header">
	            <a href='<?php echo esc_url( home_url( '/' ) ); ?>'>
	                <img id="avatar" class="2x" src="<?php echo get_bloginfo("template_directory"); ?>/assets/images/logo.png" width="80" height="80" />
	            </a>
	            <h1><?php bloginfo('name'); ?></h1>
	            <h2><?php bloginfo('description'); ?></h2>
	        </header>
	</div>
<?php elseif( is_archive() ): ?>
		<div class="profile">
		        <header id="header">
		        	<a href='<?php echo esc_url( home_url( '/' ) ); ?>'>
		                <img id="avatar" class="2x" src="<?php echo get_bloginfo("template_directory"); ?>/assets/images/logo.png" width="80" height="80" />
		            </a>
		            <h1>Archive</h1>
		            <h2>
		            	<?php if ( is_day() ) : ?>
							<?php printf( __( 'Daily archive: <span>%s</span>', 'atom' ), get_the_date() ); ?>
						<?php elseif ( is_month() ) : ?>
							<?php printf( __( 'Monthly Archives: <span>%s</span>', 'atom' ), get_the_date('F Y') ); ?>
						<?php elseif ( is_year() ) : ?>
							<?php printf( __( 'Annual Archives: <span>%s</span>', 'atom' ), get_the_date('Y') ); ?>
						<?php elseif ( is_post_type_archive("question") ) : ?>
							<?php printf( __( 'Archive questions: <span>%s</span>', 'atom' ), get_the_date('Y') ); ?>
						<?php elseif ( is_category() ) : ?>
							<?php echo sprintf( esc_html__( 'Category: %s', 'atom' ), single_cat_title( '', false ) ); ?>
						<?php elseif ( is_tag() ) : ?>
							<?php echo sprintf( esc_html__( 'Subject: %s', 'atom' ), single_tag_title( '', false ) ); ?>
						<?php else : ?>
							<?php _e("Blog archive", 'atom'); ?>
						<?php endif; ?>
		            </h2>
		        </header>
		</div>
<?php elseif( is_search() ): ?>
	<div class="profile">
	    <header id="header">
	    	<a href='<?php echo esc_url( home_url( '/' ) ); ?>'>
	            <img id="avatar" class="2x" src="<?php echo get_bloginfo("template_directory"); ?>/assets/images/logo.png" width="80" height="80" />
	        </a>
	        <h1><?php _e("Search","atom"); ?></h1>
	    	<h2>
	    		<?php if( $_GET['s'] != "" ): ?>
	        		<?php printf( __( 'Search for: %s', 'atom' ), '<span>' . get_search_query() . '</span>' ); ?>
	        	<?php endif; ?>
	    	</h2>
	    </header>

	    <?php get_search_form(); ?>

	    <hr>
	</div>
<?php elseif( is_404() ): ?>
	<div class="profile">
	    <header id="header">
	    	<a href='<?php echo esc_url( home_url( '/' ) ); ?>'>
	            <img id="avatar" class="2x" src="<?php echo get_bloginfo("template_directory"); ?>/assets/images/logo.png" width="80" height="80" />
	        </a>
	        <h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'atom' ); ?></h1>
	    	<h2><?php _e("Error 404", 'atom'); ?></h2>
	    </header>
	</div>
<?php endif; ?>