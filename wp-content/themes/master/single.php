<?php get_header() ?>

<main>
    <section class="posts">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post() ?>
                <article <?php post_class() ?>>
                    <header>
                        <h3><?php the_title() ?></h3>
                        <time datetime=""><em><?php  the_time(get_option('date_format')) ?></em></time>
                    </header>
                    <div class="post-content">
                        <?php the_content() ?>
                    </div>
                </article>


            <?php endwhile ?>
        <?php else : ?>
            <p>we got nothing</p>
        <?php endif ?>
    </section>
</main>

<?php get_footer() ?>
