<?php get_header() ?>

<main>
    <section class="posts">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post() ?>
                <article id="post-<?php the_ID() ?>" <?php post_class() ?>>
                        <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                        <?php the_content('&hellip;gimme all') ?>
                </article>


            <?php endwhile ?>
        <?php else : ?>
            <p>we got nothing</p>
        <?php endif ?>
    </section>
</main>

<?php get_footer() ?>
