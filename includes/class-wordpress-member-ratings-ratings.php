<?php 
/**
 * 
 */
class EURATINGS_WordPress_Member_Ratings_Ratings
{
	
	public static function get_avg_rating($user_id) {
		global $wpdb;
		   	/*	$result = $wpdb->get_row(" SELECT COUNT(DISTINCT avg_rating) as 'total', SUM(avg_rating)/COUNT(DISTINCT avg_rating) AS 'avg' FROM " . $wpdb->prefix . "codeies_wmr 
                    WHERE `user_id` = '" . $user_id . "'",ARRAY_A
                );*/
          $result = $wpdb->get_row($wpdb->prepare(" SELECT COUNT(DISTINCT avg_rating) as 'total', SUM(avg_rating)/COUNT(DISTINCT avg_rating) AS 'avg' FROM " . $wpdb->prefix . "codeies_wmr 
                    WHERE `user_id` = '" . $user_id . "'"),ARRAY_A);


             return $result;
	}

	public static function get_currentrating($user_id) {
		global $wpdb;
		$reviewer_id = get_current_user_id();
		if($reviewer_id == 0)
				return false;
		  
		 /*$result = $wpdb->get_row(" SELECT * FROM " . $wpdb->prefix . "codeies_wmr 
                    WHERE `user_id` = '" . $user_id . "' AND `reviewer_id` = ".$reviewer_id."",ARRAY_A
                );*/	 
        $result = $wpdb->get_row( $wpdb->prepare( " SELECT * FROM " . $wpdb->prefix . "codeies_wmr 
                    WHERE `user_id` = '" . $user_id . "' AND `reviewer_id` = ".$reviewer_id."" ),ARRAY_A );
         return $result;
	}

	public static function get_currenprofile_id($user_id = ''){
		$plugin = carbon_get_theme_option('codeies_wmr_profile_plugin');
		//$user_id = '';
		if(empty($user_id)){
			switch ($plugin) {
			   	
			   case 'ultimate_membership':
			   		$user_id = (int) function_exists('um_profile_id')? um_profile_id() :(0);
			   		break;
			   	case 'profile_grid':
			   			if(!class_exists('PM_request'))
			   				return 0;

			   	$pmrequests = new PM_request;
			   	if(isset($_REQUEST['uid']))
								 $user_id = $pmrequests->pm_get_uid_from_profile_slug($_REQUEST['uid']);
				               
				         break;
			  case 'buddypress':
			  				if(function_exists('bp_displayed_user_id'))
			   					$user_id = bp_displayed_user_id();			  
			  case 'users_wp':
			  				if(function_exists('uwp_get_displayed_user')){
			  					if(uwp_get_displayed_user())
			   						$user_id =uwp_get_displayed_user()->ID;
			  				}
			   		break;
			   	default:
			   		$getvar = carbon_get_theme_option('codeies_wmr_profile_page_getvar');
			   		$user_id = (int) isset($_GET[$getvar])?($_GET[$getvar]):(''); // intval();
			   	 break;
		   }
		}
		if((empty($user_id) || $user_id == 0) && isset($_GET['user_id'])){
				return (int) $_GET['user_id'];
		}else{
		return $user_id;
			}
	}
}