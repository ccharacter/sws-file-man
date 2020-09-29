<?php

/**
 * Plugin Name:       SWS ManageItems
 * Plugin URI:        https://ccharacter.com/custom-plugins/sws-manage-items/
 * Description:       Manage and display uploaded files, links, or videos
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      5.5
 * Author:            Sharon Stromberg
 * Author URI:        https://ccharacter.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sws-manage-items
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once plugin_dir_path(__FILE__).'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/ccharacter/sws-manage-items/main/plugin.json',
	__FILE__,
	'sws_manage-items'
);

require_once plugin_dir_path(__FILE__).'func_fields.php';

//require_once plugin_dir_path(__FILE__).'options_page.php';
//require_once plugin_dir_path(__FILE__).'duplicate_pages.php';


// add stylesheets
function sws_manage_items_enqueue_script() {   
 	//wp_enqueue_style( 'swsTweakStyles', plugin_dir_url(__FILE__).'inc/sws_tweaks_style.css');
}
add_action('wp_enqueue_scripts', 'sws_manage_items_enqueue_script');

//$optVals = get_option( 'sws_wp_tweaks_options' );

/* NOTES TO SELF
--add categories
--add ACF Group
--add templates
--add options page with shortcode descriptions
*/


/**
 * Checks if Gravity Forms is active
 */
function sws_manage_items_activate() {
  if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
    include_once( ABSPATH . '/wp-admin/includes/plugin.php' );
  }
  if ( current_user_can( 'activate_plugins' ) && ! class_exists( 'GFCommon' ) ) {
    // Deactivate the plugin.
    deactivate_plugins( plugin_basename( __FILE__ ) );
    // Throw an error in the WordPress admin console.
    $error_message = '<p style="font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;font-size: 13px;line-height: 1.5;color:#444;">' . esc_html__( 'This plugin requires ', 'gravityforms' ) . '<a href="' . esc_url( 'https://gravityforms.com/' ) . '">Gravity Forms</a>' . esc_html__( ' plugin to be active, as well as the <strong>Advanced Post Creation</strong> add-on.', 'gravityforms' ) . '</p>';
    die( $error_message ); // WPCS: XSS ok.
  }
}
register_activation_hook( __FILE__, 'sws_manage_items_activate' );



// CPT for FILES

add_action( 'init', 'sws_manage_items_cpt_init' );
function sws_manage_items_cpt_init() {
	$labelsCL = array(
 		'name' => 'Items',
    	'singular_name' => 'Item',
    	'add_new' => 'Add New Item',
    	'add_new_item' => 'Add New Item',
    	'edit_item' => 'Edit Item',
    	'new_item' => 'New Item',
    	'all_items' => 'All Items',
    	'view_item' => 'View Items',
    	'search_items' => 'Search Items',
    	'not_found' =>  'No Item',
    	'not_found_in_trash' => 'No Items found in Trash', 
    	'parent_item_colon' => '',
    	'menu_name' => 'ManageItems'
    );
    //register post type
	register_post_type( 'item', array(
		'labels' => $labelsCL,
		'hierarchical' => true,
		'has_archive' => true,
 		'public' => true,
		'publicly_queryable' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
		'taxonomies' => array('post_tag','category'),	
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'menu_icon' => 'dashicons-media-document',
		'rewrite' => array( 'with_front' => false, 'slug' => 'items' ),
		)
	);


}


add_filter( 'parse_query', 'prefix_parse_filter' );
function  prefix_parse_filter($query) {
   global $pagenow;
   $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';

   if ( is_admin() && 
     'item' == $current_page &&
     'edit.php' == $pagenow && 
      isset( $_GET['mgr_type'] ) && 
      $_GET['mgr_type'] != '') {

    $filter_name = $_GET['mgr_type'];
    $query->query_vars['meta_key'] = 'mgr_type';
    $query->query_vars['meta_value'] = $filter_name;
    $query->query_vars['meta_compare'] = '=';
  }
}


function sws_fileman_rewrite_flush() {
    sws_manage_items_cpt_init();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'sws_fileman_rewrite_flush' );





?>
