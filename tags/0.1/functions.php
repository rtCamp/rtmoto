<?php
/* ---------------------------------------------------------------------------------- */
/* Theme Configuration - This will be replaced by a supercool theme-option admin page in next version! ;-)
/* ---------------------------------------------------------------------------------- */

//set this to 'true' to enable automated generation of thumbnails for old posts which do not have featured-image set  
define('RT_THUMBNAILS_AUTO', false);	

/* ----------------------------------------- */
/* include all PHP files inside 'php' folder
/* ----------------------------------------- */

foreach( glob ( get_template_directory() . "/php/*.php") as $lib_filename) {
    require_once($lib_filename);
}
?>
