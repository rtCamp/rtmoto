<?php
/* 
 * Any code to be run after theme is activated here
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run rt_base_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'rt_base_setup' );

if ( ! function_exists( 'rt_base_setup' ) ) {
    /**
     *
     * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
     * @uses register_nav_menus() To add support for navigation menus.
     *
     */
    function rt_base_setup() {

        // This theme uses post thumbnails
        add_theme_support( 'post-thumbnails' );

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        /* custom background */
        add_custom_background();

        define( 'NO_HEADER_TEXT' , true );

        $upload_dir = wp_upload_dir();
        define( 'RT_CACHE_DIR_PATH' , $upload_dir['basedir'] . "/rt-cache/" );
        define( 'RT_CACHE_DIR_URL' , $upload_dir['baseurl']. "/rt-cache/" );
        define( 'HEADER_TEXTCOLOR' , '' );
        define( 'HEADER_IMAGE_WIDTH' , 960 );
        define( 'HEADER_IMAGE_HEIGHT' , 109 );
        /* adding support for the header image */
        add_custom_image_header('rt_header_style', 'rt_admin_header_style');

        if ( ! function_exists( 'rt_header_style' ) ) : /* gets included in the admin header */
                function rt_admin_header_style() {
                ?>
                <style type="text/css">  #headimg { width: <?php echo HEADER_IMAGE_WIDTH; ?>px; height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; } </style>
              <?php }
        endif;

        /* Gets included in the site header */
        if ( ! function_exists( 'rt_header_style' ) ) :
                function rt_header_style() {
                        if ( get_header_image() ) { ?>
                        <style type="text/css"> #header-wrapper { background: url(<?php header_image(); ?>); } </style><?php
                        }
                }
        endif;

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => __( 'Primary Navigation' ),
        ) );

//        Create rt_cache dir in upload 
        wp_mkdir_p( RT_CACHE_DIR_PATH );
    }
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function rt_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'rt_page_menu_args' );

/**
 * Includes Scripts in the footer for IE
 */
function rt_footer_scripts() { ?>
    <!--[if lte IE 7]>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/custom-ie.js"></script>
    <![endif]-->

    <!--[if IE 6]>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/custom-ie6.js"></script>
    <![endif]-->
<?php }
add_action('wp_footer','rt_footer_scripts'); //calls footer scripts