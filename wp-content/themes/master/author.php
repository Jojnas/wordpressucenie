<?php get_header() ?>

<main>
    <section class="posts">
        <header>
            <h1><?php the_author() ?></h1>
        </header>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post() ?>
                <article id="post-<?php the_ID() ?>" <?php post_class() ?>>
                    <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                </article>


            <?php endwhile ?>
        <?php else : ?>
            <p>we got nothing</p>
        <?php endif ?>
    </section>
</main>

<?php get_footer() ?>
