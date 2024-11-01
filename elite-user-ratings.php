<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://codeies.com
 * @since             1.0.0
 * @package           EURATINGS_WordPress_Member_Ratings
 *
 * @wordpress-plugin
 * Plugin Name:       Codeies - Elite user Ratings
 * Plugin URI:        https://codeies.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Codeies
 * Author URI:        https://codeies.com/muhammad-junaid/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       elite-user-ratings
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EURATINGS_WordPress_Member_Ratings_PATH', plugin_dir_path( __FILE__ ));
define( 'EURATINGS_WordPress_Member_Ratings_URL', plugin_dir_url( __FILE__ ));
define( 'EURATINGS_WordPress_Member_Ratings_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wordpress-member-ratings-activator.php
 */
function activate_EURATINGS_WordPress_Member_Ratings() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-member-ratings-activator.php';
	EURATINGS_WordPress_Member_Ratings_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wordpress-member-ratings-deactivator.php
 */
function deactivate_EURATINGS_WordPress_Member_Ratings() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-member-ratings-deactivator.php';
	EURATINGS_WordPress_Member_Ratings_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_EURATINGS_WordPress_Member_Ratings' );
register_deactivation_hook( __FILE__, 'deactivate_EURATINGS_WordPress_Member_Ratings' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require EURATINGS_WordPress_Member_Ratings_PATH . 'includes/class-wordpress-member-ratings.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
add_action('plugins_loaded','run_EURATINGS_WordPress_Member_Ratings');

function run_EURATINGS_WordPress_Member_Ratings() {
	
	require EURATINGS_WordPress_Member_Ratings_PATH  . 'vendor/autoload.php';
	\Carbon_Fields\Carbon_Fields::boot();

	$plugin = new EURATINGS_WordPress_Member_Ratings();
	$plugin->run();

}
//run_EURATINGS_WordPress_Member_Ratings();
