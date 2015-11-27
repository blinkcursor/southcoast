<?php
/**
 * The template to display page content
 *
 * @package  Hanna
 * @since  Hanna 1.0
 */

zilla_page_before(); ?>
<!--BEGIN .page-->
<article id="post-<?php the_ID(); ?>" <?php post_class() ?>>
<?php zilla_page_start(); ?>

	<?php
		// rewrite so that if there is a thumbnail, use that
		// if not, check for gallery & use that
		// i.e. gallery is only 'featured' if there is no featured image
		$gallery = get_post_meta( $post->ID, '_zilla_image_ids', true);
		$thumbnail = has_post_thumbnail();

		if ( $thumbnail ) {
			hanna_post_thumbnail($post->ID);
		}
		elseif ( $gallery != 'false' ) {
			echo hanna_post_gallery( $post->ID, 'full');
		}
		hanna_page_header();
		hanna_the_content();
	?>

<?php zilla_page_end(); ?>
<!--END .page-->
</article>
<?php zilla_page_after(); ?>