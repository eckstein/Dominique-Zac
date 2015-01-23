<?php 
	// This sets out a variable called $term - we'll use it ALOT for what we're about to do.
	$issue = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
 
	//GET ALL TAXONOMY IMAGES FROM THE TAXONOMY IMAGE PLUGIN
	$associations = taxonomy_image_plugin_get_associations();
	$img = '';		

	//$issue_term_id = absint( $issue->term_id );
	if ( array_key_exists( $issue->term_id, $associations ) ) {
	    $image_id = absint( $associations[ $issue->term_id ] );
		$img = wp_get_attachment_url($image_id, 'full' );
	}

	//fallback image if there isn't one associated with the issue
	if ( $img=='' ){
		$img = get_template_directory_uri().'/images/issue-thumbnail-fallback.jpg';
	}

	get_header(); 

?>

	<div id="primary" class="content-area category-view issue view">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>
		
			<article id="issue-<?php echo $issue->slug; ?>" class="category-post clearfix" style="padding-bottom:0;">
				<div class="col-md-4">
					<p><img src="<?php echo $img; ?>" alt="<?php echo $issue->name; ?>" title="<?php echo $issue->name; ?>" class="img-responsive"></p>
				</div>
				<div class="col-md-8">
					<header class="entry-header">
						<h1 class="entry-title">
							<?php echo $issue->name; ?>
							<?php if($issue->description!==''): ?>
								 // <?php echo $issue->description; ?>
							<?php endif; ?>
						</h1>
					</header>
					<ul class="post-list">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php $teaser = get_post_custom_values('Teaser', get_the_ID())[0]; ?>
						
							<li><a href="<?php the_permalink(); ?>"><span class="post-title"><?php the_title(); ?></span> 
							<?php if($teaser): ?>
								<span class="teaser"><?php echo $teaser; ?></span>
							<?php endif; ?>
							</a></li>
						
						<?php endwhile; ?>
					</ul>
				</div>
			</article>
			
			<h2 class="inside-this-issue text-center">Inside This Issue</h2>

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

			<?php get_dom_prev_next_issue(); ?>

		<?php else : ?>
			<hr><h1 class="entry-title text-center">There are no posts in this issue</h1><hr>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>