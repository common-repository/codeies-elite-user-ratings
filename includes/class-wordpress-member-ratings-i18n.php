<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://codeies.com
 * @since      1.0.0
 *
 * @package    EURATINGS_WordPress_Member_Ratings
 * @subpackage EURATINGS_WordPress_Member_Ratings/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    EURATINGS_WordPress_Member_Ratings
 * @subpackage EURATINGS_WordPress_Member_Ratings/includes
 * @author     Codeies <invisiblevision2011@gmail.com>
 */
class EURATINGS_WordPress_Member_Ratings_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wordpress-member-ratings',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
