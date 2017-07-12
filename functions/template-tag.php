<?php
if ( ! function_exists( 'appointment_aside_meta_content' ) ) :

		function appointment_aside_meta_content()
		{
		$appointment_options=theme_setup_data();
		$news_setting = wp_parse_args(  get_option( 'appointment_options', array() ), $appointment_options );
		if($news_setting['home_meta_section_settings'] == '' ) { ?>
	    <?php }  } endif;
if ( ! function_exists( 'appointment_post_meta_content' ) ) :
function appointment_post_meta_content()
{ 
            /* translators: used between list items, there is a space after the comma */
            
			$appointment_options=theme_setup_data();
			$news_setting = wp_parse_args(  get_option( 'appointment_options', array() ), $appointment_options );
			if($news_setting['home_meta_section_settings'] == 0 ) { ?>
			<div class="blog-post-lg">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php echo get_avatar( get_the_author_meta('user_email'), $size = '40'); ?></a>
				<?php _e('By','appointment');?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php echo get_the_author();?></a>
                
			</div>
			<?php }  
} endif; 

// this functions accepts two parameters first is the preset size of the image and second  is for additional classes, you can also add yours 
if(!function_exists( 'appointment_post_thumbnail')) : 
function appointment_post_thumbnail($preset,$class){
if(has_post_thumbnail()){ 
 $defalt_arg =array('class' => $class); ?>
			<div class="blog-lg-box">
				<a class ="img-responsive" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail($preset, $defalt_arg); ?>		
			</div>
			<?php } }endif;

// This Function Check whether Sidebar active or Not
if(!function_exists( 'appointment_post_layout_class' )) :
function appointment_post_layout_class(){
	if(is_active_sidebar('sidebar-primary'))
		{ echo 'col-md-8'; } 
	else 
		{ echo 'col-md-12'; }  
} endif; 
?>