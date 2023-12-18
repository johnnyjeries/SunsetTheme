<?php
/*

@package sunsetTheme

==============================
STANDARD POST FORMAT
==============================
*/
?>
<?php /*generic rule in wp,  when a function has get_ (like: get_the_ID(); )in the beginning usually to print it we need to use echo, because it will return 
the value stored in a variable. 
when a function doesn't start with get_ like( the_ID(); ) no need to use echo, it will return the value automatically and print it */?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header text-center">
        <?php the_title( '<h1 class="entry-title"><a href="'. esc_url( get_permalink() ). '" rel="bookmark">', '</a></h1>'); ?>
        <div class="entry-meta">
            <?php echo sunset_posted_meta(); ?>
        </div>
    </header>
    <div class="entry-content">
        <?php
            if( sunset_get_attachment() ):
                $featured_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
            ?>
                <a href="<?php the_permalink(); ?>" class="standard-featured-link">
                    <div class="standard-featured" style="background-image: url(<?php echo $featured_image; ?>)"></div>
            </a>
        <?php endif; ?>

        <div class="entry-excerpt">
            <?php the_excerpt(); ?>
        </div>

        <div class="button-container text-center">
            <a href="<?php the_permalink(); ?>" class="btn btn-sunset"><?php _e('Read More'); //safer way to write text so the user can't edit it ?></a>
        </div>
    </div>
    <footer class="entry-footer">
        <?php echo sunset_posted_footer(); ?>
    </footer>

</article>


