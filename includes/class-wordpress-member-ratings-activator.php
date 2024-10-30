<?php

/**
 * Fired during plugin activation
 *
 * @link       https://codeies.com
 * @since      1.0.0
 *
 * @package    EURATINGS_WordPress_Member_Ratings
 * @subpackage EURATINGS_WordPress_Member_Ratings/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    EURATINGS_WordPress_Member_Ratings
 * @subpackage EURATINGS_WordPress_Member_Ratings/includes
 * @author     Codeies <invisiblevision2011@gmail.com>
 */
class EURATINGS_WordPress_Member_Ratings_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
			 global $wpdb;
			$table_name = $wpdb->prefix . "codeies_wmr";
			
			$charset_collate = $wpdb->get_charset_collate();

			if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name ) {

				    $sql = "CREATE TABLE $table_name (
				            ID mediumint(9) NOT NULL AUTO_INCREMENT,
				            `reviewer_id` BIGINT(20) NOT NULL,
				            `posted_date` int(8) NOT NULL,
				            `user_id` BIGINT(20)  NOT NULL,
				            `criteria` TEXT NOT NULL,
				            `title` varchar(80) NOT NULL,
				            `comment` TEXT NOT NULL,
				            `status` mediumint(9) NOT NULL,
				            `avg_rating` varchar(4) NOT NULL,
				            PRIMARY KEY  (ID)
				            
				    ) $charset_collate;";

				    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				    dbDelta($sql);
			}
	
	}

}
