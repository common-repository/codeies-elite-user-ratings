<?php
		global $wpdb;
		$table_name = $wpdb->prefix . "codeies_wmr";
		
		if(!isset($atts)){
			$atts = array();
			$atts['display'] = 'slider';
			$atts['perpage'] = '10';
			$atts['pagination'] = 'yes';
		}

		$items_per_page = $atts['perpage'];
		$page = isset( $_GET['page_no'] ) ? abs( (int) $_GET['page_no'] ) : 1;
		if(!empty($atts['user_id'])){
			$user_id = $atts['user_id'];
		}
		else{
		$user_id = isset( $_GET['user_id'] ) ? abs( (int) $_GET['user_id'] ) : '';
		}
		if(empty($user_id)){
			  $user_id = EURATINGS_WordPress_Member_Ratings_Ratings::get_currenprofile_id();
		}
		 if(empty($user_id))
		    		return;

		$offset = ( $page * $items_per_page ) - $items_per_page;

		$query = 'SELECT * FROM '.$table_name.' WHERE `user_id` = '.$user_id;

		$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
		$total = $wpdb->get_var( $total_query );
		$results = $wpdb->get_results( $query.' ORDER BY id DESC LIMIT '. $offset.', '. $items_per_page, ARRAY_A );
		if(count($results)<=0){
			echo '<p>'.__('No one rated this user yet! Be the first one to rate').'</p>';
			return;
		}
		?><div class="codeies_wmr_reviews_list"><?php 
		foreach ($results as $reviews ) { ?>

			<?php $mainreviews = unserialize($reviews['criteria']); ?>	
				<div class="codeies_wmr_review_member">
	
		<?php  $file = EURATINGS_WordPress_Member_Ratings_PATH.'public/template/codeies_wmr_profile/ratings-style/'.$atts['display'].'.php';
									if(!file_exists($file)){
										 $file = EURATINGS_WordPress_Member_Ratings_PATH.'public/template/codeies_wmr_profile/ratings-style/slider.php';
									}
		foreach ($mainreviews as $key =>$review) {
				include($file); ?>
		<?php } ?>

		<div class="codeies_wmr_comment"/>
		<h3><?php echo esc_html($reviews['title']); ?></h3>
		<p><?php echo esc_html(($reviews['comment'])); ?></p>
		</div>
<div class="codeies_wmr_reviewer">
	<img src="<?php echo get_avatar_url($reviews['reviewer_id']); ?>" alt="review">
		<span><?php echo  get_user_by( 'id', $reviews['reviewer_id'] )->display_name ; ?> - <?php echo esc_html( human_time_diff($reviews['posted_date'] ) ) . ' ago';  ?></span>
</div>
</div>
		<?php } ?></div> 
<?php 
		if($atts['pagination'] == 'yes'):
					echo  paginate_links( array(
		                        'base' => add_query_arg( 'page_no', '%#%' ),
		                        'format' => '',
		                        'prev_text' => __('&laquo;'),
		                        'next_text' => __('&raquo;'),
		                        'total' => ceil($total / $items_per_page),
		                        'current' => $page
		                    ));
		endif;