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
	
	wp_register_script( 'jquery-cookie', '//cdnjs.cloudflare.com/ajax/libs/js-cookie/2.1.4/js.cookie.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'jquery-cookie' );

	wp_register_script('menu-fixer-js', get_stylesheet_directory_uri() .'/js/menu-fixer.js', array('jquery'), null, true );
	wp_enqueue_script('menu-fixer-js');

	wp_register_script('functions-js', get_stylesheet_directory_uri() .'/js/functions.js', array('jquery'), null, true );
	wp_enqueue_script('functions-js');
	wp_localize_script( 'functions-js', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
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

/* enable tclaps by filter on the_content */
function filter_content_div($content)
{
	global $post;
	if($post->post_type == 'post') {
		$postmetacontent = tclaps_snippet();
		$content = $content . $postmetacontent;
	}
	return $content;
}

/* tclap button */
/**
 * Function to create code snippet for tclaps button
 */
function tclaps_snippet() {
	global $post;
	$tclaps = get_post_meta($post->ID, "tclaps", true);
	$tclaps = ($tclaps == "") ? 0 : $tclaps;
	$snippet = '<div class="tclapsection">';
	$snippet .= ' <div class="tclapsbox user_tclap">';
	$snippet .= '  <button id="btn-tclap" type="button" class="btn btn-default btn-xs" data-post_id="' . $post->ID . '">';
	$snippet .= '   <i class="fa fa-spinner fa-pulse fa-fw" style="display:none;"></i>';
	$snippet .= '   <i class="fa fa-thumbs-up" aria-hidden="true"></i> #tclap | <span class="tclap-counter">' . $tclaps . '</span>';
	$snippet .= '  </button>';
	$snippet .= ' </div>';
	$snippet .= '</div>';
	return $snippet;
}

add_action('the_content','filter_content_div');

function my_user_tclap() {
	
	$post_id = $_REQUEST["post_id"];
	$tclap_count = get_post_meta($post_id, "tclaps", true);
	$tclap_count = ($tclap_count == '') ? 0 : $tclap_count;
	$new_tclap_count = $tclap_count + 1;
	$tclap = update_post_meta($post_id, "tclaps", $new_tclap_count);
	if (isset($_COOKIE['tclap']) && $_COOKIE[''])
	$result = '';
	if($tclap === false) {
		$result = array(
			'type' => 'error',
			'tclaps' => $tclap_count
		);
	}
	else{
		$result = array(
			'type' => 'success',
			'tclaps' => $new_tclap_count
		);
	}
	wp_send_json_success($result);	
}

add_action("wp_ajax_my_user_tclap", "my_user_tclap");
add_action("wp_ajax_nopriv_my_user_tclap", "my_user_tclap");


class TClap_Widget extends WP_Widget{
	function __construct() {
		parent::__construct(
			'tclap_widget', // Base ID
			'TClap Widget', // Name
			array('description' => __( 'Shows the top 5 tclaps for last 7 days'))
		);
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['numberToShow'] = strip_tags($new_instance['numberToShow']);
		return $instance;
	}

	function form($instance) {
	if( $instance) {
		$title = esc_attr($instance['title']);
		$numberToShow = esc_attr($instance['numberToShow']);
	} else {
		$title = '';
		$numberToShow = '';
	}
	?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'tclap_widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('numberToShow'); ?>"><?php _e('Number to Show:', 'tclap_widget'); ?></label>
		<select id="<?php echo $this->get_field_id('numberToShow'); ?>"  name="<?php echo $this->get_field_name('numberToShow'); ?>">
			<?php for($x=1;$x<=10;$x++): ?>
			<option <?php echo $x == $numberToShow ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
			<?php endfor;?>
		</select>
		</p>
	<?php
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$numberToShow = $instance['numberToShow'];
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		$this->getTopTClaps($numberToShow);
		echo $after_widget;
	}

	function getTopTClaps($number) { //html
		global $post;
		$listings = new WP_Query();
		$week = date( 'W' );
		$year = date( 'Y' );
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $number,
			'meta_query' => array(
				array(
					'key' => 'tclaps'
				)
			),
			'date_query' => array(
				'column' => 'post_date',
				'after' => '- 7 days'
			),
			'meta_key' => 'tclaps',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'

		);
		
		$listings->query($args);
		if($listings->found_posts > 0) {
			echo '<ul class="tclap_widget">';
				while ($listings->have_posts()) {
					$listings->the_post();
					$tclap_count = get_post_meta(get_the_ID(), "tclaps", true);
					$tclap_count = ($tclap_count == '') ? 0 : $tclap_count;
					$listItem = '<li>';
					$listItem .= '<a href="' . get_permalink() . '">';
					$listItem .= get_the_title() . '</a>';
					$listItem .= ' (' . $tclap_count . ')</li>';
					echo $listItem;
				}
			echo '</ul>';
			wp_reset_postdata();
		}else{
			echo '<p style="padding:25px;">None found</p>';
		}
	}
 
 
} //end class Realty_Widget
register_widget('TClap_Widget');
?>