<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
			
	<article class="post">
	    <header>
	        <h1><?php the_title(); ?></h1>
	        <h2 class="headline"><?php echo get_the_date("j M Y"); ?></h2>
	    </header>
	    <section id="post-body">
	        <?php the_content(); ?>
	    </section>

	    <hr>

	    <?php if( get_post_type() == 'post' ): ?>
	    	<footer>
		    	<p><?php _e("Category","atom"); ?>: <?php echo get_the_term_list( $post->ID, 'category', ' ', ', ', '' ); ?><br></p>

				<p><?php the_tags( __('Subjects: ','atom'), ', ', ''); ?> </p>
		    </footer>
	    <?php endif; ?>
	</article>


	<?php if( get_post_type() == 'post' ): ?>
		<footer id="post-meta" class="clearfix">
		    <a href="http://twitter.com/{{ site.authorTwitter }}">
		        <img class="avatar" src="<?php echo get_bloginfo("template_directory"); ?>/assets/images/ericvalois.png">
		        <div>
		            <span class="dark"><?php echo get_the_author(); ?></span>
		            <span><?php bloginfo('description'); ?></span>
		        </div>
		    </a>

		    <section id="sharing">
		        <?php include(TEMPLATEPATH . "/_includes/share.php"); ?>
		    </section>
		</footer>
	<?php endif; ?>

	<?php
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || get_comments_number() ) :
			comments_template( '', true );
		endif;
	?>

<?php endwhile; // end of the loop. ?>

<?php // Archive post list ?>
<ul id="post-list" class="archive readmore">
	<h3><?php _e("Read more","atom"); ?></h3>
    <?php 
    	$args = array( 'posts_per_page' => 10 );

    	if( get_post_type() == 'question' ){
    		$args = array( 'posts_per_page' => 10, 'post_type' => 'question' );
    	}else{
    		$args = array( 'posts_per_page' => 10 );
    	}

		$last_posts = get_posts( $args );

		foreach ( $last_posts as $post ) : setup_postdata( $post );
    ?>
        <li>
            <a href='<?php echo get_permalink($post->ID); ?>'><aside class="dates"><?php echo get_the_date('M j' , $post->ID); ?></aside></a>
            <a href='<?php echo get_permalink($post->ID); ?>'><?php echo $post->post_title; ?></a>
        </li>
    <?php 
    	endforeach; 
		wp_reset_postdata();
	?>
</ul>

<?php get_footer(); ?>