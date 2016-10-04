<?php get_header() ?>

        <?php if (have_posts()) : ?>
            <div class="post-list">
            <?php while (have_posts()) : the_post() ?>
                <article <?php post_class()?> >
                    <h1 class="post-title"><?php the_title() ?></h1>
                    <?php  the_content('') ?>
                </article>
            <?php endwhile ?>
                </div>

        <?php endif ?>


<?php get_footer() ?>
