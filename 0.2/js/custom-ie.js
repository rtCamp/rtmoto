jQuery(document).ready(function(){
    /* Drop down for menu*/
        jQuery('#rt-nav-menu li').hover(
        function(){
            jQuery(this).children('ul').css('display','block')
        },
        function(){
            jQuery(this).children('ul').css('display','none')
        });
});