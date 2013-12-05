<?php
/**
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    BoldlyGoBlue
 * @version    0.1.1
 * @author     Jesse Smith
 * @copyright  Copyright (c) 2013 by Jesse Smith for Mardesco
 * @link       http://mardesco.com/themes/boldly-go-blue/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @notes      Boldly Go Blue is built on the Stargazer theme framework by Justin Tadlock.
 */

/* Get the template directory and make sure it has a trailing slash. */
$stargazer_dir = trailingslashit( get_template_directory() );

/* Load the Hybrid Core framework and launch it. */
require_once( $stargazer_dir . 'library/hybrid.php' );
new Hybrid();

/* Load theme-specific files. */
require_once( $stargazer_dir . 'inc/stargazer.php'             );
require_once( $stargazer_dir . 'inc/custom-background.php'     );
require_once( $stargazer_dir . 'inc/custom-header.php'         );
require_once( $stargazer_dir . 'inc/custom-colors.php'         );
require_once( $stargazer_dir . 'inc/customize.php'             );

/* Set up the theme early. */
add_action( 'after_setup_theme', 'stargazer_theme_setup', 5 );

/**
 * The theme setup function.  This function sets up support for various WordPress and framework functionality.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function stargazer_theme_setup() {

	/* Load widgets. */
	add_theme_support( 'hybrid-core-widgets' );

	/* Theme layouts. */
	add_theme_support( 
		'theme-layouts', 
		array(
			'1c'        => __( '1 Column Wide',                'stargazer' ),
			'1c-narrow' => __( '1 Column Narrow',              'stargazer' ),
			'2c-l'      => __( '2 Columns: Content / Sidebar', 'stargazer' ),
			'2c-r'      => __( '2 Columns: Sidebar / Content', 'stargazer' )
		),
		array( 'default' => is_rtl() ? '2c-r' :'2c-l' ) 
	);

	/* Load stylesheets. */
	add_theme_support(
		'hybrid-core-styles',
		array( 'stargazer-fonts', 'one-five', 'gallery', 'stargazer-mediaelement', 'parent', 'style' )
	);

	/* Enable custom template hierarchy. */
	add_theme_support( 'hybrid-core-template-hierarchy' );

	/* The best thumbnail/image script ever. */
	add_theme_support( 'get-the-image' );

	/* Breadcrumbs. Yay! */
	add_theme_support( 'breadcrumb-trail' );

	/* Pagination. */
	add_theme_support( 'loop-pagination' );

	/* Nicer [gallery] shortcode implementation. */
	add_theme_support( 'cleaner-gallery' );

	/* Better captions for themes to style. */
	add_theme_support( 'cleaner-caption' );

	/* Automatically add feed links to <head>. */
	add_theme_support( 'automatic-feed-links' );

	/* Whistles plugin. */
	add_theme_support( 'whistles', array( 'styles' => true ) );

	/* Post formats. */
	add_theme_support( 
		'post-formats', 
		array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) 
	);

	/* Editor styles. */
	add_editor_style( stargazer_get_editor_styles() );

	/* Handle content width for embeds and images. */
	// Note: this is the largest size based on the theme's various layouts.
	hybrid_set_content_width( 1025 );
}

 
 
 
/* Add the child theme setup function to the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'bgb_theme_setup' );

/**
 * Setup function.  All child themes should run their setup within this function.  The idea is to add/remove 
 * filters and actions after the parent theme has been set up.  This function provides you that opportunity.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function bgb_theme_setup() {

	/*
	 * Add a custom background to overwrite the defaults.  Remove this section if you want to use 
	 * the parent theme defaults instead.
	 *
	 * @link http://codex.wordpress.org/Custom_Backgrounds
	 */
	add_theme_support(
		'custom-background',
		array(
			'default-color' => '64a8f5',
			'default-image' => '%2$s/images/backgrounds/stripe_6.png',
		)
	);

	/*
	 * Add a custom header to overwrite the defaults.  Remove this section if you want to use the 
	 * the parent theme defaults instead.
	 *
	 * @link http://codex.wordpress.org/Custom_Headers
	 */
	add_theme_support( 
		'custom-header', 
		array(
			'default-text-color' => '252525',
			'default-image'      => '',
			'random-default'     => false,
		)
	);

	/* Filter to add custom default backgrounds (supported by the framework). */
	add_filter( 'hybrid_default_backgrounds', 'bgb_default_backgrounds' );

	/* Add a custom default color for the "primary" color option. */
	add_filter( 'theme_mod_color_primary', 'bgb_color_primary' );
}

/**
 * This works just like the WordPress `register_default_headers()` function.  You're just setting up an 
 * array of backgrounds.  The following backgrounds are merely examples from the parent theme.  Please 
 * don't use them.  Use your own backgrounds.  Or, remove this section (and the `add_filter()` call earlier) 
 * if you don't want to register custom backgrounds.
 *
 * @since  0.1.0
 * @access public
 * @param  array  $backgrounds
 * @return array
 */

function bgb_default_backgrounds( $backgrounds ) {

	$new_backgrounds = array(
		'light-blue-stripe' => array(
			'url'           => '%2$s/images/backgrounds/stripe_4.png',
			'thumbnail_url' => '%2$s/images/backgrounds/stripe_4.png',
		)
	);

	return array_merge( $new_backgrounds, $backgrounds );
}


/**
 * Add a default custom color for the theme's "primary" color option.  Users can overwrite this from the 
 * theme customizer, so we want to make sure to check that there's no value before returning our custom 
 * color.  If you want to use the parent theme's default, remove this section of the code and the 
 * `add_filter()` call from earlier.  Otherwise, just plug in the 6-digit hex code for the color you'd like 
 * to use (the below is the parent theme default).
 *
 * @since  0.1.0
 * @access public
 * @param  string  $hex
 * @return string
 */
 
 // using same color as primary but keeping function for forward compat
function bgb_color_primary( $hex ) {
	return $hex ? $hex : '0016d9';//
}

//make the "read more" link in the_excerpt link to the post
//from http://codex.wordpress.org/Function_Reference/the_excerpt#Make_the_.22read_more.22_link_to_the_post
function new_excerpt_more($more) {
       global $post;
	return ' <a href="'. esc_url(get_permalink($post->ID)) . '">(...Read More)</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');