<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://sgssandhu.com/
 * @since      1.0.0
 *
 * @package    Aione_Create_Site
 * @subpackage Aione_Create_Site/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Aione_Create_Site
 * @subpackage Aione_Create_Site/includes
 * @author     SGS Sandhu <sgs.sandhu@gmail.com>
 */
class Aione_Create_Site_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'aione-create-site',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
