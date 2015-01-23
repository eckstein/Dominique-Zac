		<div style="clear:both;"></div>
		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			
			<div><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="logo acc"><?php bloginfo( 'name' ); ?></a></div>
			
			<nav class="footer-nav"><?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?></nav>
					
			<div><a href="http://www.purehome.com" title="Brought to you by purehome.com" class="by-ph acc">Brought to you by purehome.com</a></div>
			<p class="text-center">All content ©2014 purehome, Inc. All rights reserved.</p>

		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
	
	<script src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/dom.js"></script>
	<script>$(function(){dom.init()})</script>
</body>
</html>