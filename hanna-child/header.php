<?php
/**
 * The Header template for our theme
 *
 * @package Hanna
 * @since Hanna 1.0
 */

$theme_options = get_theme_mod('zilla_theme_options');

$class = '';
$kontiki = false;
if( isset( $_GET["kontiki"] ) || is_page( 'kontiki-bungalows-el-palmar' ) || is_page( 'kontiki-bungalows-el-palmar-en' ) || is_page( 'kontiki-bungalows-el-palmar-de' ) ) {
	$kontiki = true;
	$class = 'kontiki';
}
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>

	<!-- Meta Tags -->
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<?php zilla_meta_head(); ?>
	<!-- Title -->
	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>

<!-- END head -->
</head>

<!-- BEGIN body -->
<body <?php body_class( $class ); ?>>
<?php zilla_body_start(); ?>

	<!-- BEGIN #container -->
	<div id="container" class="hfeed site">

		<?php zilla_header_before(); ?>
		<!-- BEGIN #masthead .site-header -->
		<header id="masthead" class="site-header" role="banner">
		<?php zilla_header_start(); ?>

			<div class="header-wrap">
				<!-- BEGIN #logo .site-logo-->
				<div id="logo" class="site-logo">
					<?php if ( $kontiki ) { ?>
						<a href="<?php echo home_url(); ?>/kontiki-bungalows-el-palmar/"><img src="<?php echo get_template_directory_uri(); ?>/images/kontiki-logo-107.png" alt="Kontiki Surf Bungalows"/></a>
						<div class="logo-in-text">Kontiki Bungalows<br>El Palmar</div>
					<?php } else { ?>
						<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/southcoast-logo.png" alt="Kontiki Surf Bungalows"/></a>
						<div class="logo-in-text"><?php _e("South Coast<br>Surf School", "hanna-child"); ?></div>
					<?php } ?>
				<!-- END #logo .site-logo-->
				</div>

				<?php zilla_nav_before(); ?>
				<!-- BEGIN #primary-navigation -->
				<nav id="primary-navigation" class="site-navigation" role="navigation">
				<?php
				// What page are we on?
				if ( !$kontiki && has_nav_menu( 'menu-sc' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'menu-sc',
						'menu_id' => 'primary-menu',
						'menu_class' => 'primary-menu zilla-sf-menu',
						'container' => false
					) );					
				} elseif ( $kontiki && has_nav_menu( 'menu-k' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'menu-k',
						'menu_id' => 'primary-menu',
						'menu_class' => 'primary-menu zilla-sf-menu',
						'container' => false
					) );
				} ?>
				</nav>
				<?php zilla_nav_after(); ?>
			</div>

		<?php zilla_header_end(); ?>
		<!--END #masthead .site-header-->
		</header>
		<?php zilla_header_after(); ?>

		<!--BEGIN #content .site-content-->
		<div id="content" class="site-content">
		<?php zilla_content_start(); ?>