<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), '20150217' );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parent-style', '20150217' ) );
}


$content_width = 640;

/* ==========================================================================
   ONE-TIME PURGE MENU LOCATION OPTIONS
   ========================================================================== */
//add_action( 'after_setup_theme', 'reset_menu_locations');
//function reset_menu_locations() {
//	remove_theme_mod('nav_menu_locations');
//}

/*****************************************************************************
 * KILL WORDPRESS TOOLBAR 
 *****************************************************************************/
//add_filter('show_admin_bar', '__return_false');

/* HELPER FUNCTIONS
   ========================================================================== */
/* Handy for debugging */
function printr ( $object , $name = '' ) {
	print ( '\'' . $name . '\' : ' ) ;
	print ( '<pre>');
	if ( is_array ( $object ) ) {
		print_r ( $object ) ; 
	} else {
		var_dump ( $object ) ;
	}
	print ( '</pre><br>' ) ;
}

/* Replace theme set-up to exclude Portfolio elements
   (action added in parent functions.php)
   ========================================================================== */
function zilla_theme_setup() {

	// Load translation domain
	load_theme_textdomain( 'zilla', get_template_directory() . '/languages' );

	// Register WP 3.0+ Menus
	register_nav_menu( 'menu-sc', __('South Coast', 'hanna-child') );
	register_nav_menu( 'menu-k', __('Kontiki', 'hanna-child') );

	// Configure WP 2.9+ Thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 360, 9999 ); // Normal post thumbnails
	add_image_size( 'pricing__img', 396, 224, array('center', 'center') );
	// change large size to 1400px wide
	update_option('large_size_w', 1400);
	update_option('large_size_h', 9999);
	// change medium size to 760px wide
	update_option('medium_size_w', 760);
	update_option('medium_size_h', 999);


	// Add support for post formats
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'gallery', 'image', 'link', 'quote', 'video' ) );

	// Adds RSS feed links to <head> for posts and comments
	add_theme_support( 'automatic-feed-links' );

 	// Enable forms to use HTML5 markup
	add_theme_support( 'html5', array(
	    'search-form', 'comment-form'
	) );

	// Add support for Jetpack infinite scroll
	add_theme_support( 'infinite-scroll', array(
		'container'		 => 'primary',
		'footer' 		 => false,
		'type'           => 'scroll',
		'footer_widgets' => false
	) );
}

/**
 * Setup Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function hanna_child_theme_setup() {
    load_child_theme_textdomain( 'hanna-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'hanna_child_theme_setup' );



/* Replace base enqueuing to switch out google fonts
   ========================================================================== */
function zilla_enqueue_scripts() {
	/* Register our scripts --- */
//	wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js', '', '2.6.2', false);
	wp_register_script('validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', 'jquery', '1.9', true);
//	wp_register_script('superfish', get_template_directory_uri() . '/js/superfish.js', 'jquery', '1.7.4', true);
//	wp_register_script('zillaMobileMenu', get_template_directory_uri() . '/js/jquery.zillamobilemenu.min.js', 'jquery', '0.1', true);
//	wp_register_script('fitVids', get_template_directory_uri() . '/js/jquery.fitvids.js', 'jquery', '1.0', true);
//	wp_register_script('imagesLoaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', 'jquery', '3.1.8', true);
//	wp_register_script('isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array('jquery', 'imagesLoaded'), '2.0.1', true);
//	wp_register_script('cycle2', get_template_directory_uri() . '/js/jquery.cycle2.min.js', array('jquery'), '2.1.5', true);
//	wp_register_script('cycle2swipe', get_template_directory_uri() . '/js/jquery.cycle2.swipe.min.js', array('jquery','cycle2'), '20140128', true);	
	// use modified custom.js
//	wp_register_script('zilla-custom', home_url('wp-content/themes/hanna-child') . '/js/jquery.custom.js', array('jquery', 'superfish', 'zillaMobileMenu', 'fitVids', 'isotope', 'cycle2'), '', true);
//	wp_register_script('southcoast', home_url('wp-content/themes/hanna-child') . '/js/southcoast.js', array('jquery'), '20141119', true);

	wp_register_script('sc-concat', home_url('wp-content/themes/hanna-child') . '/js/js-concat.js', array('jquery'), '', true);

	/* Enqueue our scripts --- */
//	wp_enqueue_script('modernizr');
//	wp_enqueue_script('jquery');
//	wp_enqueue_script('zilla-custom');
//	wp_enqueue_script('southcoast');
	wp_enqueue_script('sc-concat');


	/* loads the javascript required for threaded comments --- */
	if( is_singular() && comments_open() && get_option( 'thread_comments') )
		wp_enqueue_script( 'comment-reply' );

	if( is_page_template('template-contact.php') )
		wp_enqueue_script('validation');

	/* Load our stylesheet --- */
	$zilla_options = get_option('zilla_framework_options');
	wp_enqueue_style( $zilla_options['theme_name'], get_stylesheet_uri() );
	wp_enqueue_style('google-fonts-hanna-theme', '//fonts.googleapis.com/css?family=Capriola:400|Pacifico:400');
	// Note: excluding Open Sans because that seems to be enqueued somewhere else already. TODO.
	wp_enqueue_style( 'dashicons' );





}

