<ul id="post-list">
    <?php if ( have_posts() ) : ?>
                
        <?php while ( have_posts() ) : the_post(); ?>
            <li>
                <a href='<?php echo get_permalink($post->ID); ?>'><aside class="dates"><?php echo get_the_date('M j' , $post->ID); ?></aside></a>
                <a href='<?php echo get_permalink($post->ID); ?>'><?php echo $post->post_title; ?></a>
            </li>
        <?php endwhile; ?>
                
    <?php else : ?>
        <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'atom' ); ?></p>
    <?php endif; ?>
</ul>

<?php include(TEMPLATEPATH . "/_includes/pagination.php"); ?>