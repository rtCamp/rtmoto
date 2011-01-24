<?php
/* 
 * Code for number of sidebar to be included in theme here.
 */

/* Register All Sidebars */
/* ======================= */
add_action( 'widgets_init', 'rt_widgets_init' );

function rt_widgets_init() {
    register_sidebar(array(
            'name' => 'Sidebar Widgets',
            'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle">',
            'after_title' => '</h2>',
    ));

    register_sidebar(array(
            'name' => 'Footer Widgets',
            'before_widget' => '<div id="%1$s" class="widget footerbar-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle">',
            'after_title' => '</h2>',
    ));
}