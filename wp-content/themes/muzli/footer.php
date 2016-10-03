</section>

</main>

<aside class="pre-footer">
    <div class="container">
    <?php  dynamic_sidebar('sidebar-primary') ?>
    </div>
</aside>

<footer class="site-footer">
    <div class="container">
        <p class="small">
            &copy; <?php  echo get_theme_mod('copy_by') ?>
            <span>
					<?php  echo get_theme_mod('copy_text') ?>
				</span>
        </p>
    </div>
</footer>
    <?php  wp_footer() ?>
</body>
</html>