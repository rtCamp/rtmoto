<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="alert">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h3>
	
	<ol class="commentlist">
		<?php wp_list_comments('avatar_size=52&type=comment'); ?>
	</ol>


	<!-- Comment pagination - can be controlled from "Dashboard >> Settings >> Discussion" -->	
	<div class="comments-pagination">
            <div class="alignleft"><?php previous_comments_link() ?></div>
            <div class="alignright"><?php next_comments_link() ?></div>
            <div class="clear"></div>
	</div>

<?php else : // this is displayed if there are no comments so far
            if ( comments_open() ) :
            // If comments are open, but there are no comments.
            else : // comments are closed
            endif;

     endif;

     /* Including Comment form using comment_form() function */
     if ( comments_open() ) :

        /**
         *
           $fields =  array(
                'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
                            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /></p>',
                'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
                            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" /></p>',
                'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label>' .
                            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
           );
           $rt_comment_form_args = array('fields'=> $fields);
         *
         * Pass the $rt_comment_form_args to the comment_form() function after editing the $fields array to match the theme design need.
         * e.g comment_form($rt_comment_form_args);
         *
         * Set the $fields values for auther, email and url fields display.
         *
        */

           comment_form();

     endif; 

/*
 * Start of Pingback and Trackback comment list
 * ref url : "http://lab.christianmontoya.com/wordpress-comments/comments.phps".
 */
$numPingBacks = 0;
$numComments  = 0;
/* Loop throught comments to count these totals */
foreach ($comments as $comment) {
    if ( get_comment_type() != "comment" ) { $numPingBacks++; }
    else { $numComments++; }
}
/* This is a loop for printing pingbacks/trackbacks if there are any */
if ($numPingBacks != 0) :
    $thiscomment = 'odd';
?>
<h3 class="comments-header"><?php _e($numPingBacks); ?> Trackbacks/Pingbacks</h3>
<ol id="trackbacks">
    <?php foreach ( $comments as $comment ) : ?>
        <?php if (get_comment_type()!="comment") : ?>
            <li id="comment-<?php comment_ID() ?>" class="<?php _e($thiscomment); ?>">
                <?php comment_author_link(); ?> <em>(<?php comment_type(__('Comment'), __('Trackback'), __('Pingback')); ?>)</em>
            </li>
        <?php if('odd'==$thiscomment) { $thiscomment = 'even'; } else { $thiscomment = 'odd'; } ?>
    <?php endif; endforeach; ?>
</ol>
<?php endif;
/*
 * End of Pingback and Trackback comment list
 */
?>