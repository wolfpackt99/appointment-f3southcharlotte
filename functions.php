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

	wp_register_script('name-checker-js', get_stylesheet_directory_uri() .'/js/name-checker.js', array('jquery'), null, true );
	wp_enqueue_script('name-checker-js');

	wp_register_script('functions-js', get_stylesheet_directory_uri() .'/js/functions.js', array('jquery'), null, true );
	wp_enqueue_script('functions-js');
	wp_localize_script( 'functions-js', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'parent-style' ),
		wp_get_theme()->get('Version')
	);
	
}


/* override categories to try to separate the pax in rss */
add_filter('the_category_rss','my_custom_cat_rss');
function my_custom_cat_rss($type = null){
	if ( empty($type) )
		$type = get_default_feed();
	$categories = get_the_category();
	$tags = get_the_tags();
	$the_list = '';
	$cat_names = array();
	$tag_names = array();

	$filter = 'rss';
	if ( 'atom' == $type )
		$filter = 'raw';

	if ( !empty($categories) ) foreach ( (array) $categories as $category ) {
		$cat_names[] = sanitize_term_field('name', $category->name, $category->term_id, 'category', $filter);
	}

	if ( !empty($tags) ) foreach ( (array) $tags as $tag ) {
		$tag_names[] = sanitize_term_field('name', $tag->name, $tag->term_id, 'post_tag', $filter);
	}

	$cat_names = array_unique($cat_names);
	$tag_names = array_unique($tag_names);

	foreach ( $cat_names as $cat_name ) {
		if ( 'rdf' == $type )
			$the_list .= "\t\t<dc:subject><![CDATA[$cat_name]]></dc:subject>\n";
		elseif ( 'atom' == $type )
			$the_list .= sprintf( '<category scheme="%1$s" term="%2$s" />', esc_attr( get_bloginfo_rss( 'url' ) ), esc_attr( $cat_name ) );
		else
			$the_list .= "\t\t<category domain='category'><![CDATA[" . @html_entity_decode( $cat_name, ENT_COMPAT, get_option('blog_charset') ) . "]]></category>\n";
	}

	foreach ( $tag_names as $tag_name ) {
		if ( 'rdf' == $type )
			$the_list .= "\t\t<dc:subject><![CDATA[$tag_name]]></dc:subject>\n";
		elseif ( 'atom' == $type )
			$the_list .= sprintf( '<category scheme="%1$s" term="%2$s" />', esc_attr( get_bloginfo_rss( 'url' ) ), esc_attr( $tag_name ) );
		else
			$the_list .= "\t\t<category domain='pax'><![CDATA[" . @html_entity_decode( $tag_name, ENT_COMPAT, get_option('blog_charset') ) . "]]></category>\n";
	}

	return $the_list;
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
				'id' => $prefix . 'qic',
				'type' => 'text',
				'name' => esc_html__( 'QIC', 'metabox-online-generator' ),
				'desc' => esc_html__( 'Workout leader(s). This will show up at the posts top under the "QIC:" heading.', 'metabox-online-generator' ),
			),
			array(
				'id' => $prefix . 'workout_date',
				'type' => 'text',
				'name' => esc_html__( 'Workout Date - MM/DD/YYYY', 'metabox-online-generator' ),
				'desc' => esc_html__( 'Please use this exact format: MM/DD/YYYY This will show up at the posts top under the "When:" heading PLUS be a part of the title.', 'metabox-online-generator' ),
			),
			array(
				'id' => $prefix . 'pax_instructions',
				'type' => 'heading',
				'name' => esc_html__( 'Other Instructions', 'metabox-online-generator' ),
				'desc' => esc_html__( 'List Pax (including Q) at the workout using "Tags" in the box on the right side of this page. PAX name only. No (QIC), (FNG)', 'metabox-online-generator' ),
				'std' => 'Header Default',
			)
		),
		'validation' => array(
			'rules'    => array(
			  "{$prefix}qic" => array(
				'required'  => true,
			  ),
			  "{$prefix}workout_date" => array(
				'required'  => true,
			  ),
			)
		)
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

/* 
Removed for now
add_action( 'add_meta_boxes', 'change_tag_meta_box', 0 ); */
function change_tag_meta_box() {
	global $wp_meta_boxes;
	unset( $wp_meta_boxes['post']['side']['core']['tagsdiv-post_tag'] );
	add_meta_box('tagsdiv-post_tag',
		__('PAX'),
		'post_tags_meta_box',
		'post',
		'side',
		'low');
}


/* Start filtering post editing metaboxes */
function remove_my_post_metaboxes() {
	remove_meta_box( 'formatdiv','post','normal' ); // Format Div
	remove_meta_box( 'postcustom','post','normal' ); // Custom Fields
	remove_meta_box( 'trackbacksdiv','post','normal' ); // Trackback and Pingback
	remove_meta_box( 'postexcerpt','post','normal' ); // Custom Excerpt
	remove_meta_box( 'slugdiv','post','normal' ); // Custom Slug
  }
  add_action('admin_menu','remove_my_post_metaboxes');
  /* End filtering post editing metaboxes */

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
					$listItem .= '<span class="post-stats"><span class"wpp-comments">' . $tclap_count . ' #tclaps</span></span></li>';
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