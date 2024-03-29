<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Sanse
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js content-hidden">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php /* <link rel="preload" href="https://glueckpress.com/wp-content/themes/sanse-glck/assets/webfonts/35E79C_2_0.woff2" as="font">
<link rel="preload" href="https://glueckpress.com/wp-content/themes/sanse-glck/assets/webfonts/35E79C_3_0.woff2" as="font">
<link rel="preload" href="https://glueckpress.com/wp-content/themes/sanse-glck/assets/webfonts/35E79C_0_0.woff2" as="font"> */ ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'sanse' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="wrapper">

			<div class="site-branding">
				<?php
				// Custom logo SVG.
				get_template_part( 'images/inline', 'logo.svg' );

				// Site Title.
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;
				?>
			</div><!-- .site-branding -->

			<?php
				get_template_part( 'menus/menu', 'primary' ); // Loads the menus/menu-primary.php template.
			?>

		</div><!-- .wrapper -->
	</header><!-- #masthead -->

	<div class="hero" id="hero">
	</div><!-- .hero -->

	<div id="content" class="site-content">
