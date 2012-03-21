<?php
/* 
 * This file contains codes for post summaries with thumbnail
 */

/* Post Summaries */
/* ======================= */

//add_filter('the_content','rt_post_summary');

function rt_post_summary($content) {
    global $post;

    $thumb = 'alignleft' ; //"alignleft", "alignright", "";
    $wordcount = 55 ; //word count to show in summaries
    $strip_tags = TRUE ; //Strip tags(true/false) - remove links/etc
    $embed_tags = FALSE ; //Display videos from summaries(true/false)

    if( !is_singular() && !is_feed() ) {
	   	$content = $post->post_content; //screw the "more" tag :P
		$content = rt_filter_post_custom($content, $thumb, $wordcount, $strip_tags, $embed_tags);
    }

    return $content;
}

//actual post summary generation
function rt_filter_post_custom($content, $thumb='alignleft', $wordcount=55, $strip_tags = TRUE, $embed_tags = FALSE) {
    global $post;
    
    $video = $image = FALSE;
    
    if(!has_post_thumbnail() && FALSE ) {
        //this post do not have any "featured image"
		$post_has_image = preg_match('/<img.*src\s*=\s*"([^"]+)[^>]+>/i', $content, $match);
		if($post_has_image) {
            //fcuk timthumb and its permission issues
	    $image = '<img class="'.$thumb.' post-thumb" src ="'. rt_get_thumbnail_from_image_url($match[1],300,300,1) . '" alt="Image" />';
		}
    }else {
    	//this post is using wordpress's featured-image feature... wOw!
		$image = get_the_post_thumbnail( $post->ID, 'medium', array('class' => $thumb.' post-thumb') );
    }
    
    if($embed_tags) {
		preg_match('/<object[^>].*<\/object>/iU', $content, $matches);
		$video = $matches[0];
    }

    if($strip_tags)
		$content = strip_tags($content);

    $cont_array = explode(' ',$content);
    
    if(count($cont_array) > $wordcount)
		$content = implode(' ',array_slice($cont_array, 0, $wordcount)).'...';

    $content = '<p>'.$content.$video.'</p>';

    if($image)
		$content = '<span>'.$image.'</span>'.$content;

    return $content;
}

/**
 * @global object $post
 * @param int $postid if passed 0 then it will take global post id (in the_loop).
 * @param string $content if passed null then it will take global post content (in the_loop).
 * @param int $width sets the width
 * @param int $height sets the height
 * @param string $thumb sets css class for image
 * @param bool $default To use default image, Defaults to false
 * @param string $default_img_src IF using default image, set the img url for different default image e.g 'default-image.png'
 * @return string|bool returns string containing the image tag, FALSE on failure.
 */
function rt_get_first_img( $postid= 0, $content = '', $width = 250, $height = 200, $thumb = '', $default = FALSE, $default_img_src = '' ) {
    global $post;
    /* Setting the variables */
    $image = '';
    if( 0 == $postid ) $postid = $post->ID;
    if( empty( $content ) ) $content = $post->post_content;

    if( ! has_post_thumbnail( $postid ) && RT_THUMBNAILS_AUTO ) {
    	$post_has_image = preg_match( '/<img.*src\s*=\s*"([^"]+)[^>]+>/i', $content, $match );
        if( $post_has_image ) {
            $img_src = rt_get_thumbnail_from_image_url( $match[1], $width, $height, 1 );
            if( $img_src ) {
                $image = '<img class="post-thumb '.$thumb.'" src ="'. $img_src  . '" alt="'.$post->post_title.'" />';
            }
        }
    } else {
        /* modified for featured image resizing
        * as the_post_thumbnail() function returns the image in the proportion,
        * We are only taking the source of the featured image,
        * And resizing it using rt_get_thumbnail_from_image_url() function
        */
        $featured_img_id = get_post_thumbnail_id( $postid );
        list( $src, $w, $h ) = wp_get_attachment_image_src( $featured_img_id, 'full' );
        if( ! empty( $src ) ) {
            $img_src = rt_get_thumbnail_from_image_url( $src , $width, $height, 1 );
            if( $img_src ) {
                $image = '<img class="post-thumb '.$thumb.'" src ="'. $img_src  . '" alt="'.$post->post_title.'" />';
            }
        }
    }
    if( empty( $image ) && $default ) {
        /* set the default image path */
        $src = ( ! empty( $default_img_src ) ) ? get_template_directory_uri().'/img/'.$default_img_src : get_template_directory_uri().'/img/i-logo.png' ;
        $image = '<img class="post-thumb '.$thumb.'" src ="'. rt_get_thumbnail_from_image_url( $src, $width, $height, 1 ) . '" alt="'.$post->post_title.'" />';
    }
    return ( $image ) ? $image : FALSE;
}

/**
 * Returns the array of the post images
 * @global object $post
 * @param int $postid if passed 0 then it will take global post id. For using it in the loop
 * @param int $width sets the height
 * @param int $height sets the width
 * @return array|bool returns array of posts attachment images. FALSE if no image found
 */
function rt_get_all_post_images( $postid = 0, $width = 250, $height = 200 ) {
        global $post;
        $all_the_images = array();
        if( $postid == 0 ) {
            $postid = $post->ID;
        }
        $thumbargs = array( 'post_type' => 'attachment', 'post_status' =>null, 'numberposts' => -1, 'post_parent' => $postid, 'mime_type' => 'image' );
        $all_thumbs_posts = get_posts( $thumbargs );
        foreach( $all_thumbs_posts as $single_thumb ) {
                list( $src, $w, $h ) = wp_get_attachment_image_src( $single_thumb->ID ); // getting all the image data in variables
                if( ! empty( $src ) ) {
                    $all_the_images[] = '<img class="post-thumb" src ="'. rt_get_thumbnail_from_image_url( $src, $width, $height, 1) . '" alt="Image" />';
                }
        }
        return ( count( $all_the_images ) > 0 ) ? $all_the_images : FALSE;
}

/**
 * Returns the post summary of the given content with the given wordcount
 *
 * @global object $post
 * @param string $content takes post content when called in the loop | optional
 * @param int $word_count default is 55 | optional
 * @return string
 */
function rt_get_only_excerpt( $content = '', $word_count = 55 ) {
    global $post;
    $content = ( ! empty( $content ) ) ? $content : $post->post_content;
    $content = strip_tags( $content );

    $cont_array = explode( ' ', $content );
    if( count( $cont_array ) > $word_count ) {
        $content = implode( ' ', array_slice( $cont_array, 0, $word_count ) ).' [...]';
    }
    $content = '<p>'.$content.'</p>';
    return $content;
}

/** replacing [...] of the excerpt */
function rt_no_ellipsis( $text ) {
    global $post;
    return str_replace( '[...]', '...<a class="readmore" title="Read More On '.get_the_title().'" href="' . get_permalink( $post->ID ) . '" rel="nofollow">Read More</a>', $text );
}
add_filter( 'the_excerpt', 'rt_no_ellipsis' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function rt_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'rt_remove_gallery_css' );
