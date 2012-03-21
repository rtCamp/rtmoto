		<div class="clear"></div> <!--clear any float present at this point -->
            </div><!-- End of #content-wrapper -->

            <div id="footer-wrapper">
                <div id="footerbar">
                <?php
                /* Widgetized sidebar, if you have the plugin installed. */
                if ( function_exists('dynamic_sidebar') )
                    dynamic_sidebar('Footer Widgets')  ;
                ?>
                </div><!--end of #footerbar-->
				
                <div class="clear"></div>
                <div id="footer">
                    <!-- If you'd like to support WordPress, having the "powered by" link somewhere on your blog is the best way; it's our only promotion or advertising. -->
                    <p class="aligncenter">&copy; <?php echo date('Y'); 
                    echo ' - '; bloginfo('name'); ?></p>
                    <p class="aligncenter"><em>(Powered by <a href="http://wordpress.org/">WordPress</a>. Using <a href="http://bloggertowp.org/themes/rtmoto/">rtMoto theme</a> designed by <a href="http://rtcamp.com" title="This wordpress theme is designed by rtCamp">rtCamp</a>)</em></p>
                </div><!--end of #footer -->
            </div><!--End of #footer-wrapper-->
	</div><!--End of #main-wrapper -->
        <!--
            Moved all the scripts in the "php/rt-init.php" for wordpress standards
            Look for rt_footer_scripts() function to add your custom scripts.
        -->
        <?php wp_footer(); ?>
    </body>
</html>