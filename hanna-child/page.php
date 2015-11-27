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

			get_template_part('content', 'page');

			if ( comments_open() || get_comments_number() ) {
				comments_template('', true);
			}

		endwhile;
	?>

	<!--END #primary .site-main-->
	</div>

<?php get_footer(); ?>