<?php
/**
 * The template for showing our footer
 *
 * @package Hanna
 * @since Hanna 1.0
 */

$theme_options = get_theme_mod('zilla_theme_options');
?>

		<?php zilla_content_end(); ?>
		<!-- END #content .site-content-->
		</div>

		<?php if ( !(isset( $_GET["kontiki"] ) || is_page('kontiki-bungalows-el-palmar')) ) { ?>

			<div class="ancho footer__porque">
				<h3 id="js-porque"><?php _e("Why choose South Coast", "hanna-child") ?></h3>
				<div class="footer__porque-text clearfix">
					<ul class="col-half">
						<li><?php _e("Because you’ll have such a great time learning to surf with us.", "hanna-child") ?></li>
						<li><?php _e("Because for us the human touch is so important.", "hanna-child") ?></li>
						<li><?php _e("Por el ambiente sencillo y cercano de nuestra escuela.", "hanna-child") ?></li>
						<li><?php _e("Because we are flexible and adapt to your needs.", "hanna-child") ?></li>
					</ul>
					<ul class="col-half">
						<li><?php _e("Because you will benefit from the years of experience of our team.", "hanna-child") ?></li>
						<li><?php _e("Because we comply with all of the legal and safety requirements to teach the sport.", "hanna-child") ?></li>
						<li><?php _e("And because we will share our passion for nature and respect of the sea.", "hanna-child") ?></li>
					</ul>
				</div>
			</div>
		<?php } ?>

		<?php get_sidebar('footer'); ?>

		<?php zilla_footer_before(); ?>
		<!-- BEGIN #footer -->
		<footer id="footer" class="site-footer" role="contentinfo">
		<?php zilla_footer_start(); ?>

			<div class="social">
	        <?php
	        if( isset($theme_options['facebook_url']) && $theme_options['facebook_url'] ){ echo '<a href="'. filter_var( $theme_options['facebook_url'], FILTER_SANITIZE_URL ) .'" class="facebook" title="Follow on Facebook">'; include( get_template_directory() .'/images/Facebook.svg' ); echo '</a>'; }
	        if( isset($theme_options['twitter_url']) && $theme_options['twitter_url'] ){ echo '<a href="'. filter_var( $theme_options['twitter_url'], FILTER_SANITIZE_URL ) .'" class="twitter" title="Follow on Twitter">'; include( get_template_directory() .'/images/Twitter.svg' ); echo '</a>'; }
	        if( isset($theme_options['pinterest_url']) && $theme_options['pinterest_url'] ){ echo '<a href="'. filter_var( $theme_options['pinterest_url'], FILTER_SANITIZE_URL ) .'" class="pinterest" title="Follow on Pinterest">'; include( get_template_directory() .'/images/Pinterest.svg' ); echo '</a>'; }
	        if( isset($theme_options['instagram_url']) && $theme_options['instagram_url'] ){ echo '<a href="'. filter_var( $theme_options['instagram_url'], FILTER_SANITIZE_URL ) .'" class="instagram" title="Follow on Instagram">'; include( get_template_directory() .'/images/Instagram.svg' ); echo '</a>'; }
	        ?>
			</div>

			<p><span class="copyright">&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>.</span></p>

	        <?php if ( is_user_logged_in() ) { ?>
	        	<p><a href="<?php echo wp_logout_url(); ?>">Log Out</a></p>
	        <?php } else { ?>
	            <p><a href="<?php echo wp_login_url(); ?>">Log In</a></p>
	        <?php } ?>

		<?php zilla_footer_end(); ?>
		<!-- END #footer -->
		</footer>
		<?php zilla_footer_after(); ?>

	<!-- END #container .hfeed .site -->
	</div>

	<!-- Theme Hook -->
	<?php wp_footer(); ?>
	<?php zilla_body_end(); ?>

<!--END body-->

<?php if ( is_front_page() ) { ?>
<script src="http://widget.windguru.cz/js/wg_widget.php" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
//<![CDATA[
WgWidget({
s: 38193, odh:8, doh:20, wj:'kmh', tj:'c', waj:'m', fhours:48, lng:'es',
params: ['HTSGW','WINDSPD','SMER','TMPE','TCDC','APCPs'],
first_row:true,
spotname:true,
first_row_minfo:false,
last_row:true,
lat_lon:false,
tz:false,
sun:true,
link_archive:false,
link_new_window:true
},
'wg_target_div_38193_76640673'
);
//]]>
</script>
<?php } ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59839747-1', 'auto');
  ga('send', 'pageview');
</script>

</body>
<!--END html-->
</html>