/* Tweak menus to add ?display=kontiki parameter to selected pages
   ========================================================================== */
add_filter( 'nav_menu_link_attributes', 'kontiki_menu_params', 10, 3);
function kontiki_menu_params( $atts, $item, $args) {
	$kontiki_pages = array(93,95,100,108, 725,726,732,734); // nav menu item ids
	if ( in_array($item->ID, $kontiki_pages) ) {
		$atts['href'] .= "?kontiki";
	}
	return $atts;
}


/* ==========================================================================
   SET-UP CPTS
   ========================================================================== */

if ( defined( 'AWESOME_CPT' ) ) {

/* Materials for rent
   ========================================================================== */

	$material = new Awesome_Post_Type( array(
	    'id'   => 'material',
	    'name' => array(
	        'singular' => 'material',
	        'plural'   => 'materiales'
	    ),
	    'args' => array(
	        'menu_icon'     => 'dashicons-universal-access-alt',
	        'menu_position' => 20,
	        'supports'		=> array( 'title', 'editor', 'thumbnail', 'page-attributes' )
	    )
	) );

	/* Set-up metaboxes
	   ========================================================================== */
	$material_prices = new Awesome_Meta_Box( array(
	    'id' => 'material_prices',
	    'title' => 'Precios de alquiler',
	    'post_types' => array( 'material' ),
	    'context' => 'normal',
	    'priority' => 'high',
	    'fields' => array(
	    	array(
	    		'id'	=>	'material_2h',
	    		'type'	=>	'text',
	    		'label'	=>	'Precio 2 horas (€)',
	    		),
	    	array(
	    		'id'	=>	'material_4h',
	    		'type'	=>	'text',
	    		'label'	=>	'Precio 4 horas (€)',
	    		),
	    	array(
	    		'id'	=>	'material_8h',
	    		'type'	=>	'text',
	    		'label'	=>	'Precio 8 horas (€)',
	    		),
	  	)
	) );

/* Cursos
   ========================================================================== */

	$curso = new Awesome_Post_Type( array(
	    'id'   => 'curso',
	    'name' => array(
	        'singular' => 'curso',
	        'plural'   => 'cursos'
	    ),
	    'args' => array(
	        'menu_icon'     => 'dashicons-universal-access-alt',
	        'menu_position' => 21,
	        'supports'		=> array( 'title', 'editor', 'thumbnail', 'page-attributes' )
	    )
	) );

	/* Set-up metaboxes
	   ========================================================================== */
	$curso_prices = new Awesome_Meta_Box( array(
	    'id' => 'curso_prices',
	    'title' => 'Precios de cursos',
	    'post_types' => array( 'curso' ),
	    'context' => 'normal',
	    'priority' => 'high',
	    'fields' => array(
	    	array(
	    		'id'	=>	'curso_grupo',
	    		'type'	=>	'textarea',
	    		'label'	=>	'Grupos (€)',
	    		),
	    	array(
	    		'id'	=>	'curso_individual',
	    		'type'	=>	'textarea',
	    		'label'	=>	'Individual (€)',
	    		)
	  	)
	) );

/* SurfCamps
   ========================================================================== */

	$surfcamp = new Awesome_Post_Type( array(
	    'id'   => 'surfcamp',
	    'name' => array(
	        'singular' => 'surfcamp',
	        'plural'   => 'surfcamps'
	    ),
	    'args' => array(
	        'menu_icon'     => 'dashicons-universal-access-alt',
	        'menu_position' => 21,
	        'supports'		=> array( 'title', 'editor', 'page-attributes' )
	    )
	) );

	/* Set-up metaboxes
	   ========================================================================== */
	$camp_prices = new Awesome_Meta_Box( array(
	    'id' => 'camp_prices',
	    'title' => 'Precios de camps',
	    'post_types' => array( 'surfcamp' ),
	    'context' => 'normal',
	    'priority' => 'high',
	    'fields' => array(
	    	array(
	    		'id'	=>	'curso_temp_baja',
	    		'type'	=>	'text',
	    		'label'	=>	'Temporada baja',
	    		),
	    	array(
	    		'id'	=>	'curso_temp_alta',
	    		'type'	=>	'text',
	    		'label'	=>	'Temporada alta',
	    		)
	  	)
	) );

/* BUNGALOWS
   ========================================================================== */

	$bungalow = new Awesome_Post_Type( array(
	    'id'   => 'bungalow',
	    'name' => array(
	        'singular' => 'bungalow',
	        'plural'   => 'bungalows'
	    ),
	    'args' => array(
	        'menu_icon'     => 'dashicons-universal-access-alt',
	        'menu_position' => 21,
	        'supports'		=> array( 'title', 'editor', 'page-attributes' )
	    )
	) );

	/* Set-up metaboxes
	   ========================================================================== */
	$bungalow_meta = new Awesome_Meta_Box( array(
	    'id' => 'bungalow_meta',
	    'title' => 'Detalles de bungalow',
	    'post_types' => array( 'bungalow' ),
	    'context' => 'normal',
	    'priority' => 'high',
	    'fields' => array(
	    	array(
	    		'id'	=>	'bungalow_capacity',
	    		'type'	=>	'text',
	    		'label'	=>	'Capacidad',
	    		),
	    	array(
	    		'id'	=>	'bungalow_temp_baja',
	    		'type'	=>	'textarea',
	    		'label'	=>	'Precio (temp. baja)',
	    		),
	    	array(
	    		'id'	=>	'bungalow_temp_med',
	    		'type'	=>	'textarea',
	    		'label'	=>	'Precio (temp. med)',
	    		),
	    	array(
	    		'id'	=>	'bungalow_temp_alta',
	    		'type'	=>	'textarea',
	    		'label'	=>	'Precio (temp. alta)',
	    		)
	  	)
	) );
} else {
    error_log('AWESOME_CPT is missing');
}

