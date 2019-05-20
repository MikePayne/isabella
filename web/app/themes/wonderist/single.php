<?php
/**
 * Single Post Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a post ('post' post_type).
 * @link http://codex.wordpress.org/Post_Types#Post
 *
 * @package WooFramework
 * @subpackage Template
 */

get_header();
?>

    <!-- #content Starts -->
	<?php woo_content_before(); ?>
 <!-- <div id="masthead" class="vc_row wpb_row vc_row-fluid padding-medium-top-bottom white vc_custom_1460381509820 vc_row-has-fill vc_row-o-content-middle vc_row-flex mpc-row mpc-with-separator" data-row-id="mpc_row-18570ba75704eef"><div class="wpb_column vc_column_container vc_col-sm-12 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper">
	<div class="wpb_text_column wpb_content_element ">
		<div class="wpb_wrapper">
			<h2 style="text-align: center;"><?php the_title();?></h2>
		</div>
	</div>
</div></div></div><div class="mpc-separator-spacer mpc-separator--bottom"></div><svg class="mpc-separator mpc-separator--bottom mpc-separator-style--blob-center" data-color="#73a0cc" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" style="fill: rgb(115, 160, 204);"><path d="M 0 0 L 0 105 L 100 105 L 100 0 Q 50 175 0 0 Z"></path></svg></div>
<div class="vc_row wpb_row vc_row-fluid vc_custom_1459779924339 vc_row-has-fill vc_row-o-content-middle vc_row-flex mpc-row mpc-with-separator" data-row-id="mpc_row-59570ba75705958"><div class="wpb_column vc_column_container vc_col-sm-12 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper"></div></div></div><div class="mpc-separator-spacer mpc-separator--bottom"></div><svg class="mpc-separator mpc-separator--bottom mpc-separator-style--blob-center" data-color="#ffffff" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" style="fill: rgb(255, 255, 255);"><path d="M 0 0 L 0 105 L 100 105 L 100 0 Q 50 175 0 0 Z"></path></svg></div>-->
    <div id="content" class="col-full">

    	<div id="main-sidebar-container">

            <!-- #main Starts -->
            <?php woo_main_before(); ?>
            <section id="main">
<?php
	woo_loop_before();

	if (have_posts()) { $count = 0;
		while (have_posts()) { the_post(); $count++;

			woo_get_template_part( 'content', get_post_type() ); // Get the post content template file, contextually.
		}
	}

	woo_loop_after();
