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
				// rewrite so that if there is a thumbnail, use that
				// if not, check for gallery & use that
				// i.e. gallery is only 'featured' if there is no featured image
				$gallery = get_post_meta( $post->ID, '_zilla_image_ids', true);
				if ( $gallery != 'false' ) {
					echo hanna_post_gallery( $post->ID, 'full');
				}
				hanna_page_header();
				hanna_the_content();
			?>

		<?php zilla_page_end(); ?>
		<!--END .page-->
		</article>
		<?php zilla_page_after(); ?>

	<?php endwhile; ?>

	<!--END #primary .site-main-->
	</div>

<?php get_footer(); ?>