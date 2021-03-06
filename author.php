<?php
  get_header(); ?>
<!-- Page Title Section -->
<div class="page-title-section">		
	<div class="overlay">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-8">
					<div class="page-title">
						<h1>
						<?php 
						printf(_e('Author Archive','appointment').' '.'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a>' ); ?>
						</h1>
					</div>
				</div>

				<div class="col-md-4 col-sm-4 hidden-xs">
					<form action="http://f3southcharlotte.com/" method="get">
						<input type="text" class="search_widget_input" name="s" id="s" placeholder="Search" data-cip-id="s">
					</form>
				</div>
			</div>
		</div>	
	</div>
</div>
<!-- /Page Title Section -->
<div class="clearfix"></div>
<!-- /Page Title Section ---->
<div class="page-builder">
	<div class="container">
		<div class="row">
		
			<!-- Blog Area -->
			<div class="<?php appointment_post_layout_class(); ?>" >
			<?php 
				if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();
						get_template_part( 'content','');
					endwhile;
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