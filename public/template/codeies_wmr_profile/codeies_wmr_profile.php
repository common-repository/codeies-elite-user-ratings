<?php  
	   $ratings = carbon_get_theme_option( 'codeies_wmr_ratings' );
	   $displayType = carbon_get_theme_option( 'codeies_wmr_displaytype' );
	   $reviewpage_url  = carbon_get_theme_option('codeies_wmr_ratings_page');
	   $user_id = EURATINGS_WordPress_Member_Ratings_Ratings::get_currenprofile_id($atts['user_id']);
	    if(empty($user_id))
		    		return;
	   $isRated = EURATINGS_WordPress_Member_Ratings_Ratings::get_currentrating($user_id);
	   $rated = false;
	   if($user_id == 0 || empty($user_id))
	   	return false;
	
	if(is_array($isRated)){
	 	// print_r($isRated);
	 	 $rated = true;
	 	 $ratings = unserialize($isRated['criteria']);

	 }

 ?>
<div id="codeies_wmr_rating">

<?php if(!$rated && is_user_logged_in()): ?>
<div class="codeies_wmr_review_member">
	<form id="codeies_wmr_reviewform" action="<?php echo  admin_url( 'admin-ajax.php' ); ?>" type="POST">
		<?php foreach ($ratings as $review) {  
			include('ratings-style/'.$displayType.'.php'); ?>
				<?php } ?>
		<div class="codeies_wmr_comment_form">
		<label><?php _e('Title','wordpress-member-ratings'); ?><input type="text" name="title"></label>
		<label><?php _e('Comment','wordpress-member-ratings'); ?><textarea name="comment"></textarea></label>
		</div>
		<input type="hidden" name="action" value="codeies_wmr_submit_review">
		<input type="hidden" name="user_id" value="<?php echo intval($user_id); ?>">
		<input type="button" name="submit_review" id="submitreview" class="submitreview" value="Submit review">
	</form>
</div>
<?php elseif($isRated): ?>
	<div class="codeies_wmr_review_member">
	<form id="codeies_wmr_reviewform" action="<?php echo  admin_url( 'admin-ajax.php' ); ?>" type="POST">
		<?php foreach ($ratings as $key =>$review) {
		 include('ratings-style/'.$displayType.'.php'); ?>
		<?php } ?>
<div class="codeies_wmr_comment"/>
<h3><?php echo esc_html($isRated['title']); ?></h3>
<p><?php echo esc_html($isRated['comment']); ?></p>
		</form>
</div>

</div>
<?php else:
$anchor = __( 'login', 'wordpress-member-ratings' );
$domain = esc_url( wp_login_url( get_permalink() ));  
$link   = sprintf( '<a href="%s">%s</a>', $domain, $anchor );

 /* translators: 1 is a link with text "Google" and URL google.com */
echo sprintf( esc_html__( 'You must %1$s to rate this user', 'wordpress-member-ratings' ), $link );

 endif; ?>
</div>