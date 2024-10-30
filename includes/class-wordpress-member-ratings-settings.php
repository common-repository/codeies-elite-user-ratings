<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://codeies.com
 * @since      1.0.0
 *
 * @package    EURATINGS_WordPress_Member_Ratings
 * @subpackage EURATINGS_WordPress_Member_Ratings/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    EURATINGS_WordPress_Member_Ratings
 * @subpackage EURATINGS_WordPress_Member_Ratings/includes
 * @author     Codeies <invisiblevision2011@gmail.com>
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class EURATINGS_WordPress_Member_Ratings_Settings {
	protected $option_page;

	function __construct()
	{
			add_action('carbon_fields_register_fields',[$this,'add_setting_options']);
	}

	
	 public function add_setting_options(){

		 $this->option_page  =	Container::make( 'theme_options', 'Member ratings' )->set_page_parent( 'users.php' );
		 $this->option_page  
		 	// General
		 	->add_tab( __( 'General' ), array(
		        Field::make( 'select', 'codeies_wmr_profile_plugin', __( 'Profile builder' ) )
		       			->set_datastore( new Serialized_CODEIES_WMR_Datastore() )
					    ->set_options( array(
					        'ultimate_membership' => 'Ultimate membership',
					        'profile_grid' => 'ProfileGrid',
					        //'registration_magic' => 'Registration Magic',
					        'buddypress' => 'BuddyPress',
					        //'user_registration_wpeverest' => 'User registration - WPEverest',
					        //'user_registration_cozmolabs' => 'User registration & Profile Builder - Cozmoslabs',
					        'users_wp' => 'UsersWP',
					        'other'=>'Other'
					    ) ),
					      Field::make( 'text', 'codeies_wmr_profile_page_getvar', __( 'Profile Page (GET variable)' ) )
					      ->set_datastore( new Serialized_CODEIES_WMR_Datastore() )
					      	->set_required( true )->set_help_text( 'Should be in the url example ?user_id=x' )
					      	->set_conditional_logic( array(
				        'relation' => 'AND', // Optional, defaults to "AND"
				        array(
				            'field' => 'codeies_wmr_profile_plugin',
				            'value' => 'other', // Optional, defaults to "". Should be an array if "IN" or "NOT IN" operators are used.
				            'compare' => '=', // Optional, defaults to "=". Available operators: =, <, >, <=, >=, IN, NOT IN
				        )
				    ) )->set_attribute('placeholder','user_id'),

					    Field::make( 'select', 'codeies_wmr_displaytype', __( 'Display type','wordpress-member-ratings' ) )
					    ->set_options( array(
					        'slider' => 'Slider',
					        'stars' => 'Stars',
					    ) )->set_default_value( 'slider' ),
					   Field::make( 'separator', 'codeies_wmr_generalrpage', __( 'Ratings Page','wordpress-member-ratings' ) ),
					   Field::make( 'text', 'codeies_wmr_ratings_page', __( 'Ratings Page url' ) )->set_help_text( 'Where [codeies_wmr_ratings] Shortcode is placed' )
		        		->set_datastore( new Serialized_CODEIES_WMR_Datastore() ),
		    ) )

		 	// Pages
		 	-> add_tab( __( 'Pages' ), array(

		      
				/*Field::make( 'text', 'codeies_wmr_profile_page_url', __( 'Profile Page url' ) )->set_help_text( 'Where [codeies_wmr_profile] shortcode is placed' )
				->set_datastore( new Serialized_CODEIES_WMR_Datastore() ),*/

		      
		 
		    ) )
		 	// Reviews
		    ->add_tab( __( 'Ratings Criteria' ), array(
		        Field::make( 'complex', 'codeies_wmr_ratings', 'Ratings Criteria' )
		        ->set_datastore( new Serialized_CODEIES_WMR_Datastore() )
                ->set_layout( 'tabbed-horizontal' )
                ->add_fields( 'user_reviews', array(
				    Field::make( 'text', 'rating_label','Rating Label' ),
				    Field::make( 'text', 'rating_name','Unique Name' ) ->set_help_text( 'Unique name without space or special characters Note: This will be saved in database ! May cause errors if changed later' )->set_required( true )->set_attribute('pattern','[A-Za-z0-9]+'),
				) )
				->set_header_template( '
				    <% if (rating_label) { %>
				         <%- rating_label %> 
				    <% } %>
				' )
		    ) )	 	


		    // Reviews
		    ->add_tab( __( 'Guide & Shortcodes' ), array(
		   	
				 Field::make( 'html', 'codeies_wmr_totalratings' )
   					 ->set_html( '
   					 	<hr><strong>Available Attributes</strong>
   					 	<ul>
   					 		<li><code>perpage</code> Optional , Required if shortcode is not placed in user profile page</li>
   					 		<li><code>pagination</code> Optional , Required if shortcode is not placed in user profile page</li>
   					 		<li><code>display</code>slider,stars Default is slider</li>
   					 		<li><code>user_id</code> Optional , Required if shortcode is not placed in user profile page</li>
   					 	</ul>
   					 	<code>[codeies_wmr_ratings]</code>
   					 	<p>This shortcode prints all ratings & comments of single user! </p>
   					 	<hr><strong>Available Attributes</strong>
   					 	<ul>
   					 		<li><code>user_id</code> Optional , Required if shortcode is not placed in user profile page</li>
   					 	</ul>
   					 	<code>[codeies_wmr_profile]</code><p>This shortcode renders the rating form</p>
   					 	 	<hr><strong>Available Attributes</strong>
   					 	<ul>
   					 		<li><code>user_id</code> Optional , Required if shortcode is not placed in user profile page</li>
   					 		<li><code>return</code> What you want to get from shortcode , Default is "box" Which will return the average rating box with number of reviewers . Pass "average" to get overall average, "stars" to get Average rating in stars and "total_ratings" to get number of reviews </li>
   					 	</ul>

   					 	<code>[codeies_wmr_average_rating]</code><p>This shortcode displays overall average rating of current profile</p>
   					 	 	<hr><strong>Available Attributes</strong>
   					 	<ul>
   					 		<li><code>text</code> Text to be displayed in hyperlink, Default is "View all ratings"</li>
   					 		<li><code>user_id</code> Optional , Required if shortcode is not placed in user profile page</li>
   					 	</ul>
   					 	<code>[codeies_wmr_ratingpage_link]</code><p>This shortcode generates hyperlink of a current profile rating page </p>

   					 	' ),
		   	 ) )

		    // Advanced
		    ->add_tab( __( 'Advanced' ), array(
		      Field::make( 'html', 'codeies_wmr_resetprofile' )
   					 ->set_html( '<p>This will delete all your member reviews ! You can not reverse this process so make sure to backup your database before proceeding .</p><button id="codeies_wmr_reset" class="button button-primary button-large">Reset ratings database</button>' )
		    ) );

	 }

}
return new EURATINGS_WordPress_Member_Ratings_Settings();