/* ==========================================================================
   CREATE SHORTCODES FOR INSERTING SPECIAL CONTENT INTO EDITABLE POSTS
   so as not to hard-code everything
   ========================================================================== */

/* SURF PAGE: add links to sub-pages as 'pricing tables'
   ========================================================================== */
add_shortcode( 'surf_subpages', 'surf_subpages_func' );
function surf_subpages_func( $atts ) {

	$post_alquiler = 7;
	$post_cursos = 11;
	$post_camps = 13;

	if ( function_exists(pll_get_post) ) {
		$post_alquiler = pll_get_post($post_alquiler); // will get ID of post in current lang
		$post_cursos = pll_get_post($post_cursos);
		$post_camps = pll_get_post($post_camps);
	}

	$link_alquiler = get_post($post_alquiler);
	$link_alquiler_thumb = get_the_post_thumbnail( $post_alquiler, 'pricing__img' );
	$link_alquiler_link = get_permalink( $post_alquiler );
	$link_alquiler_extracto = wpautop( get_excerpt_by_id( $post_alquiler ), true);

	$link_cursos = get_post($post_cursos);
	$link_cursos_thumb = get_the_post_thumbnail( $post_cursos, 'pricing__img' );
	$link_cursos_link = get_permalink( $post_cursos );
	$link_cursos_extracto = wpautop( get_excerpt_by_id( $post_cursos ), true);

	$link_camps = get_post($post_camps);
	$link_camps_thumb = get_the_post_thumbnail( $post_camps, 'pricing__img' );
	$link_camps_link = get_permalink( $post_camps );
	$link_camps_extracto = wpautop( get_excerpt_by_id( $post_camps ), true);

	$output = '
<ul class="pricingtables ancho">
  <li class="pricingtable link_alquiler">
    <header class="pricing__header">
' . $link_alquiler_thumb . '
      <h3><a href="' . $link_alquiler_link . '">' . $link_alquiler->post_title . '</a></h3>
    </header>
    <section class="pricing__body">
      ' . $link_alquiler_extracto . '
    </section>
    <ul class="pricing__footer">
      <li class="striped--primary"><a href="' . $link_alquiler_link . '">' . __( 'Details', 'hanna-child' ) . '</a></li>
    </ul>
  <!-- /li intentionally omitted -->
  <li class="pricingtable">
    <header class="pricing__header pricing__header--secondary">
' . $link_cursos_thumb . '
      <h3><a href="' . $link_cursos_link . '">' . $link_cursos->post_title . '</a></h3>
    </header>
    <section class="pricing__body pricing__body--secondary">
      ' . $link_cursos_extracto . '
    </section>
    <ul class="pricing__footer pricing__footer--secondary">
      <li class="striped--secondary"><a href="' . $link_cursos_link . '">' . __( 'Details', 'hanna-child' ) . '</a></li>
    </ul>
  <!-- /li intentionally omitted -->
  <li class="pricingtable">
    <header class="pricing__header">
'. $link_camps_thumb . '
      <h3><a href="' . $link_camps_link . '">' . $link_camps->post_title . '</a></h3>
    </header>
    <section class="pricing__body">
      ' . $link_camps_extracto . '
    </section>
    <ul class="pricing__footer">
      <li class="striped--primary"><a href="' . $link_camps_link . '">' . __( 'Details', 'hanna-child' ) . '</a></li>
    </ul>
  <!-- /li intentionally omitted -->
</ul>
	';
	return $output;
}

/* SURF-ALQUILER products for rent as pricing tables
   ========================================================================== */
