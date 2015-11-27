<?php
/**
 * The template for displaying default layout pages
 *
 * @package Hanna
 * @since Hanna 1.0
 */
get_header(); ?>

	<!--BEGIN #primary .site-main-->
	<div id="primary" class="site-main" role="main">
	<?php
		// the loop
		while (have_posts()) : the_post();

		zilla_page_before(); ?>
		<!--BEGIN .page-->
		<article id="post-<?php the_ID(); ?>" <?php post_class() ?>>
		<?php zilla_page_start(); ?>

			<?php
				hanna_page_header();
				hanna_the_content();
			?>

		<?php zilla_page_end(); ?>
		<!--END .page-->
		</article>
		<?php zilla_page_after();

		endwhile;
	?>

	<!--END #primary .site-main-->
	</div>

<?php get_footer(); ?>