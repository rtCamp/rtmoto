jQuery(document).ready(function(){
    /* Current Menu Class */
	jQuery("li.current-menu-item > a").addClass("current-menu");

    /* Admin Comment Class */
	jQuery("li.comment-author-admin > div.comment-body").addClass("admin-comment");
});