<?php
/**
 * The template to display post content for gallery post format
 *
 * @package Hanna
 * @since 1.0
 */

zilla_post_before(); ?>
<!--BEGIN .post -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php zilla_post_start(); ?>

	<?php if( is_singular('post') ) {
		echo hanna_post_gallery($post->ID, 'full');
	} else {
		echo hanna_post_gallery($post->ID, 'portfolio-featured-image');
	} ?>

	<!--BEGIN .entry-header-->
	<header class="entry-header">
		<?php
			hanna_post_title();
			hanna_post_meta_header();
		?>
	<!--END .entry-header-->
	</header>

	<?php
		hanna_the_content();
		hanna_post_footer();
	?>

<?php zilla_post_end(); ?>
<!--END .post-->
</article>
<?php zilla_post_after(); ?>