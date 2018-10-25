<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _svbk
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'after_body_tag' ); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', '_svbk' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		
		<div class="top-header">
			<div class="wrap">
				<div class="contact-phone">
					<?php esc_html_e( 'Call', '_svbk' ); ?>
					<a href="tel:<?php bloginfo( 'contact_phone' ); ?>"><?php bloginfo( 'contact_phone' ); ?></a>
				</div>
			</div>
		</div>

		<?php
		if ( is_front_page() ) {
			get_template_part( 'template-parts/header/header', 'image' );
		 }
		?>

		<div class="wrap">
			<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
	
			<button class="main-navigation-toggle" aria-controls="main-navigation" aria-expanded="false">
				<span class="screen-reader-text"><?php esc_html_e( 'Primary Menu', '_svbk' ); ?></span>
			</button>
			<div id="main-navigation">
				<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
				<nav id="site-navigation" role="navigation">
					<?php
						wp_nav_menu(
							 array(
								 'theme_location' => 'menu-1',
								 'menu_id'        => 'primary-menu',
							 )
							);
					?>
				</nav><!-- #site-navigation -->
				<?php endif; ?>
	
				<button class="search-toggle">
					<span class="screen-reader-text"><?php esc_html_e( 'Toggle Search', 'onofrio' ); ?></span>
				</button>
				<?php echo get_search_form(); ?>
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
