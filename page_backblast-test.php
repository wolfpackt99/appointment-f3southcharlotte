<?php

/**

Template Name: Backblasts-Test

*/

get_header();

get_template_part('index','banner'); ?>

<!-- Blog Section with Sidebar -->

<div class="page-builder">

	<div class="container">

		<div class="row">
		
			<!-- Blog Area -->
			<div class="<?php appointment_post_layout_class(); ?>" >
			<?php

			$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
			$query = new WP_Query( array( 'posts_per_page' => 15 ) );  
			if ($query->have_posts()) {
				while ($query->have_posts()){
					$query->the_post();
				?>
				<div class="col-md-12">
					<div class="blog-sm-area">
						<div class="media">
							<div class="blog-sm-box">
								<?php $defalt_arg =array('class' => "img-responsive"); ?>
								<?php if(has_post_thumbnail()): ?>
								<?php the_post_thumbnail('', $defalt_arg); ?>
								<?php endif; ?>
							</div>
							<div class="media-body">
								<div class="categories gray">
									<?php echo the_category(" "); ?>   <?php the_tags('', ' ', ''); ?>
									<div class="clear"></div>
								</div>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="blog-post-sm">
									<?php _e('By','appointment');?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><?php echo get_the_author();?></a>
									<a href="<?php echo get_month_link(get_post_time('Y'),get_post_time('m')); ?>">
									<?php echo get_the_date('M j, Y'); ?></a>
								</div>
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

								$tclap_count = get_post_meta(get_the_ID(), "tclaps", true);
								$tclap_count = ($tclap_count == '') ? 0 : $tclap_count;
								echo " | " . $tclap_count . " #tclaps"
								?>
							</div>
						</div>
					</div>
				</div>
				<?php 
					wp_reset_postdata();
				} //endwhile
					wp_pagenavi(); 
			} else { ?>
				<div>No posts found</div>
			<?php } ?>
			</div>
			<!--Sidebar Area-->
			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>
			<!--Sidebar Area-->
		</div>

	</div>

</div>

<!-- /Blog Section with Sidebar -->

<?php get_footer(); ?>