function surf_alquiler_func( $atts ) {

	$args = array(
		'post_type'		=> 'material',
		'order_by'		=> 'menu_order',
		'order'			=>	'ASC'
		);
	$posts_array = get_posts( $args );

	$output = '<ul class="pricingtables clearfix ancho">';

	$odd = false;

	foreach ($posts_array as $post) {

		$odd = ($odd) ? false: true;
		$secondary_header = ($odd) ? "" : " pricing__header--secondary";
		$secondary_body = ($odd) ? "" : " pricing__body--secondary";
		$stripe = ($odd) ? "striped--primary" : "striped--secondary";

		$featured_image = get_the_post_thumbnail( $post->ID, 'pricing__img' );
		$meta_2h = get_post_meta( $post->ID, "material_2h", true );
		$meta_4h = get_post_meta( $post->ID, "material_4h", true );
		$meta_8h = get_post_meta( $post->ID, "material_8h", true );

		$output .= '
		  <li class="pricingtable">
		    <header class="pricing__header' . $secondary_header . '">
			    ' . $featured_image . '
			    <h3>' . $post->post_title . '</h3>
		    </header>
		    <section class="pricing__body' . $secondary_body . '">
		    	' . wpautop($post->post_content) . '
		    </section>
		    <ul class="pricing__footer">
		    	<li class="' . $stripe . '">
		    		<span class="meta__alquiler">' . __( "2 hours", "hanna-child" ) . '</span><br>
		    		&euro;' . $meta_2h . '
		    	</li>
		    	<li class="' . $stripe . '">
		    		<span class="meta__alquiler">' . __( "4 hours", "hanna-child" ) . '</span><br>
		    		&euro;' . $meta_4h . '
		    	</li>
		    	<li class="' . $stripe . '">
		    		<span class="meta__alquiler">' . __( "8 hours", "hanna-child" ) . '</span><br>
		    		&euro;' . $meta_8h . '
		    	</li>
		    </ul>
		  <!-- /li intentionally omitted -->';
	}

	$output .= '</ul>';

	return $output;
}
add_shortcode( 'surf_alquiler', 'surf_alquiler_func' );


/* SURF-CURSOS as pricing tables
   ========================================================================== */
function surf_cursos_func( $atts ) {

	$args = array(
		'post_type'		=> 'curso',
		'order_by'		=> 'menu_order',
		'order'			=>	'ASC'
		);
	$posts_array = get_posts( $args );

	$output = '<ul class="pricingtables clearfix ancho">';

	foreach ($posts_array as $post) {

		$featured_image = get_the_post_thumbnail( $post->ID, 'pricing__img' );
		$meta_grupo = get_post_meta( $post->ID, "curso_grupo", true );
		$meta_individual = get_post_meta( $post->ID, "curso_individual", true );

		$output .= '
		  <li class="pricingtable">
		    <header class="pricing__header">
			    ' . $featured_image . '
			    <h3>' . $post->post_title . '</h3>
		    </header>
		    <section class="pricing__body">
		    	' . wpautop($post->post_content) . '
		    </section>
		    <ul class="pricing__footer">
		    	<li class="striped--primary">
		    		<span class="curso__meta">' . __( "Groups 2+", "hanna-child" ) . '</span><br>
		    		&euro;' . $meta_grupo . '
		    	</li>
		    	<li class="striped--primary">
		    		<span class="curso__meta">' . __( "Individual", "hanna-child" ) . '</span><br>
		    		&euro;' . $meta_individual . '
		    	</li>
		    </ul>
		  <!-- /li intentionally omitted -->';
	}

	$output .= '</ul>';

	return $output;
}
add_shortcode( 'surf_cursos', 'surf_cursos_func' );


/* SURF-CAMPS as pricing tables
   ========================================================================== */
function surf_camps_func( $atts ) {

	$args = array(
		'post_type'		=> 'surfcamp',
		'order_by'		=> 'menu_order',
		'order'			=>	'ASC'
		);
	$posts_array = get_posts( $args );

	$output = '<ul class="pricingtables clearfix ancho">';

	foreach ($posts_array as $post) {

		$featured_image = get_the_post_thumbnail( $post->ID, 'pricing__img' );
		$meta_baja = get_post_meta( $post->ID, "curso_temp_baja", true );
		$meta_alta = get_post_meta( $post->ID, "curso_temp_alta", true );
		$output .= '
		  <li class="pricingtable">
		    <header class="pricing__header">
			    ' . $featured_image . '
			    <h3>' . $post->post_title . '</h3>
		    </header>
		    <section class="pricing__body">
		    	' . wpautop($post->post_content) . '
		    </section>
		    <ul class="pricing__footer">
		    	<li class="striped--primary">
		    		<span class="camp__meta">' . __( "Lo season", "hanna-child" ) . '</span><br>
		    		&euro;' . $meta_baja . '
		    	</li>
		    	<li class="striped--primary">
		    		<span class="camp__meta">' . __( "Hi season", "hanna-child" ) . '</span><br>
		    		&euro;' . $meta_alta . '
		    	</li>
		    </ul>
		  <!-- /li intentionally omitted -->';
	}

	$output .= '</ul>';

	return $output;
}
add_shortcode( 'surf_camps', 'surf_camps_func' );


/* BUNGALOWS as pricing tables
   ========================================================================== */