?>
            </section><!-- /#main -->
            <?php woo_main_after(); ?>

            <?php get_sidebar(); ?>

		</div><!-- /#main-sidebar-container -->

		<?php get_sidebar('alt'); ?>

    </div><!-- /#content -->
	<?php woo_content_after(); ?>
	<!--<div id="doctor" class="vc_row wpb_row vc_row-fluid padding-medium white vc_custom_1460571399246 vc_row-has-fill mpc-row mpc-with-separator" data-row-id="mpc_row-84571101c4a3f8f"><div class="wpb_column vc_column_container vc_col-sm-12 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper"><div class="vc_row wpb_row vc_inner vc_row-fluid mpc-row"><div class="wpb_column vc_column_container vc_col-sm-6 mpc-column"><div class="vc_column-inner vc_custom_1459436093443"><div class="wpb_wrapper">
		<div class="wpb_text_column wpb_content_element ">
			<div class="wpb_wrapper">
				<h2>“Your best care begins with compassion and understanding.”</h2>
	<p>Whether you’re calling to set your six month appointment or haven’t seen a dentist in awhile, we’ll help you feel comfortable and safe when it’s time to see the dentist. Our conservative approach means we will work with you to find a treatment that gives you your best sense of health now and helps preserve and maintain your healthy teeth for years to come.</p>

			</div>
		</div>
	</div></div></div><div class="wpb_column vc_column_container vc_col-sm-6 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper"></div></div></div></div><div class="vc_row wpb_row vc_inner vc_row-fluid vc_row-o-content-bottom vc_row-flex mpc-row"><div class="wpb_column vc_column_container vc_col-sm-2 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper">
		<div class="wpb_single_image wpb_content_element vc_align_left">

			<figure class="wpb_wrapper vc_figure"><div class="vc_single_image-wrapper   vc_box_border_grey"><img width="129" height="70" src="http://thirdcoastdent.staging.wpengine.com/wp-content/uploads/2016/03/aacd-white.png" class="vc_single_image-img attachment-full" alt="aacd-white"></div>
			</figure></div>
	</div></div></div><div class="wpb_column vc_column_container vc_col-sm-2 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper">
		<div class="wpb_single_image wpb_content_element vc_align_left">

			<figure class="wpb_wrapper vc_figure"><div class="vc_single_image-wrapper   vc_box_border_grey"><img width="177" height="73" src="http://thirdcoastdent.staging.wpengine.com/wp-content/uploads/2016/03/ada-logo-white.png" class="vc_single_image-img attachment-full" alt="ada-logo-white"></div>
			</figure></div>
	</div></div></div><div class="wpb_column vc_column_container vc_col-sm-2 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper">
		<div class="wpb_single_image wpb_content_element vc_align_left">

			<figure class="wpb_wrapper vc_figure"><div class="vc_single_image-wrapper   vc_box_border_grey"><img width="267" height="78" src="http://thirdcoastdent.staging.wpengine.com/wp-content/uploads/2016/03/coda-white.png" class="vc_single_image-img attachment-full" alt="coda-white"></div>
			</figure></div>
	</div></div></div><div class="wpb_column vc_column_container vc_col-sm-6 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper">
		<div class="wpb_text_column wpb_content_element ">
			<div class="wpb_wrapper">
				<h3>– Dr. Sarah Blair</h3>

			</div>
		</div>
	</div></div></div></div></div></div></div><div class="mpc-separator-spacer mpc-separator--bottom"></div><svg class="mpc-separator mpc-separator--bottom mpc-separator-style--stamp" data-color="#73a0cc" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg" style="fill: rgb(115, 160, 204);"><path d="M 0 0 Q 2.5 50 5 0 Q 7.5 50 10 0 Q 12.5 50 15 0 Q 17.5 50 20 0 Q 22.5 50 25 0 Q 27.5 50 30 0 Q 32.5 50 35 0 Q 37.5 50 40 0 Q 42.5 50 45 0 Q 47.5 50 50 0 Q 52.5 50 55 0 Q 57.5 50 60 0 Q 62.5 50 65 0 Q 67.5 50 70 0 Q 72.5 50 75 0 Q 77.5 50 80 0 Q 82.5 50 85 0 Q 87.5 50 90 0 Q 92.5 50 95 0 Q 97.5 50 100 0 L 100 105 L 0 105 Z"></path></svg></div>

	<div class="vc_row wpb_row vc_row-fluid padding-none-medium-small white vc_custom_1460731500486 vc_row-has-fill mpc-row"><div class="wpb_column vc_column_container vc_col-sm-12 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper"><div class="vc_row wpb_row vc_inner vc_row-fluid cta vc_row-o-content-middle vc_row-flex mpc-row"><div class="wpb_column vc_column_container vc_col-sm-8 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper"><div data-id="mpc_icon_column-98571102b4ca4b2" class="mpc-icon-column mpc-parent-hover mpc-transition mpc-animation mpc-icon-column--style_3 mpc-align--left mpc-inited" data-animation-in="transition.slideLeftIn||1350||200||82" style="opacity: 1;"><div data-id="mpc_icon-73571102b4ca664" class="mpc-icon mpc-transition mpc-effect-none mpc-icon-hover mpc-inited" style="opacity: 1;"><div class="mpc-icon-wrap"><i class="mpc-icon-part mpc-regular mpc-transition  fa fa-phone"></i><i class="mpc-icon-part mpc-hover mpc-transition  fa fa-phone"></i></div></div><div class="mpc-icon-column__content-wrap"><div class="mpc-icon-column__content"><h3 class="mpc-icon-column__heading mpc-transition">Give Us a Call Today</h3><div class="mpc-icon-column__description"><p>Our positive and knowledgeable team will help you enjoy your experience, from scheduling an appointment that works in your schedule, to providing easy to understand answers to your questions.</p>
	</div></div></div></div></div></div></div><div class="wpb_column vc_column_container vc_col-sm-4 mpc-column"><div class="vc_column-inner "><div class="wpb_wrapper"><a href="/book-appointment/" target="" title="Book an Appointment" data-id="mpc_button-5571102b4cade5" class="mpc-button mpc-transition mpc-animation desktop mpc-inited" data-animation-in="transition.slideRightIn||1350||200||80" style="opacity: 1;"><div class="mpc-button__content mpc-effect-type--none mpc-effect-side--none"><span class="mpc-button__title mpc-transition">Book an Appointment</span></div><div class="mpc-button__background mpc-transition mpc-effect-type--slide mpc-effect-side--bottom"></div></a><a href="tel:4143272700" target="" title="Book an Appointment" data-id="mpc_button-97571102b4cb03a" class="mpc-button mpc-transition mpc-animation mobile mpc-inited" data-animation-in="transition.slideRightIn||1350||200||80" style="opacity: 1;"><div class="mpc-button__content mpc-effect-type--none mpc-effect-side--none"><span class="mpc-button__title mpc-transition">Book an Appointment</span></div><div class="mpc-button__background mpc-transition mpc-effect-type--slide mpc-effect-side--bottom"></div></a></div></div></div></div></div></div></div></div>-->

<?php get_footer(); ?>
