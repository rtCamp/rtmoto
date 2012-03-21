jQuery(document).ready(function() {
    /* added for search field default value */
    jQuery('.s').blur(function(){ if(this.value == '') this.value='Search Here...' ; });
    jQuery('.s').focus(function(){ if(this.value == 'Search Here...') this.value=''; } );
});