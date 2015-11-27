<?php
/**
 * The main template file
 *
 * @package Hanna
 * @since Hanna 1.0
 */

get_header(); ?>
	<!--BEGIN #primary .site-main-->
	<div id="primary" class="site-main isotope-container" role="main">

	<?php if( have_posts() ) :

		while (have_posts()) : the_post();

			get_template_part('content', get_post_format() );

		endwhile;

		hanna_paging_nav();

	else :

		get_template_part('content', 'none');

	endif; ?>
	<!--END #primary .site-main-->
	</div>

<?php get_footer(); ?>