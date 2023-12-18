<?php
/*

@package sunsetTheme

==============================
AUDIO POST FORMAT
==============================
*/
?>
<?php /*generic rule in wp,  when a function has get_ (like: get_the_ID(); )in the beginning usually to print it we need to use echo, because it will return 
the value stored in a variable. 
when a function doesn't start with get_ like( the_ID(); ) no need to use echo, it will return the value automatically and print it */?>

<article id="post-<?php the_ID(); ?>" <?php post_class('sunset-format-audio'); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title"><a href="'. esc_url( get_permalink() ). '" rel="bookmark">', '</a></h1>'); ?>
        <div class="entry-meta">
            <?php echo sunset_posted_meta(); ?>
        </div>
    </header>
    <div class="entry-content">
        <?php echo sunset_get_embedded_media( array('audio', 'iframe'));  ?>
    </div>
    <footer class="entry-footer">
        <?php echo sunset_posted_footer(); ?>
    </footer>

</article>


