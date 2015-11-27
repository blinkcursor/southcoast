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

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php zilla_page_before(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<?php zilla_page_start(); ?>

			<?php
				hanna_post_thumbnail($post->ID);
				hanna_page_header();
			?>

			<div class="sc-como-llegar clearfix">
				<?php $map = get_post_meta( $post->ID, '_zilla_contact_map_embed', true ); ?>
				<?php if( $map ){ ?><div class="contact-map"><div class="cover-map"></div><?php echo html_entity_decode( $map ); ?></div><?php } ?>
				<div class="sc-como-llegar-container">
				<?php the_content(); ?>
				</div>
			</div>

		<?php zilla_page_end(); ?>
		<!--END .page-->
		</article>
		<?php zilla_page_after(); ?>

		<?php endwhile; endif; ?>

	<!--END #primary .site-main-->
	</div>

<?php get_footer(); ?>