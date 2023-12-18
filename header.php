<?php

    /*
    This is the header template

    @package sunsettheme
    */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php bloginfo('name'); wp_title(); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta charset="<?php bloginfo('charset') //encoding for pages and feeds?>">
    <meta name="viewport" content="width+device-width, initial-scale=1"><?php // responsive for all devices ?>
    <link rel="profile" href="http://gmpg.org/xfn/11"><?php // to verify the version of HTML5, may trigger error for HTML4 ?>
    <?php // if ( is_singular() && pings_open( ger_queried_object() )) : //is_singular Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).
    //Determines whether the current post is open for pings. ?>    
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"> <!-- for search engines and other websites ot pingback
            A WordPress pingback is a notification that WordPress sends to other WordPress blogs when linking to their content.-->
    <?php //endif; ?>    
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="sunset-sidebar sidebar-closed">
		
		<div class="sunset-sidebar-container">
		
			<a class="js-toggleSidebar sidebar-close">
				<span class="sunset-icon sunset-close"> Close </span>
			</a>
		
			<div class="sidebar-scroll">
				
				<?php get_sidebar(); ?>
				
			</div><!-- .sidebar-scroll -->
		
		</div><!-- .sunset-sidebar-container -->
		
	</div><!-- .sunset-sidebar -->

    <div class="sidebar-overlay js-toggleSidebar"></div>


    <div class="container-fluid">
        <div class="row">
            <header class="header-container background-image text-center" style="background-image: url(<?php header_image(); ?>)">
                <a class="js-toggleSidebar sidebar-open">
                        <span class="sunset-icon sunset-menu" style="font-size:20px;">Sidebar</span>
                </a>  
            <div class="header-content table">
                    <div class="table-cell">
                        <h1 class="site-title"><?php bloginfo('name'); ?></h1>
                        <h2 class="site-description"><?php bloginfo('description'); ?></h2>
                    </div>
                </div>
                <div class="nav-container hidden-xs">
                    <nav class="navbar navbar-default navbar-sunset mynav">
                        <?php
                            wp_nav_menu( array(
                                'theme_location' => 'primary',
                                'container'      => false,
                                'menu_class'     => 'nav navbar-nav',
                                'walker'         => new Sunset_Walker_Nav_Primary()
                            ) );
                        ?>
                    </nav>

                </div>
            </header><!--header-container -->
        </div>
    </div>