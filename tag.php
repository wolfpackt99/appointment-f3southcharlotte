<?php
  get_header(); ?>
<!-- Page Title Section -->
<div class="page-title-section">		
	<div class="overlay">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="page-title">
						<h1>
						<?php 
						echo _e('Tag Archive','appointment');
						echo ' ';
						echo single_cat_title("", false);
						?>
						</h1>
					</div>
				</div>
				<div class="col-md-6">
					<ul class="page-breadcrumb">
						<?php if (function_exists('qt_custom_breadcrumbs')) qt_custom_breadcrumbs();?>
					</ul>
				</div>
			</div>
		</div>	
	</div>
</div>
<div class="page-builder">
	<div class="container">
		<div class="row">
			<!-- Blog Area -->
			<div class="<?php appointment_post_layout_class(); ?>" >
			<?php	if( have_posts() ):
					//Start the loop
						while ( have_posts()) : the_post(); ?>
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
										</div>
									</div>
							</div>
						</div>
						<?php endwhile;
					endif;	
					// Previous/next page navigation.
					the_posts_pagination( array(
					'prev_text'          => '<i class="fa fa-angle-double-left"></i>',
					'next_text'          => '<i class="fa fa-angle-double-right"></i>',
					) );
					?>
			</div>
			<!--Sidebar Area-->
			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>
			<!--Sidebar Area-->
		</div>
	</div>
</div>
<?php get_footer(); ?>