function bungalows_func( $atts ) {

	$args = array(
		'post_type'		=>	'bungalow',
		'order_by'		=>	'menu_order',
		'order'			=>	'ASC'
		);
	$posts_array = get_posts( $args );

	$post_camps = 13;
	if ( function_exists(pll_get_post) ) {
		$post_camps = pll_get_post($post_camps);
	}

	$output = '<ul class="pricingtables clearfix ancho">';

	foreach ($posts_array as $post) {
		$meta_capacity = get_post_meta( $post->ID, "bungalow_capacity", true );
		$meta_baja = get_post_meta( $post->ID, "bungalow_temp_baja", true );
		$meta_med = get_post_meta( $post->ID, "bungalow_temp_med", true );
		$meta_alta = get_post_meta( $post->ID, "bungalow_temp_alta", true );
		$class = strtolower( $post->post_title );
		$output .= '
		  <li class="pricingtable">
		    <header class="pricing__header bungalow-' . $class .'">
			    <h3>' . $post->post_title . '</h3>
		    </header>
		    <section class="pricing__body bungalow-' . $class . '">
		    	' . wpautop($post->post_content) . '
		    </section>
		    <ul class="pricing__footer bungalow-' . $class . '">
		    	<li class="striped--' . $class . '">
		    		<span class="dashicons dashicons-universal-access"></span>&nbsp;' . $meta_capacity . '
		    	</li>
		    	<li class="striped--' . $class . '">
		    		<span class="camp__meta">' . __( "Lo season", "hanna-child" ) . '</span><br>
		    		' . wpautop($meta_baja) . '
		    	</li>
		    	<li class="striped--' . $class . '">
		    		<span class="camp__meta">' . __( "Mid season", "hanna-child" ) . '</span><br>
		    		' . wpautop($meta_med) . '
		    	</li>
		    	<li class="striped--' . $class . '">
		    		<span class="camp__meta">' . __( "Hi season", "hanna-child" ) . '</span><br>
		    		' . wpautop($meta_alta) . '
		    	</li>
		    	<li class="striped--' . $class . '">
		    		<span class="camp__meta">' . __( "Surf Camp", "hanna-child" ) . '</span><br>
		    		<p><a href="' . get_permalink( $post_camps ) . '">' . __("—details—", "hanna-child") . '</a></p>
		    	</li>
		    </ul>
		  <!-- /li intentionally omitted -->';
	}

	$output .= '</ul>';

	return $output;
}
add_shortcode( 'bungalows', 'bungalows_func' );


/* ==========================================================================
   CREATE A SHORTCODE FOR THE GALLERY TO SIMPLIFY ADDING TO PAGES
   ========================================================================== */
function gallery_func( $atts ) {
	$the_ID = get_the_id();

	error_log("the_ID before = " . $the_ID);

	// Spanish is the canonical version of posts, get ID of Spanish version
	if ( function_exists( "pll_get_post" ) ) {
		$the_ID = pll_get_post( $the_ID, 'es' );
	}

	error_log("the_ID after = " . $the_ID);


	$output = hanna_post_gallery($the_ID, 'large');
	return $output;
}
add_shortcode( 'gallery', 'gallery_func' );

/* ==========================================================================
   CREATE A SHORTCODE FOR PANELS FOR BLOCKY COLOURED CONTENT
   ========================================================================== */
function panel_func( $atts, $content ) {
	if ( '' != $atts['color'] ) {
		$class = "ancho panel panel--" . $atts['color'];
	} else {
		$class = "ancho panel";
	}
	if ( '' != $atts['nombre'] ) {
		$class .= ' ' . $atts['nombre'];
	}
	if ( 'margen' == $atts['tipo'] ) {
		$class .= ' panel--' . $atts['tipo'];
	}

	$output = '<div class="' . $class . '">' . $content . '</div>';
	return $output;
}
add_shortcode( 'panel', 'panel_func' );


/* ==========================================================================
   OVERRIDE template tag to use 'large' thumbnail size for featured images
   ========================================================================== */
function hanna_post_thumbnail($postid) {
	if ( post_password_required() || ! has_post_thumbnail() ) {
		return;
	}

	$format = get_post_format();
	if( $format == 'link' ) {
		$link_to = get_post_meta($postid, '_zilla_link_url', true);
	} else {
		$link_to = get_the_permalink($postid);
	}
	?>

	<div class="entry-thumbnail">
	<?php if ( is_singular() ) {
		the_post_thumbnail('large');
	} else { ?>
		<a href="<?php echo esc_url($link_to); ?>">
			<?php the_post_thumbnail(); ?>
		</a>
	<?php } ?>
	</div>
<?php }



/* ==========================================================================
   CREATE SHORTCODE TO WRAP CONTENT IN DIV.ancho TO KEEP FULL-WIDTH
   ========================================================================== */
function ancho_func( $atts, $content ) {
	$output = '<div class="ancho">' . $content . '</div>';
	return $output;
}
add_shortcode( 'ancho', 'ancho_func' );


/* ==========================================================================
   CREATE SHORTCODE TO CREATE TITLE BLOCK WHERE TITLE NOT USED
   ========================================================================== */
function bloque_func( $atts, $content ) {
	$output = '<div class="bloque">' . $content . '</div>';
	return $output;
}
add_shortcode( 'bloque', 'bloque_func' );


