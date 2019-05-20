<?php
/**
 * Footer Template
 *
 * Here we setup all logic and XHTML that is required for the footer section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */

 global $woo_options;

 ?>

 <?php

 woo_footer_top();
 	woo_footer_before();
?>
	<footer id="footer" class="col-full">

		<?php woo_footer_inside(); ?>
		
        <div id="social">
            <ul class="social-icons">
                <li><a href="https://www.facebook.com/isabellaavenuedentistry/" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
                <li><a href="https://twitter.com/isabella_ave" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://www.yelp.com/biz/isabella-avenue-dentistry-coronado" target="_blank"><i class="fa fa-yelp"></i></a></li>
                <li><a href="https://www.instagram.com/isabellaavedentistry/" target="_blank"><i class="fa fa-instagram"></i></a></li>
            </ul>
        </div>		
		
		<p>© Copyright <?php bloginfo( 'name' ); ?> <?php echo date("o");?></p>
		<p>Website by <a href="http://wonderistagency.com" target="_blank">Wonderist Agency</a></p>
        <p><a href="/privacy-policy/">Privacy Policy</a></p>
	</footer>

	<?php woo_footer_after(); ?>

	</div><!-- /#inner-wrapper -->

</div><!-- /#wrapper -->

<div class="fix"></div><!--/.fix-->

<?php wp_footer(); ?>
<?php woo_foot(); ?>
</body>
</html>
