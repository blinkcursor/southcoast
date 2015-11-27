<?php
/**
 * Template Name: About
 *
 * A custom About page template
 *
 * @package Hanna
 * @since Hanna 1.0
 */

get_header(); ?>

	<!--BEGIN #primary .site-main-->
	<div id="primary" class="site-main full-width" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php zilla_page_before(); ?>
		<!--BEGIN .page-->
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<?php zilla_page_start(); ?>

			<?php
				hanna_post_thumbnail($post->ID);
				hanna_page_header();
				hanna_the_content();
			?>

			<div class="entry-profiles clearfix">

				<div class="entry-profiles-container">
				<?php
				for( $i = 1; $i <= 12; $i++ ) {

					$image = get_post_meta( $post->ID, '_zilla_about_image_'. $i, true );
					$name = get_post_meta( $post->ID, '_zilla_about_name_'. $i, true );
					$title = get_post_meta( $post->ID, '_zilla_about_title_'. $i, true );
					$bio = get_post_meta( $post->ID, '_zilla_about_bio_'. $i, true );

					if($image && $name) { ?>

						<div class="profile">
							<img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" class="profile-image">
							<h3 class="profile-name"><?php echo $name; ?></h3>
							<h6 class="profile-title"><?php echo $title; ?></h6>
							<p class="profile-bio"><?php echo $bio; ?></p>
						</div>

					<?php }
				}
				?>
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
