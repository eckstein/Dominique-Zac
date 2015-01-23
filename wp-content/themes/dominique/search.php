<?php get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: "%s"' ), get_search_query() ); ?></h1>
			</header>

			<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php 
						//fallback img
						$img = get_template_directory_uri().'/images/post-thumbnail-fallback.jpg';
						if ( has_post_thumbnail() && !is_attachment() ){
							$img = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
						}
						$teaser = get_post_custom_values('Teaser', get_the_ID())[0];
					?>
				
					<article id="post-<?php the_ID(); ?>" class="category-post clearfix">
					
						<div class="col-md-4">
							<div class="entry-thumbnail">
								<p><a href="<?php the_permalink(); ?>"><img src="<?php echo $img; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="img-responsive"></a></p>
							</div>
						</div>
						
						<div class="col-md-8">
							<header class="entry-header">
								<?php if ( is_single() ) : ?>
									<h1 class="entry-title"><?php the_title(); ?></h1>
								<?php else : ?>
									<h1 class="entry-title">
										<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
									</h1>
								<?php endif; // is_single() ?>
							
								<?php if($teaser): ?>
									<h3 class="teaser"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo $teaser; ?></a></h3>
								<?php endif; ?>

								<div class="entry-meta"><?php dom_entry_meta(); ?></div>
							</header><!-- .entry-header -->

							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div>
						
							<?php edit_post_link(); ?>
						</div>
					</article><!-- #post -->
				<?php endwhile; ?>

				<?php dom_paging(); ?>

		<?php else : ?>
			<hr><h1 class="entry-title"><?php printf( __( 'No Results for: "%s"' ), get_search_query() ); ?></h1><hr>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>