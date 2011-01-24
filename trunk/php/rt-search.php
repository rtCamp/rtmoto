<?php
/* 
 * Code for overriding wordpress search engine
 */

/* Support for Google custom search */
/* =================================== */
function rt_custom_search_form($form) {

    $form = '<form method="get" class="searchform" action="' . home_url() . '/" >
                <div><label class="hidden">' . __('Search for:') . '</label>
                    <input type="text" value="' . ((get_search_query()) ? esc_attr(apply_filters('the_search_query', get_search_query())) : 'Search Here...') .'" name="s" class="s" />
                    <input type="submit" class="searchsubmit" value="'.esc_attr(__('Search')).'" /></div>
             </form>';
    return $form;
}
add_filter('get_search_form', 'rt_custom_search_form'); //cooment out this line to use wordpress's builtin search form