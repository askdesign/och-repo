<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'outreach', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'outreach' ) );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Outreach Pro Theme', 'outreach' ) );
define( 'CHILD_THEME_URL', 'https://my.studiopress.com/themes/outreach/' );
define( 'CHILD_THEME_VERSION', '3.1' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'outreach_load_scripts' );
function outreach_load_scripts() {

	wp_enqueue_script( 'outreach-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
	
	wp_enqueue_style( 'dashicons' );
	
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), CHILD_THEME_VERSION );

}

//* Add new image sizes
add_image_size( 'home-top', 1140, 460, TRUE );
add_image_size( 'home-bottom', 285, 160, TRUE );
add_image_size( 'sidebar', 300, 150, TRUE );

//* Add support for custom header -- disable this section
//* add_theme_support( 'custom-header', array(
//* 	'header-selector' => '.site-title a',
//* 	'header-text'     => false,
//* 	'height'          => 60, /* original was 100 */
//* 	'width'           => 640, /* original was 425 */
//* ) );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'outreach-pro-blue' 	=>	__( 'Outreach Pro Blue', 'outreach' ),
	'outreach-pro-orange' 	=> 	__( 'Outreach Pro Orange', 'outreach' ),
	'outreach-pro-purple' 	=> 	__( 'Outreach Pro Purple', 'outreach' ),
	'outreach-pro-red' 		=> 	__( 'Outreach Pro Red', 'outreach' ),
) );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer',
) );

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'outreach_author_box_gravatar_size' );
function outreach_author_box_gravatar_size( $size ) {

    return '80';
    
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'outreach_remove_comment_form_allowed_tags' );
function outreach_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Add the sub footer section
add_action( 'genesis_before_footer', 'outreach_sub_footer', 5 );
function outreach_sub_footer() {

	if ( is_active_sidebar( 'sub-footer-left' ) || is_active_sidebar( 'sub-footer-right' ) ) {
		echo '<div class="sub-footer"><div class="wrap">';
		
		   genesis_widget_area( 'sub-footer-left', array(
		       'before' => '<div class="sub-footer-left">',
		       'after'  => '</div>',
		   ) );
	
		   genesis_widget_area( 'sub-footer-right', array(
		       'before' => '<div class="sub-footer-right">',
		       'after'  => '</div>',
		   ) );
	
		echo '</div><!-- end .wrap --></div><!-- end .sub-footer -->';	
	}
	
}

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Relocate after entry widget
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'outreach' ),
	'description' => __( 'This is the top section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'outreach' ),
	'description' => __( 'This is the bottom section of the Home page.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-footer-left',
	'name'        => __( 'Sub Footer - Left', 'outreach' ),
	'description' => __( 'This is the left section of the sub footer.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'sub-footer-right',
	'name'        => __( 'Sub Footer - Right', 'outreach' ),
	'description' => __( 'This is the right section of the sub footer.', 'outreach' ),
) );
genesis_register_sidebar( array(
	'id'          => 'copyright-footer',
	'name'        => __( 'Copyright Footer', 'outreach' ),
	'description' => __( 'This is the bottom footer of the page.', 'outreach' ),
) );

//* Remove the site footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Customize the site footer
add_action( 'genesis_footer', 'och_custom_footer' );
function och_custom_footer() { ?>
 
	<footer class="site-footer" role="contentinfo" itemscope="itemscope" itemtype="https://schema.org/WPFooter"><div class="wrap">Copyright &copy; One Can Help <?php if(date('Y') != 2015) {echo '2015 to ';}; echo date('Y'); ?> | All Rights Reserved | Web maestro: <a href="https://www.askdesign.biz" target="_blank">ASK Design</a> | Website by <a href="https://www.herwitzassociates.com/" target="_blank">Herwitz Associates</a> and <a href="https://insightdezign.com" target="_blank">Insight Dezign</a><br /><?php dynamic_sidebar( 'copyright-footer' ); ?></div></footer>
 
<?php
}

/**
 * NOTE THIS KEY CODE SNIPPET! Filter the genesis_seo_site_title function to use an image for the logo instead of a background image
 * 
 * The genesis_seo_site_title function is located in genesis/lib/structure/header.php
 * @link https://blackhillswebworks.com/?p=4144
 *
 */

add_filter( 'genesis_seo_title', 'bhww_filter_genesis_seo_site_title', 10, 2 );

function bhww_filter_genesis_seo_site_title( $title, $inside ){
	 
	$child_inside = sprintf( '<a href="%s" title="%s"><img src="'. get_stylesheet_directory_uri() .'/images/OCH-LogoInCenter.png" title="%s" alt="%s"/></a>', trailingslashit( home_url() ), esc_attr( get_bloginfo( 'name' ) ), esc_attr( get_bloginfo( 'name' ) ), esc_attr( get_bloginfo( 'name' ) ) );
	 
	$title = str_replace( $inside, $child_inside, $title );
	 
	return $title;
		
}

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date] [post_edit]';
	return $post_info;
}