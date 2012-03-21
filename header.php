<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
        <!--
            ******************* Mobile Viewport Fix *******************
            j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag
            device-width : Occupy full width of the screen in its current orientation
            initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
            maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width
        -->
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        
        <!-- Place favicon.ico and apple-touch-icon.png in the root of your domain and delete these references -->
        <!-- <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico" /> -->
        <!-- icon for apple iphone, ipod -->
        <!-- <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri();?>/img/apple-touch-icon.png"> -->

        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/reset.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/print.css" type="text/css" media="print" />

        
        <!--[if IE 6 ]>
                <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie6.css"  />
        <![endif]-->
        <!--[if IE 7 ]>
                <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie7.css"  />
        <![endif]-->
        <!--[if gt IE 6]>
            <style type="text/css">
                #content, .searchform .s, #sidebar .sidebar-widget { position:relative; behavior: url(<?php echo get_template_directory_uri(); ?>/js/PIE.htc )}
            </style>
        <![endif]-->

        <?php if (is_singular() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply'); } //nested comment support. For more details check readme.txt
        //Any javascript u need should be called in custom.js file located in 'js' directory
        //IMPORTANT: You may need to add more wp_enqueue_script calls which should go here i.e. before custom.js.
        //Also make sure array() gets proper list of js handles

        /** Use following script for Slider using Cycle
         * wp_enqueue_script('jquery-cycle', get_template_directory_uri(). '/js/jquery.cycle.js', array('jquery'), '', true);
         */
        wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '', true);
       ?>        
    <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>        
        <div id="main-wrapper"> <!-- this is closed in footer.php -->

            <div id="header-wrapper">
                <div id="header">
                    <div class="logo">
                        <h1><a href="<?php echo site_url();?>"><?php bloginfo('name'); ?></a></h1>
                        <p class="description"><?php bloginfo('description'); ?></p>
                    </div>
                    <div class="header-right">
                        <div class="search-header">
                            <?php get_search_form(); ?>
                        </div>
                        <div id="rt-primary-menu">
                        <?php
                                /* Wordpress Menu with Fall-Back Menu of List Pages */
                                if( function_exists('wp_nav_menu') && has_nav_menu('primary') ) {
                                    wp_nav_menu(array('container' => '', 'menu_id' => 'rt-nav-menu', 'theme_location' => 'primary', 'depth' => '5'));
                                } else {
                                    echo '<ul class="menu" id="rt-nav-menu">';
                                        wp_list_pages('title_li=&sort_column=menu_order&depth=5&number=5');
                                    echo '</ul>';
                                }
                            ?>
                        </div><!-- end of #rt-primary-menu -->
                    </div>

                </div><!--end of #header -->               

                <div class="clear"></div>

            </div><!--end of #header-wrapper -->

            <div id="content-wrapper"><!-- this is closed in footer.php -->