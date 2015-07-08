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
        </article>

    <?php endwhile; // end of the loop. ?>
   
<?php get_footer(); ?>
