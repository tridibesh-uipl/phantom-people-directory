<?php
/**
 * Plugin Name: People Directory Phantom
 * Description: Creates dynamic phantom pages from a CSV and enriches them with GitHub data.
 * Version: 1.0
 * Author: UIPL
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'PD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once PD_PLUGIN_DIR . 'includes/class-pd-csv-loader.php';
require_once PD_PLUGIN_DIR . 'includes/class-pd-routing.php';
require_once PD_PLUGIN_DIR . 'includes/class-pd-github-api.php';
require_once PD_PLUGIN_DIR . 'includes/class-pd-sitemap.php';
require_once PD_PLUGIN_DIR . 'includes/class-pd-shortcode.php';

function pd_init_plugin() {
    PD_CSV_Loader::init();
    PD_Routing::init();
    PD_GitHub_API::init();
    PD_Sitemap::init();
}
add_action( 'plugins_loaded', 'pd_init_plugin' );

register_activation_hook( __FILE__, function() {
    PD_Routing::add_rewrite_rules();
    PD_Sitemap::add_sitemap_rewrite();
    flush_rewrite_rules();
} );