/* ==========================================================================
   CREATE SHORTCODE TO ADD SOCIAL LINKS
   ========================================================================== */
function social_links_func( $atts ) {
	$theme_options = get_theme_mod('zilla_theme_options');
	$output = '
			<div class="social--body">
				<h3>' . __("Keep in touch via social networks", "hanna-child") . '</h3>
				<a href="https://www.facebook.com/pages/South-Coast-Surf-School/404300060211">
					<svg width="50px" height="50px" viewBox="0 0 50 50" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
					    <title>Facebook</title>
					    <description>Created with Sketch (http://www.bohemiancoding.com/sketch)</description>
					    <defs></defs>
					    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
					        <g id="Facebook" sketch:type="MSArtboardGroup" fill="#000000">
					            <path d="M25,50 C38.8071194,50 50,38.8071194 50,25 C50,11.1928806 38.8071194,0 25,0 C11.1928806,0 0,11.1928806 0,25 C0,38.8071194 11.1928806,50 25,50 Z M25,47 C37.1502651,47 47,37.1502651 47,25 C47,12.8497349 37.1502651,3 25,3 C12.8497349,3 3,12.8497349 3,25 C3,37.1502651 12.8497349,47 25,47 Z M26.8145197,36 L26.8145197,24.998712 L30.0687449,24.998712 L30.5,21.2076072 L26.8145197,21.2076072 L26.8200486,19.3101227 C26.8200486,18.3213442 26.9207209,17.7915341 28.4425538,17.7915341 L30.4769629,17.7915341 L30.4769629,14 L27.2222769,14 C23.3128757,14 21.9368678,15.8390937 21.9368678,18.9318709 L21.9368678,21.2080366 L19.5,21.2080366 L19.5,24.9991413 L21.9368678,24.9991413 L21.9368678,36 L26.8145197,36 Z M26.8145197,36" id="Oval-1" sketch:type="MSShapeGroup"></path>
					        </g>
					    </g>
					</svg>
				</a>
				<a href="http://twitter.com/southcoastcadiz">
					<svg width="50px" height="50px" viewBox="0 0 50 50" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
					    <title>Twitter</title>
					    <description>Created with Sketch (http://www.bohemiancoding.com/sketch)</description>
					    <defs></defs>
					    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
					        <g id="Twitter" sketch:type="MSArtboardGroup" fill="#000000">
					            <path d="M25,50 C38.8071194,50 50,38.8071194 50,25 C50,11.1928806 38.8071194,0 25,0 C11.1928806,0 0,11.1928806 0,25 C0,38.8071194 11.1928806,50 25,50 Z M25,47 C37.1502651,47 47,37.1502651 47,25 C47,12.8497349 37.1502651,3 25,3 C12.8497349,3 3,12.8497349 3,25 C3,37.1502651 12.8497349,47 25,47 Z M24.6822554,20.5542975 L24.729944,21.3761011 L23.9351333,21.2754721 C21.0420225,20.8897275 18.5145246,19.5815504 16.3685358,17.3844837 L15.3193857,16.2943361 L15.0491501,17.0993681 C14.4768864,18.8939188 14.8424993,20.7890985 16.0347153,22.0637326 C16.6705638,22.7681357 16.5274979,22.8687647 15.4306592,22.4494772 C15.0491501,22.3153051 14.7153296,22.2146761 14.6835371,22.2649907 C14.5722637,22.3823912 14.9537728,23.9085978 15.2558008,24.5123719 C15.6691024,25.350947 16.5116017,26.1727505 17.433582,26.6591241 L18.2124965,27.0448686 L17.2905161,27.0616401 C16.4003282,27.0616401 16.3685358,27.0784116 16.4639131,27.4306131 C16.7818374,28.5207608 18.0376382,29.6779944 19.436505,30.1811394 L20.4220701,30.533341 L19.5636746,31.070029 C18.2919776,31.8415181 16.7977335,32.2775772 15.3034895,32.3111202 C14.5881599,32.3278916 14,32.3949776 14,32.4452922 C14,32.6130071 15.939338,33.5522113 17.0679692,33.9211843 C20.4538626,35.0113319 24.4756046,34.5417298 27.4958851,32.6800932 C29.6418739,31.3551445 31.7878628,28.7220188 32.7893242,26.1727505 C33.3297954,24.8142589 33.8702667,22.3320767 33.8702667,21.1413 C33.8702667,20.369811 33.9179553,20.269182 34.8081432,19.3467494 C35.3327183,18.8100613 35.8255009,18.2230588 35.9208782,18.0553437 C36.0798403,17.7366852 36.0639442,17.7366852 35.2532373,18.0218007 C33.9020591,18.5249458 33.7113045,18.4578598 34.3789455,17.7031422 C34.8717281,17.1664541 35.459888,16.1937071 35.459888,15.9085915 C35.459888,15.858277 35.2214448,15.9421346 34.9512092,16.093078 C34.6650773,16.2607931 34.0292288,16.5123656 33.5523424,16.6633091 L32.6939469,16.9484246 L31.9150324,16.394965 C31.4858346,16.093078 30.8817786,15.757648 30.5638543,15.657019 C29.7531474,15.422218 28.5132428,15.455761 27.7820169,15.724105 C25.7949903,16.4788226 24.5391894,18.4243168 24.6822554,20.5542975 C24.6822554,20.5542975 24.5391894,18.4243168 24.6822554,20.5542975 Z M24.6822554,20.5542975" id="Oval-1" sketch:type="MSShapeGroup"></path>
					        </g>
					    </g>
					</svg>
				</a>
				<a href="http://instagram.com/south_coast_surf_school/">
					<svg width="50px" height="50px" viewBox="0 0 50 50" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
					    <title>Instagram</title>
					    <description>Created with Sketch (http://www.bohemiancoding.com/sketch)</description>
					    <defs></defs>
					    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
					        <g id="Intsagram" sketch:type="MSArtboardGroup" fill="#000000">
					            <path d="M25,0 C11.1928806,0 0,11.1928806 0,25 C0,38.8071194 11.1928806,50 25,50 C38.8071194,50 50,38.8071194 50,25 C50,11.1928806 38.8071194,0 25,0 Z M25,3 C12.8497349,3 3,12.8497349 3,25 C3,37.1502651 12.8497349,47 25,47 C37.1502651,47 47,37.1502651 47,25 C47,12.8497349 37.1502651,3 25,3 Z M35.9513128,34.5096659 C35.9701595,34.4075385 35.9839804,34.3037693 36,34.2013135 L36,15.7986865 C35.9846086,15.6978726 35.9714159,15.5967304 35.9525693,15.496245 C35.7600194,14.4654483 34.9467868,13.6655054 33.9482288,13.5226585 C33.9067662,13.517076 33.8662459,13.5075528 33.8254116,13.5 L16.1745884,13.5 C16.0681049,13.5200314 15.9609932,13.5351371 15.8560802,13.5600942 C14.8813947,13.7922616 14.1601965,14.6128926 14.0213595,15.6453312 C14.0157055,15.6883495 14.0072245,15.7310394 14,15.7740577 L14,34.2269275 C14.0201031,34.3438321 14.0361227,34.4617219 14.0612516,34.5779697 C14.2767315,35.5742861 15.0902783,36.3466448 16.0580534,36.4766848 C16.1048559,36.4825957 16.1519725,36.4921188 16.198775,36.5 L33.801225,36.5 C33.9155613,36.4796402 34.0302117,36.4628926 34.1432916,36.4372787 C35.0416482,36.2379497 35.775725,35.454426 35.9513128,34.5096659 Z M16.380331,33.0989292 C16.380331,33.5885494 16.7858479,34.0095374 17.254187,34.0095374 C22.4169106,34.0098658 27.5793201,34.0098658 32.7420437,34.0095374 C33.2147803,34.0095374 33.6180985,33.5892062 33.6180985,33.0959737 C33.6184126,29.6962164 33.6180985,26.2967875 33.6180985,22.8973587 L33.6180985,22.8267561 L31.5179543,22.8267561 C31.8144748,23.81749 31.9055669,24.8252998 31.7893459,25.8524843 C31.6724968,26.8799971 31.3558732,27.8362507 30.8401034,28.7192747 C30.3240195,29.6032838 29.6549637,30.3355797 28.8357629,30.9184609 C26.7123745,32.4303398 23.9167892,32.5633352 21.6636731,31.2412621 C20.5247077,30.5736579 19.6304345,29.6426899 19.0069247,28.4431039 C18.0768429,26.653084 17.9282685,24.7744003 18.4738788,22.8251142 C17.7771813,22.825771 17.0833107,22.825771 16.3800168,22.825771 L16.3800168,22.8878355 C16.3800168,26.2915334 16.3797027,29.6952313 16.380331,33.0989292 Z M24.897757,29.6581239 C27.3886549,29.7139492 29.403361,27.6333095 29.4558175,25.1027841 C29.5095304,22.4931182 27.4960808,20.3376071 25.0001571,20.339249 C22.5601451,20.3376071 20.5765359,22.3900057 20.5422979,24.9293975 C20.5071175,27.5370931 22.5039192,29.604269 24.897757,29.6581239 Z M33.6177844,18.481582 C33.6180985,17.7555254 33.6180985,17.0291405 33.6177844,16.303084 C33.6177844,15.7822673 33.2235754,15.3678469 32.7260241,15.3675186 C32.03341,15.3671902 31.3407958,15.3668618 30.6478676,15.3675186 C30.1515727,15.3681753 29.7561073,15.7835808 29.7557932,16.3043975 C29.7554791,17.0242147 29.7535944,17.744032 29.7583061,18.4641776 C29.7589343,18.5715591 29.7784092,18.6832096 29.8110767,18.7850086 C29.9354645,19.1682324 30.2712489,19.4033552 30.6824198,19.4053255 C31.0166336,19.4059823 31.3508474,19.4049971 31.6853753,19.4049971 C32.0472308,19.4007282 32.4103428,19.4079526 32.7725125,19.3987579 C33.2383386,19.3866077 33.6177844,18.9692319 33.6177844,18.481582 Z M33.6177844,18.481582" id="Oval-1" sketch:type="MSShapeGroup"></path>
					        </g>
					    </g>
					</svg>
				</a>
			</div>';
	return $output;
}
add_shortcode( 'social_links', 'social_links_func' );

/* ==========================================================================
   Make pricing_img sizes selectable in admin screens
   ========================================================================== */
add_filter( 'image_size_names_choose', 'sc_custom_sizes' );
function sc_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'pricing__img' => __( 'South Coast cuadros' ),
    ) );
}

