<?php
/**
 * Specifically for showing latest 3 blog posts on front page
 * 
 *
 * @package Hanna
 * @since Hanna 1.0
 */

$class = ( ! get_post_format() && 'on' == get_post_meta( $post->ID, '_zilla_image_opacity', true ) ) ? 'lower-opacity' : '';

if ( is_sticky() ) {
	$class .= ' sticky';
}

zilla_post_before(); ?>
<!--BEGIN .post -->
<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
<?php zilla_post_start(); ?>

	<?php
	$format = get_post_format();
	if( in_array($format, array('link', 'quote') ) ) {
		hanna_link_quote($post->ID);
	} elseif( $format == 'image' ) {
		hanna_post_thumbnail($post->ID);
	}
	?>

	<!--BEGIN .entry-header-->
	<header class="entry-header">
		<?php if( $format == '' ) {
			hanna_post_thumbnail($post->ID);
		} ?>
		<div class="entry-title-wrapper">
			<?php
				hanna_post_title();
			?>
		</div>
	<!--END .entry-header-->
	</header>

	<?php
		if ($format == 'gallery') {
			echo hanna_post_gallery( $post->ID );
		} else {
			hanna_the_content( true ); // this
			hanna_post_footer();
		}
	?>

<?php zilla_post_end(); ?>
<!--END .post-->
</article>
<?php zilla_post_after(); ?>