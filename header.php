<!doctype html>

<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6 oldie"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7 oldie"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8 oldie"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
		wp_title( '|', true, 'right' );
		// Add the blog name.
		bloginfo( 'name' );
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );
		?></title>

		<meta name="description" content="<?php bloginfo('description'); ?>">
		<meta name="author" content="<?php bloginfo('name'); ?>">

		<!-- icons & favicons (for more: http://themble.com/support/adding-icons-favicons/) -->
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">

		<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

		<!-- modernizr -->
		<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/modernizr.2.7.min.js"></script>

  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
		<script>var themeurl = "<?php echo get_template_directory_uri(); ?>";</script>
	</head>

	<body <?php body_class(); ?>>

		<?php
			/* Navigation */
			$navigation = array(
				'logo'	=> null,
				'style'	=> 'fixed', // 'static', 'fixed' or 'default'
				'invert'	=> true
			);
		?>

		<?php if( $args['style'] == 'fixed' ) bones_main_nav($navigation); ?>

		<div id="container" class="container">

			<header role="banner">

				<div id="inner-header" class="clearfix">

					<?php if( $args['style'] != 'fixed' ) bones_main_nav($navigation); ?>

				</div> <!-- end #inner-header -->

			</header> <!-- end header -->
