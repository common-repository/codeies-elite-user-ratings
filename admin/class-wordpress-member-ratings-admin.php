<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://codeies.com
 * @since      1.0.0
 *
 * @package    EURATINGS_WordPress_Member_Ratings
 * @subpackage EURATINGS_WordPress_Member_Ratings/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    EURATINGS_WordPress_Member_Ratings
 * @subpackage EURATINGS_WordPress_Member_Ratings/admin
 * @author     Codeies <invisiblevision2011@gmail.com>
 */
class EURATINGS_WordPress_Member_Ratings_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in EURATINGS_WordPress_Member_Ratings_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The EURATINGS_WordPress_Member_Ratings_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordpress-member-ratings-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in EURATINGS_WordPress_Member_Ratings_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The EURATINGS_WordPress_Member_Ratings_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordpress-member-ratings-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function submit_ajax_review(){
		 global $wpdb;
		 $reviews = carbon_get_theme_option( 'codeies_wmr_ratings' );
		 $sanitized_reviews = array();
		 $sum = 0;
		 foreach ($reviews as $key =>$review) {
		 	if(isset($_POST['review_'.$review['rating_name']])){
		 		$sanitized_reviews[$review['rating_name']]['value'] = max(1, min(intval($_POST['review_'.$review['rating_name']]), 5));
		 		$sanitized_reviews[$review['rating_name']]['rating_label'] = $review['rating_label'];
		 		$sanitized_reviews[$review['rating_name']]['rating_name'] = $reviews['rating_name'];
		 		$sum += $sanitized_reviews[$review['rating_name']]['value'];
		 	}

		 }
		 $total_reviews = count($reviews);
		 $avrg = $sum / $total_reviews;
		 $sanitized_reviews = serialize($sanitized_reviews);
         $title = sanitize_text_field($_POST['title']);
         $comment = sanitize_text_field(stripslashes($_POST['comment']));
         $reviewer_id = get_current_user_id();
         $user_id = intval($_POST['user_id']);
         $isRated = EURATINGS_WordPress_Member_Ratings_Ratings::get_currentrating($user_id);
         $user = get_userdata( $user_id );
		if ( $user === false || is_array($isRated)) {
		  return; 
		  wp_die();
		} 
	    $table = $wpdb->prefix.'codeies_wmr';
	    $data = array('reviewer_id' => $reviewer_id, 
	    			  'user_id' => $user_id,
	    			  'posted_date' => time(),
	    			  'criteria'=>$sanitized_reviews ,
	    			  'title'=>$title,
	    			  'comment'=>$comment,
	    			  'status'=>'1', // Approved 
	    			  'avg_rating'=>$avrg
	    			);
	    $format = array('%d','%d','%d','%s','%s','%s','%d','%s');
	    $wpdb->insert($table,$data,$format);
		wp_die(); 	
	}

	public function resetDatabase_ajax(){
		global $wpdb;
		$table = $wpdb->prefix.'codeies_wmr';
		if( current_user_can('administrator') )
				$delete = $wpdb->query("TRUNCATE TABLE $table");
		if($delete){
			_e("Process Completed",'wordpress-member-ratings');
		}else{
			_e("Process failed , Retry",'wordpress-member-ratings');
		}	

		wp_die();
	}

}
