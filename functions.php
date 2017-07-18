<?php

/* override some files that were called by require in the parent theme
require( WEBRITI_THEME_FUNCTIONS_PATH .'/menu/appoinment_nav_walker.php');
 */
add_action( 'wp_enqueue_scripts', 'appointment_f3southcharlotte_theme_css',999);
function appointment_f3southcharlotte_theme_css() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css' );
	wp_enqueue_style( 'theme-menu', get_template_directory_uri() . '/css/theme-menu.css' );
	wp_enqueue_style( 'default-css', get_stylesheet_directory_uri()."/css/default.css" );
	wp_enqueue_style( 'element-style', get_template_directory_uri() . '/css/element.css' );
	wp_enqueue_style( 'media-responsive' ,get_template_directory_uri() . '/css/media-responsive.css');
	wp_dequeue_style('appointment-default', get_template_directory_uri() .'/css/default.css');
	wp_enqueue_script('menu-fixer-js', get_stylesheet_directory_uri() .'/js/menu-fixer.js');
	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'parent-style' ),
		wp_get_theme()->get('Version')
	);
	
}

/*
	* Let WordPress manage the document title.
	*/
function appointment_f3southcharlotte_setup() {
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'appointment_f3southcharlotte_setup' );

function the_pax_gen( $meta_boxes ) {
    $prefix = '';
	$meta_boxes[] = array(
		'id' => 'wd',
		'title' => esc_html__( 'Workout Details', 'metabox-online-generator' ),
		'post_types' => array( 'post' ),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => false,
		'fields' => array(
			array(
				'id' => $prefix . 'workout_date',
				'type' => 'text',
				'name' => esc_html__( 'Workout Date - MM/DD/YYYY', 'metabox-online-generator' ),
				'desc' => esc_html__( 'Please use this exact format: MM/DD/YY This will show up at the posts top under the "When:" heading PLUS be a part of the title.', 'metabox-online-generator' ),
			),
			array(
				'id' => $prefix . 'the_pax',
				'type' => 'textarea',
				'name' => esc_html__( 'The Pax - Comma Separated', 'metabox-online-generator' ),
				'desc' => esc_html__( 'This will show up at the posts top under "The PAX" heading. Separate all by commas. Example: MT, Mermaid, Wingman, TR, etc.', 'metabox-online-generator' ),
				'rows' => 3,
			),
			array(
				'id' => $prefix . 'qic',
				'type' => 'text',
				'name' => esc_html__( 'QIC', 'metabox-online-generator' ),
				'desc' => esc_html__( 'Workout leader(s). This will show up at the posts top under the "QIC:" heading.', 'metabox-online-generator' ),
			),
		),
	);
	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'the_pax_gen' );

?>