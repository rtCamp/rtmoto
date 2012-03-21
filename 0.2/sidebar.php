<?php
/**
 * The Sidebar containing the Sidebar Widgets
 */
?>
<div id="sidebar">
	<?php
	/* Widgetized sidebar, if you have the plugin installed. */
            if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( 'Sidebar Widgets' ) ) { ?>

			<!-- Fall-Back Default Widgets -->
				<div class="widget sidebar-widget"><h2 class="widgettitle">Recent Posts</h2><ul><?php $recent_posts = wp_get_recent_posts( 5 ); foreach( $recent_posts as $post ){ echo '<li><a href="' . get_permalink( $post["ID"] ) . '" title="Look '.$post["post_title"].'" >' .   $post["post_title"].'</a> </li> '; } ?> </ul> </div>
				<div class="widget sidebar-widget"><h2 class="widgettitle">Archives</h2><ul><?php wp_get_archives( 'type=monthly' ); ?></ul></div>
				<div class="widget sidebar-widget"><h2 class="widgettitle">Categories</h2><ul><?php wp_list_categories( 'title_li=' ); ?></ul> </div>
				<div class="widget sidebar-widget"><h2 class="widgettitle">Meta</h2><ul><?php wp_register(); ?><li><?php wp_loginout(); ?></li> <li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li> <li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li> <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li> <?php wp_meta(); ?> </ul> </div>
            <!-- End of Default Widgets -->

       <?php } ?>
</div><!--end of #sidebar-->