/* ==========================================================================
   CHANGES TO WPAUTOP filter
   ========================================================================== */
remove_filter( 'the_content', 'wpautop' ); //note, can still call original wpautop directly
add_filter( 'the_content', 'wpautop_lede', 10, 2); //leave with default priority of 10 to run before shortcodes still
function wpautop_lede($pee, $br = true) {
	$lede = true;
	$pre_tags = array();

	if ( trim($pee) === '' )
		return '';

	$pee = $pee . "\n"; // just to make things a little easier, pad the end

	if ( strpos($pee, '<pre') !== false ) {
		$pee_parts = explode( '</pre>', $pee );
		$last_pee = array_pop($pee_parts);
		$pee = '';
		$i = 0;

		foreach ( $pee_parts as $pee_part ) {
			$start = strpos($pee_part, '<pre');

			// Malformed html?
			if ( $start === false ) {
				$pee .= $pee_part;
				continue;
			}

			$name = "<pre wp-pre-tag-$i></pre>";
			$pre_tags[$name] = substr( $pee_part, $start ) . '</pre>';

			$pee .= substr( $pee_part, 0, $start ) . $name;
			$i++;
		}

		$pee .= $last_pee;
	}

	$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
	// Space things out a little
	$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|img|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|details|menu|summary)';
	$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
	$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
	$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines

	if ( strpos( $pee, '<option' ) !== false ) {
		// no P/BR around option
		$pee = preg_replace( '|\s*<option|', '<option', $pee );
		$pee = preg_replace( '|</option>\s*|', '</option>', $pee );
	}

	if ( strpos( $pee, '</object>' ) !== false ) {
		// no P/BR around param and embed
		$pee = preg_replace( '|(<object[^>]*>)\s*|', '$1', $pee );
		$pee = preg_replace( '|\s*</object>|', '</object>', $pee );
		$pee = preg_replace( '%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee );
	}

	if ( strpos( $pee, '<source' ) !== false || strpos( $pee, '<track' ) !== false ) {
		// no P/BR around source and track
		$pee = preg_replace( '%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee );
		$pee = preg_replace( '%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee );
		$pee = preg_replace( '%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee );
	}

	$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
	// make paragraphs, including one at the end
	$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
	$pee = '';
	foreach ( $pees as $tinkle ) {
		$class = ( $lede ) ? ' class="lede"' : '';
		$pee .= '<p' . $class . '>' . trim($tinkle, "\n") . "</p>\n";
		$lede = false;
	}

	$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
	$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
	$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
	$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
	$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

	if ( $br ) {
		$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);
		$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
		$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
	}

	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
	$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
	$pee = preg_replace( "|\n</p>$|", '</p>', $pee );

	$pee = preg_replace('/<p><img|<p class="lede"><img/', '<img', $pee );

	if ( !empty($pre_tags) )
		$pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

	return $pee;
}


/* ==========================================================================
   ADD EXCERPTS TO PAGES NOT JUST POSTS
   ========================================================================== */
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

/* ==========================================================================
   RETRIEVE POST EXCERPT OUTSIDE THE LOOP
   ========================================================================== */
function get_excerpt_by_id($post_id){
    $the_post = get_post($post_id);
    $the_excerpt = $the_post->post_excerpt;
    if ( !$the_excerpt ) {
    	$the_excerpt = "sustituir este texto editando el extracto";
    }
    return $the_excerpt;
}

/* ==========================================================================
   OVERRIDE hanna_page_header to add test for front page
   ========================================================================== */
function hanna_page_header() {  ?>
	<header class="entry-header">
	<?php
	if ( is_page('inicio') || is_page('home') || is_page('startseit') ) {
		$title = get_post_meta( get_the_ID(), "inicio-titulo", true );
		echo $title;
	}
	else { ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	<?php } ?>
	</header>
<?php }

/* ==========================================================================
   OVERRIDE hanna_the_content() for showing latest posts on home page
   ========================================================================== */
function hanna_the_content( $excerpt = false ) {
	if( !$excerpt && is_singular() ) {
		if( get_the_content() ) { ?>
		<!--BEGIN .entry-content -->
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages: ', 'hanna-child').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php if( is_singular('post') ) { ?>
				<hr class="hr-center">
			<?php } ?>
		<!--END .entry-content -->
		</div>
		<?php } ?>
	<?php } else { ?>

		<!--BEGIN .entry-summary -->
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		<!--END .entry-summary -->
		</div>

	<?php } ?>
<?php }

