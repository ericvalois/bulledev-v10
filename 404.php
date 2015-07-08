<?php get_header(); ?>

    <section id="post-body">
        <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'atom' ); ?></p>

        <?php get_search_form(); ?>

        <hr>

        <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

        <hr>

        <?php //if ( _s_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
            <div class="widget widget_categories">
                <h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'atom' ); ?></h2>
                <ul>
                <?php
                    wp_list_categories( array(
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                        'show_count' => 1,
                        'title_li'   => '',
                        'number'     => 10,
                    ) );
                ?>
                </ul>
            </div><!-- .widget -->
        <?php //endif; ?>

        <hr>

        <?php
            /* translators: %1$s: smiley */
            $archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'atom' ), convert_smilies( ':)' ) ) . '</p>';
            the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
        ?>

        <hr>
        
        <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
    </section>

<?php get_footer(); ?>
