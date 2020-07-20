<?php

/**
 * Plugin Name:       SWS File Manager
 * Plugin URI:        https://ccharacter.com/custom-plugins/sws-file-man/
 * Description:       Manage and display uploaded files
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      5.5
 * Author:            Sharon Stromberg
 * Author URI:        https://ccharacter.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sws-file-man
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once plugin_dir_path(__FILE__).'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/ccharacter/sws-file-man/main/plugin.json',
	__FILE__,
	'sws_file-man'
);

//require_once plugin_dir_path(__FILE__).'options_page.php';
//require_once plugin_dir_path(__FILE__).'duplicate_pages.php';


// add stylesheets
function sws_file_man_enqueue_script() {   
 	//wp_enqueue_style( 'swsTweakStyles', plugin_dir_url(__FILE__).'inc/sws_tweaks_style.css');
}
add_action('wp_enqueue_scripts', 'sws_file_man_enqueue_script');

//$optVals = get_option( 'sws_wp_tweaks_options' );

?>
