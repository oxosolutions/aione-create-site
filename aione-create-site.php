<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name:       Aione Create Site
 * Plugin URI:        https://oxosolutions.com/products/wordpress-plugins/aione-create-site
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.3.0.3
 * Author:            OXO Solutions®
 * Author URI:        https://oxosolutions.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       aione-create-site
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/oxosolutions/aione-create-site
 * GitHub Branch: master
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-aione-create-site-activator.php
 */
function activate_aione_create_site() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aione-create-site-activator.php';
	Aione_Create_Site_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-aione-create-site-deactivator.php
 */
function deactivate_aione_create_site() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-aione-create-site-deactivator.php';
	Aione_Create_Site_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_aione_create_site' );
register_deactivation_hook( __FILE__, 'deactivate_aione_create_site' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-aione-create-site.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_aione_create_site() {

	$plugin = new Aione_Create_Site();
	$plugin->run();

}
run_aione_create_site();
