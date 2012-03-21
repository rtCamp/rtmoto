<?php
/**
 * The loop that displays the post according to the query.
 *
 * This can be called using get_template_part() function
 * We ask for the loop with :
 * <code>get_template_part( 'loop', 'common' );</code>
 *
 */

/* breadcrumb support is here - please refer readme.txt for further instructions */
if ( function_exists( 'bcn_display' ) ) {
    echo '<div class="breadcrumb">';
        bcn_display();
    echo '</div>';
}

/* If there are no posts to display, such as an empty archive page or 404 page */
if ( ! have_posts() ) : ?>
<div id="post-0" <?php post_class(); ?>>
		<h1 class="entry-title"><?php _e( 'Not Found', 'mrmoto2.0' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'mrmoto2.0' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif;

/* Start the Loop.
 *
 * we use the same loop in multiple contexts.
 *
 * we sometimes check for whether we are on an
 * archive page, a search page, etc., allowing for small differences
 * in the loop without actually duplicating
 * the rest of the loop that is shared.
 *
 * the loop:
 */

if (have_posts ()) :

    // For archives pages
    if (is_search ()) {
        ?><div class="post-title"><h1><?php printf(__('Search Results for: %s'), '<span>' . get_search_query() . '</span>'); ?></h1></div><?php
    }
    if (is_tag ()) {
        ?><div class="post-title"><h1><?php printf(__('Tags: %s'), '<span>' . single_tag_title('', false) . '</span>'); ?></h1></div><?php
    }
    if (is_category ()) {
        ?><div class="post-title"><h1><?php printf(__('Category: %s'), '<span>' . single_cat_title('', false) . '</span>'); ?></h1></div><?php
    }
    if (is_day ()) {
        ?><div class="post-title"><h1><?php printf(__('Archive for %s'), '<span>' . get_the_time('F jS, Y') . '</span>'); ?></h1></div><?php
    }
    if (is_month ()) {
        ?><div class="post-title"><h1><?php printf(__('Archive for  %s'), '<span>' . get_the_time('F, Y') . '</span>'); ?></h1></div><?php
    }
    if (is_year ()) {
        ?><div class="post-title"><h1><?php printf(__('Archive for  %s'), '<span>' . get_the_time('Y') . '</span>'); ?></h1></div><?php
    }
    if (get_query_var('author_name')) {
        $cur_auth = get_user_by("slug", get_query_var("author_name"));
        ?><div class="post-title"><h1> <?php printf(__('Author: %s'), '<span>' . trim(ucfirst($cur_auth->display_name)) . '</span>'); ?> </h1></div><?php
    }

    while (have_posts ()) : the_post(); ?>
        <div <?php post_class() ?>>
            <div class="post-title">
                <?php
                if (is_singular ()) {
                    ?><h1><?php the_title(); ?></h1><?php
                }
                else {
                    ?><h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2><?php
                }
                edit_post_link('Edit This Entry', '<p>', '</p>');
                ?>
                <div class="clear"></div>
            </div><!-- .post-title -->

            <?php if ( !is_page() ) { ?>
                <div class="post-meta">
                    <p><em>Posted by</em> <?php the_author();?> <em>on</em> <?php the_time('F jS, Y') ?> | <?php comments_popup_link( 'No Comments', '1 Comment', '% Comments' ); ?></p>
                    <!-- Category -->
                    <?php if( get_the_category_list() ) { ?><p><em>Posted in</em> <?php the_category( ', ' ) ?></p><?php } ?>
                    <!-- tags -->
                    <?php if( get_the_tag_list() ) { ?><p><?php the_tags( '<em>Tags:</em> ', ', ', '<br />' ); ?></p><?php } ?>
                </div><!-- end of .post-meta -->
            <?php } ?>
            <div class="post-content">
                <?php if ( !is_singular() ) {
                            $first_image = rt_get_first_img( 0, '', 200, 180, '' );
                            if(!empty($first_image)) { ?>
                            <span class="post-img alignright">
                                <a href="<?php echo get_permalink()?>"><?php echo $first_image;?></a>
                            </span>
                <?php    }
                        } // End of post image

                        if ( is_singular () ) {

                            if(is_attachment ()) {
                                    if ( wp_attachment_is_image() ) :
                                        $attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
                                        foreach ( $attachments as $k => $attachment ) {
                                            if ( $attachment->ID == $post->ID )
                                                break;
                                        }
                                        $k++;
                                        // If there is more than 1 image attachment in a gallery
                                        if ( count( $attachments ) > 1 ) {
                                            if ( isset( $attachments[ $k ] ) )
                                                // get the URL of the next image attachment
                                                $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
                                            else
                                                // or get the URL of the first image attachment
                                                $next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
                                        } else {
                                            // or, if there's only 1 image attachment, get the URL of the image
                                            $next_attachment_url = wp_get_attachment_url();
                                        }
                                    ?>
                                            <p class="attachment"><a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
                                                $attachment_size = 900;
                                                echo wp_get_attachment_image( $post->ID, array( $attachment_size, 9999 ) ); // filterable image width with, essentially, no limit for image height.
                                            ?></a></p>

                                            <div id="nav-below" class="navigation">
                                                <div class="alignleft nav-previous"><?php previous_image_link( false ); ?></div>
                                                <div class="alignright nav-next"><?php next_image_link( false ); ?></div>
                                                <div class="clear"></div>
                                            </div><!-- #nav-below -->
                                    <?php else : ?>
                                                            <a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
                                    <?php endif;
                                }
                                else
                                    the_content('Read the rest of this entry &raquo;');
                        } else {
                            the_excerpt('read more');
                        }

                        
                        wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:'), 'after' => '</div>' ) );
                ?>
                <div class="clear"></div>
            </div>
        </div><!--end of .post_class -->

        <?php
            /* Normal Pagination on single.php */
            if( is_single() ) { ?>
            <div class="wp-navigation clearfix">
                <div class="alignleft"><?php previous_post_link( '%link', '&laquo; %title' ); ?></div>
                <div class="alignright"><?php next_post_link( '%link', '%title &raquo;' ); ?></div>
            </div>
        <?php }
            /* Including comment form on both single post and page */
            if ( is_singular() ) comments_template( '', true );
            
        endwhile;
        //support for page-navi plugin, please refer readme.txt for further instructions
        if ( !is_singular() ) {

                if ( function_exists('wp_pagenavi') ) {
                    wp_pagenavi();
                }
                elseif ( get_next_posts_link() || get_previous_posts_link() ) { ?>
                    <div class="wp-navigation clearfix">
                        <div class="alignleft"><?php next_posts_link('&laquo; Older Entries'); ?></div>
                        <div class="alignright"><?php previous_posts_link('Newer Entries &raquo;'); ?></div>
                    </div>
            <?php } //if wp_pagenavi
        } //is singular
    endif;
?>