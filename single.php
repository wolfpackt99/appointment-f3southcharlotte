<?php
get_header();
get_template_part('index','banner'); ?>
<!-- Blog Section Right Sidebar -->
<div class="page-builder">
	<div class="container">
		<div class="row">
			<!-- Blog Area -->
			<div class="<?php appointment_post_layout_class(); ?>" >
			<?php
		if(have_posts())
		{
		while(have_posts()) { the_post(); ?>
		<!-- tags -->
		<!-- get the category -->
					<div class="categories">
						<?php echo the_category(" "); ?>
						<div class="clear"></div>
					</div>			
					<!-- get all the post values and assign them to an array -->
					<?php $custom_fields = get_post_custom(); 
						// print_r($custom_fields["workout_name"][0]); ?>
					<!-- these used to be part of the headline build. storing here temp -->
					<!-- this was the custom field workout_name, which was deprecated by tags -->
					<!-- <?php //$values = get_post_custom_values("workout_name"); echo $values[0]; ?>-->
					<!-- this was the get_tags until all started populating titles -->
					<?php 
					//$posttags = wp_get_post_terms( get_the_ID() , 'post_tag' , 'fields=names' ); if( $posttags ) echo implode( ' ' , $posttags ); ?>
<!-- if custom field workout_name OR ... exists then create this div -->
					<?php if ($custom_fields["workout_name"][0] || $custom_fields["workout_date"][0] || $custom_fields["qic"][0] || $custom_fields["the_pax"][0])
						{
						?>
					<div style="padding:10px 15px 0 15px; border:1px dotted #eee; background:#eef8fa;">
					<ul>
						<?php if ($custom_fields["workout_date"][0]) {echo '<li> <strong>When:</strong> ' . $custom_fields["workout_date"][0] . '</li>'; } ?>
						<?php if ($custom_fields["qic"][0]) {echo '<li> <strong>QIC:</strong> ' . $custom_fields["qic"][0] . '</li>'; } ?>
						<?php 
							
							if ($custom_fields["the_pax"][0]) {
								echo '<li> <strong>The PAX:</strong> ' . $custom_fields["the_pax"][0] . '</li>'; 
							} 
							else { 
								echo get_the_tag_list('<li><strong>Pax:</strong> <span class="the_pax">', ', ', ' </span></li> ');
							} 
						?>
						</ul>
					</div>
					<br /><br />
					<?php } ?>
		<!-- end tags -->
		<?php
		get_template_part('content',''); ?>
				<!--Blog Author-->
                <div class="comment-title"><h3><?php _e('About the author','appointment'); ?></h3></div>
				<div class="blog-author">
					<div class="media">
						<div class="pull-left">
							<?php echo get_avatar( get_the_author_meta( 'ID') , 200); ?>
						</div>
						<div class="media-body">
							<h2> <?php the_author(); ?> <span> <?php $user = new WP_User( get_the_author_meta( 'ID' ) ); echo $user->roles[0];?> </span></h2>
							<p><?php the_author_meta( 'description' ); //the_author_description(); ?> </p>
							<ul class="blog-author-social">
							   <?php			
				$google_profile = get_the_author_meta( 'google_profile' );
				if ( $google_profile && $google_profile != '' ) {
					echo '<li class="googleplus"><a href="' . esc_url($google_profile) . '" rel="author"><i class="fa fa-google-plus"></i></a></li>';
				}
				$twitter_profile = get_the_author_meta( 'twitter_profile' );
				if ( $twitter_profile && $twitter_profile != '' ) {
					echo '<li class="twitter"><a href="' . esc_url($twitter_profile) . '"><i class="fa fa-twitter"></i></a></li>';
				}
				$facebook_profile = get_the_author_meta( 'facebook_profile' );
				if ( $facebook_profile && $facebook_profile != '' ) {
					echo '<li class="facebook"><a href="' . esc_url($facebook_profile) . '"><i class="fa fa-facebook"></i></a></li>';
				}
				$linkedin_profile = get_the_author_meta( 'linkedin_profile' );
				if ( $linkedin_profile && $linkedin_profile != '' ) {
					   echo '<li class="linkedin"><a href="' . esc_url($linkedin_profile) . '"><i class="fa fa-linkedin"></i></a></li>';
				}
				$skype_profile = get_the_author_meta( 'skype_profile' );
				if ( $skype_profile && $skype_profile != '' ) {
					   echo '<li class="skype"><a href="' . esc_url($skype_profile) . '"><i class="fa fa-skype"></i></a></li>';
				}
				?>
							</ul>
						</div>
					</div>	
				</div>	
				<!--/Blog Author-->
				<?php } comments_template('',true);  } ?>	
				</div>
			<!-- /Blog Area -->			
			<!--Sidebar Area-->
			<div class="col-md-4">
			<?php get_sidebar(); ?>	
			</div>
			<!--Sidebar Area-->
		</div>
	</div>
</div>
<!-- /Blog Section Right Sidebar -->
<?php get_footer(); ?>