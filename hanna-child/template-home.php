<?php
/**
 * Template Name: Home
 * Description: A custom home page template
 *
 * @package  Hanna
 * @since  Hanna 1.0
 */
get_header(); ?>

	<!--BEGIN #primary .site-main-->
	<div id="primary" class="site-main clearfix" role="main">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php zilla_page_before(); ?>
		<!--BEGIN .page-->
		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix') ?>>
		<?php zilla_page_start(); ?>

			<?php
				hanna_post_thumbnail($post->ID);			

				hanna_page_header();

				hanna_the_content();
			?>

		<?php zilla_page_end(); ?>
		<!--END .page-->
		<div class="sidebar clearfix">
			<div class="sidebar-logo">
				<img src="<?php echo get_template_directory_uri(); ?>/images/southcoast-logo-large.jpg">
			</div>
			<div class="ultimas-entradas clearfix">
				<h3 class="center"><?php _e("Latest news & offers","hanna-child"); ?></h3>
				<?php

				// get stickies
				$sticky_ids = get_option( 'sticky_posts' );
				$stickies = get_posts( array('include' => $sticky_ids) );

				$args = array( 'numberposts' => 3, 'exclude' => $sticky_ids, 'post_status' => 'publish' );
				$non_stickies = get_posts( $args );
				$top_posts = array_merge( $stickies, $non_stickies );

				$top_posts = array_slice( $top_posts, 0, 3 );

				foreach ($top_posts as $post) :  setup_postdata($post);
					get_template_part( 'content-extract' );
				endforeach;
				wp_reset_postdata();
				 ?>
			</div>

			<div class="brand-logos">
				<img src="<?php echo get_template_directory_uri(); ?>/images/alder-logo.png" alt="Alder surf brand">
				<img src="<?php echo get_template_directory_uri(); ?>/images/nsp-surf.jpg" alt="NSP surf brand">
				<img src="<?php echo get_template_directory_uri(); ?>/images/manual-boards.jpg" alt="Manual surf boards">
				<img src="<?php echo get_template_directory_uri(); ?>/images/onda.jpg" alt="Onda surf brand">
				<a class="link-elpalmar" href="http://www.playadelpalmar.es"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-el-palmar.png"></a>
			</div>

			<div class="sidebar-forecasts">
				<h3><?php _e("Forecasts/conditions", "hanna-child") ?></h3>
				<div class="widget-forecasts widget-msw">
					<!-- This code is issued by Magicseaweed.com under license 1422526600_15743 for the website www.southcoast.es only subject to terms and conditions
					   and this message being kept intact as part of the code. If you are not the license holder add this content to your website by registering at 
					   Magicseaweed.com. All copyrights retained by Metcentral Ltd and any attempt to modify or redistribute this code is prohibited. 
					   Please contact us for more information if required. -->
					<script type="text/javascript" src="http://magicseaweed.com/syndicate/index.php?licenseKey=1422526600_15743"></script>
				</div>
				<div class="widget-forecasts widget-windguru">
					<div id="wg_target_div_38193_76640673"></div>
				</div>
				<div class="widget-forecasts widget-spotfav">
					<iframe src='http://www.spotfav.com/widget/spot-snapshot/el-palmar/b/61679ADE64EF6CCFD0DA' frameborder='0' scrolling='no' width='300px' height='300px'></iframe>
				</div>
			</div><!-- .sidebar-forecasts -->

		</div><!-- .sidebar -->

		</article>

		<?php 
		if ( function_exists("pll_get_post") )
			$eldorado = pll_get_post( 340 );
		?>
		<article id="post-el-dorado">
		<?php
		$the_post = get_post( $eldorado ); //the El Dorado page to merge with home page
		$the_title = $the_post->post_title;
		$the_excerpt = $the_post->post_excerpt;
		$the_content = apply_filters( 'the_content', $the_post->post_content);
		?>
			<div class="eldorado__title">
				<h1><?php echo $the_title; ?></h1>
			</div>
			<div class="eldorado__content">
				<?php echo $the_content; ?>
			</div>
		</article>

		<?php zilla_page_after(); ?>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>