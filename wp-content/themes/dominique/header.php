<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ).bloginfo( 'name' ); ?></title>
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href='http://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Cinzel' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<a href="https://plus.google.com/117654194596893200007" rel="publisher"></a>
<div id="top"></div>
<div id="page" class="container">
    <header>
        <!-- Begin MailChimp Signup Form -->
        <div style="border: 1px solid white" id="mc_embed_signup" style="display:none">
            <a onclick="dom.toggleSignUp(1)" class="boxclose"></a>
            <form action="//projectdominique.us7.list-manage.com/subscribe/post?u=61f22ab1c099cc2466bea21eb&amp;id=bd32fbbf31" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" validate>
                <div id="mc_embed_signup_scroll">
                    <h2>Want more Project Dominique?</br>Subscribe for update Today!</h2>
                    <div class="mc-field-group">
                        <input type="submit" value="SUBMIT" name="subscribe" id="mc-embedded-subscribe" class="button" style="float: right">
                        <div style="overflow: hidden;">
                            <input type="email" value="enter email adress" name="EMAIL" class="required email" id="mce-EMAIL" maxlength="60" onfocus="if(this.value == 'enter email adress') { this.value = ''; }" onblur="if(this.value == '') { this.value = 'enter email adress';}">
                        </div>
                    </div>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>
                    <div class="privacy">We respect your privacy!&nbsp;&nbsp;We promise to never share, trade, sell, deliver, reveal, publicize, or market your email address in any way, shape, or form.</div>
                </div>
                <div style="position: absolute; left: -5000px;"><input type="text" name="b_61f22ab1c099cc2466bea21eb_bd32fbbf31" tabindex="-1" value=""></div> <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
            </form>
        </div>
		
        <div class="masthead">
            <div class="logo">
				<h1 class="logo acc"><?php bloginfo( 'name' ); ?></h1>
                <a class="linkwrap" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">  
                </a>
            </div>
            <div class="sink">
                <div class="col-md-2 text-left pull-left"><a onclick="dom.toggleSignUp(0)" class="subscribe-link">subscribe</a></div>
                <div class="col-md-2 text-right pull-right header-right"><ul><?php get_sidebar('header'); ?></ul></div>
            </div>
        </div>
        <!--End mc_embed_signup-->
		
        <nav class="navbar" role="navigation">
            <a class="sr-only sr-only-focusable" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentythirteen' ); ?>">Skip to content</a>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<a class="navbar-brand visible-xs visible-sm visible-md" href="#">Menu</a>-->
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <div id="menuItems"><?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav navbar-nav' ) ); ?></div>
                <div id="searchFormToggler">
                    <button type="button" class="btn navbar-btn navbar-left searchTrigger" onclick="dom.toggleSearch(0)"><span class="glyphicon glyphicon-search"></span></button>
                    <form role="search" method="get" id="searchform" class="searchform" action="<?php esc_url( home_url( '/' )); ?>">
                        <label class="sr-only sr-only-focusable" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
                        <input type="text" value="<?php get_search_query(); ?>" name="s" id="s" class="form-control" placeholder="SEARCH BY TYPING HERE AND PRESS ENTER" />
                        <input type="submit" id="searchsubmit" value="<?php esc_attr_x( 'Search', 'submit button' ); ?>" class="hidden" />
                    </form>
                </div>
            <button type="button" class="btn navbar-btn navbar-right searchTrigger hidden-xs" onclick="dom.toggleSearch(1)"><span class="glyphicon glyphicon-search"></span></button>
            </div>
        </nav>
    </header>
    <div id="main" class="site-main">