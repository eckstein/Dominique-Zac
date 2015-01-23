<?php get_header(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content single-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $entryMeta = dom_single_entry_meta(); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
					
					 <?php if (mfi_reloaded_has_image( 'hero-image', $post->ID )) {
							echo  mfi_reloaded_get_image( 'hero-image', 'full', $post->ID, array('class' => 'img-responsive'));
					} 
					else if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) {
							echo '<div class="entry-thumbnail">';
							echo the_post_thumbnail('full', array('class' => 'img-responsive'));
					} ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php 
							$teaser = get_post_custom_values('Teaser', get_the_ID())[0];
							if($teaser){
								echo '<h2 class="teaser">'.$teaser.'</h2>';
							}
						?>
						
						<div class="entry-meta row">
							<?php echo $entryMeta; ?>
							<?php get_sidebar( 'share' ); ?>
						</div>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
						<div style="clear:both;"><?php edit_post_link(); ?></div>
					</div>
					
					<footer class="entry-meta row">
						<?php echo $entryMeta; ?>
						<?php get_sidebar( 'share' ); ?>
					</footer>
				</article><!-- #post -->

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>

<script>$('.single-content .entry-content img').addClass('img-responsive');</script>