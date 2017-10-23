<?php
$appointment_options=theme_setup_data();
$news_setting = wp_parse_args(  get_option( 'appointment_options', array() ), $appointment_options );
if($news_setting['home_blog_enabled'] == 0 ) { ?>
<div class="blog-section">
	<div class="container">
	
		<!-- Section Title -->
		<div class="row">
			<div class="col-md-12">
				<div class="section-heading-title">
					<h1><?php echo $news_setting['blog_heading']; ?></h1>
					<p><?php echo $news_setting['blog_description']; ?></p>
				</div>
			</div>
		</div>
		<!-- /Section Title -->
		
		<div class="row">
		<?php
		
		$no_of_post = $news_setting['post_display_count'];	

		 $args = array( 'post_type' => 'post','ignore_sticky_posts' => 1 , 'posts_per_page' => $no_of_post);
		 $news_query = new WP_Query($args);	
		 

		 $i=1;
			while($news_query->have_posts() ) : $news_query->the_post();				
			?>
			<div class="col-md-6">
				<div class="blog-sm-area">
					<div class="media">
						<div class="blog-sm-box">
							<?php $defalt_arg =array('class' => "img-responsive"); ?>
							<?php if(has_post_thumbnail()): ?>
							<?php the_post_thumbnail('', $defalt_arg); ?>
							<?php endif; ?>
						</div>
						<div class="media-body">
							<?php $appointment_options=theme_setup_data();
							  $news_setting = wp_parse_args(  get_option( 'appointment_options', array() ), $appointment_options );
							if($news_setting['home_meta_section_settings'] == '' ) { ?>	
							<div class="blog-post-sm">
								<?php _e('By','appointment');?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php echo get_the_author();?></a>
								<a href="<?php echo get_month_link(get_post_time('Y'),get_post_time('m')); ?>">
								<?php echo get_the_date('M j, Y'); ?></a>
								<div class="categories gray" style='padding-top: 3px;'>
									<?php echo the_category(" "); ?>
									<div class="clear"></div>
								</div>
							</div>
							<?php } ?>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo get_home_blog_excerpt(); ?></p>
							<?
							$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

							if ( comments_open() ) {
								if ( $num_comments == 0 ) {
									$comments = __('No Comments');
								} elseif ( $num_comments > 1 ) {
									$comments = $num_comments . __(' Comments');
								} else {
									$comments = __('1 Comment');
								}
								$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
							} else {
								$write_comments =  __('Comments are off for this post.');
							} 
							echo $write_comments;
							?> 
						</div>
					</div>
				</div>
			</div>
			<?php 
			  if($i==2)
			  { 
			     echo '<div class="clearfix"></div>';
				 $i=0;
			  }$i++;
			 
			endwhile; 
			 wp_reset_postdata();
			  ?>
		</div>
	</div>
<?php } ?>
</div>