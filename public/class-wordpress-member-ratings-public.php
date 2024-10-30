<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codeies.com
 * @since      1.0.0
 *
 * @package    EURATINGS_WordPress_Member_Ratings
 * @subpackage EURATINGS_WordPress_Member_Ratings/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    EURATINGS_WordPress_Member_Ratings
 * @subpackage EURATINGS_WordPress_Member_Ratings/public
 * @author     Codeies <invisiblevision2011@gmail.com>
 */
class EURATINGS_WordPress_Member_Ratings_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( 'raty', plugin_dir_url( __FILE__ ) . 'raty/jquery.raty.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordpress-member-ratings-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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


		wp_enqueue_script( 'jRange', plugin_dir_url( __FILE__ ) . 'js/jRange.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'raty', plugin_dir_url( __FILE__ ) . 'raty/jquery.raty.js', array( 'jquery' ), $this->version, false );
		$vars = array(
		    'plugin_path' => EURATINGS_WordPress_Member_Ratings_URL,
		);
		wp_localize_script( 'raty', 'codeies_wmr', $vars );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordpress-member-ratings-public.js', array( 'jquery' ), $this->version, false );

	}

	public function register_shortcodes() {
		add_shortcode( 'codeies_wmr_ratings', array( $this, 'codeies_wmr_reviews_shortcode') );
	    add_shortcode( 'codeies_wmr_profile', array( $this, 'codeies_wmr_profile_shortcode') );
	    add_shortcode( 'codeies_wmr_average_rating', array( $this, 'codeies_wmr_average_rating_shortcode') );
	    add_shortcode( 'codeies_wmr_ratingpage_link', array( $this, 'codeies_wmr_ratingpage_link_shortcode') );
	  
	}
	public function codeies_wmr_reviews_shortcode($atts){
			$atts = shortcode_atts(
					array(
						'pagination' => 'yes',
						'perpage' => '10',
						'display' => 'slider',
						'user_id' => '',
					),
					$atts
				);
		 ob_start();
			include(EURATINGS_WordPress_Member_Ratings_PATH.'/public/template/codeies_wmr_profile/codeies_wmr_reviews.php');
		return ob_get_clean();
	}
	public function codeies_wmr_profile_shortcode($atts){
			$atts = shortcode_atts(
					array(
						'user_id' => '',
					),
					$atts
				);
		 ob_start();
			include_once(EURATINGS_WordPress_Member_Ratings_PATH.'/public/template/codeies_wmr_profile/codeies_wmr_profile.php');
		return ob_get_clean();
	}	

	public function codeies_wmr_average_rating_shortcode($atts){
			$atts = shortcode_atts(
					array(
						'user_id' => '',
						'return' => 'box',
					),
					$atts
				);
		 $user_id = EURATINGS_WordPress_Member_Ratings_Ratings::get_currenprofile_id($atts['user_id']);
		 if(empty($user_id))
		    		return;
		 $average = EURATINGS_WordPress_Member_Ratings_Ratings::get_avg_rating($user_id); 
		 if(isset($average['avg']))
		 	if($atts['return'] =='average'){
		 		return '<span class="cwmr-avgrating userid-'.$user_id.'">'.number_format((float)$average['avg'], 2, '.', '').'</span>';
		 	}else if($atts['return'] =='total_ratings'){
		 		return '<span class="cwmr-totalrating userid-'.$user_id.'">'.$average['total'].'</span>';
		 	}elseif($atts['return'] == 'stars'){
		 		return '<span data-name="review_'.$user_id.'>" data-value="'.number_format((float)$average['avg'], 2, '.', '').'"  class="cwmrstars" id="range_'.rand(999,9999).'" data-disabled="true>"></span>';
		 	} else{
		 		return 
		 			'<div class="codeies_wmr_avrg_rating">
					<h4>User Rating <span data-name="review_'.$user_id.'>" data-value="'.number_format((float)$average['avg'], 2, '.', '').'"  class="cwmrstars" id="range_'.rand(999,9999).'" data-disabled="true>"></span></h4>
					<p>'.number_format((float)$average['avg'], 2, '.', '').' average based on '.$average['total'].' '._n( 'review', 'reviews', $average['total'], 'wordpress-member-ratings' ).'</p>
				</div>';
		 	}
			
		else
		   return false;
	}	
	public function codeies_wmr_ratingpage_link_shortcode($atts){
			$atts = shortcode_atts(
					array(
						'text' => 'View all ratings',
						'user_id' => '',
					),
					$atts
				);
		 $user_id = EURATINGS_WordPress_Member_Ratings_Ratings::get_currenprofile_id($atts['user_id']);
		  if(empty($user_id))
		    		return;
		 $reviewpage_url  = carbon_get_theme_option('codeies_wmr_ratings_page');
		 return '<a href="'.$reviewpage_url.'?user_id='.$user_id.'">'.$atts['text'].'</a>';
	}
}
