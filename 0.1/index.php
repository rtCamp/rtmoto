<?php 
/**
 * The template for displaying home page, archives pages, 404 page,
 * search page, single post, single page, etc
 * 
 * This is the most generic template file in a WordPress theme.
 * This template displays posts according to the query.
 * 
 */

get_header(); ?>

<?php get_sidebar(); ?>

    <div id="content" >

    <?php get_template_part( 'loop', 'common' ); ?>

    </div>

<?php get_footer(); ?>