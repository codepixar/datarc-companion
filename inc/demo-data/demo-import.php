<?php 
if( !defined( 'WPINC' ) ){
    die;
}
/**
 * @Packge     : Datarc Companion
 * @Version    : 1.0
 * @Author     : Colorlib
 * @Author URI : http://colorlib.com/wp/
 *
 */

// demo import file
function datarc_import_files() {
	
	$demoImg = '<img src="'.plugins_url( 'screen-image.png', __FILE__ ) .'" alt="'.esc_attr__( 'Demo Preview Imgae', 'datarc-companion' ).'" />';
	
  return array(
    array(
      'import_file_name'             => 'Datarc Demo',
      'local_import_file'            => DATARC_COMPANION_DEMO_DIR_PATH .'datarc-demo.xml',
      'local_import_widget_file'     => DATARC_COMPANION_DEMO_DIR_PATH .'datarc-widgets-demo.json',
      'import_customizer_file_url'   => plugins_url( 'datarc-customizer.dat', __FILE__ ),
      'import_notice' => $demoImg,
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'datarc_import_files' );
	
// demo import setup
function datarc_after_import_setup() {
	// Assign menus to their locations.
	$main_menu    = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
    $onepage_menu = get_term_by( 'name', 'One Page Menu', 'nav_menu' );
	$social_menu  = get_term_by( 'name', 'Social Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
            'primary-menu' => $main_menu->term_id,
			'onepage-menu' => $onepage_menu->term_id,
			'social-menu'  => $social_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
	update_option( 'datarc_demodata_import', 'yes' );

}
add_action( 'pt-ocdi/after_import', 'datarc_after_import_setup' );

//disable the branding notice after successful demo import
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

//change the location, title and other parameters of the plugin page
function datarc_import_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'One Click Demo Import' , 'datarc-companion' );
	$default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'datarc-companion' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'datarc-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'datarc_import_plugin_page_setup' );

// Enqueue scripts
function datarc_demo_import_custom_scripts(){
	
	
	if( isset( $_GET['page'] ) && $_GET['page'] == 'datarc-demo-import' ){
		// style
		wp_enqueue_style( 'datarc-demo-import', plugins_url( 'css/demo-import.css', __FILE__ ), array(), '1.0', false );
	}
	
	
}
add_action( 'admin_enqueue_scripts', 'datarc_demo_import_custom_scripts' );



?>