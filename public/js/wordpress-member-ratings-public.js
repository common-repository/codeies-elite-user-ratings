(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(document).ready(function(){
	  	$('#submitreview').click(function(){
	 			  $.ajax({
			        type: 'POST',
			        url: $('#codeies_wmr_reviewform').attr('action'),
			        data: $('#codeies_wmr_reviewform').serialize(), 
			        success: function(response) { 
			        	location.reload();
						return false;
			         },
			    });
	 	})
			$('.cwmrslider').each(function(){
	  			var id =$(this).attr('id');
				$('#'+id).jRange({
				    from: $(this).data('min'),
				    to: $(this).data('max'),
				    step: $(this).data('step'),
				    scale: [1,2,3,4,5],
				    format: '%s',
				    width: $('.codeies_wmr_review_member').width(),
				    disable: $(this).data('disabled'),
				    showLabels: true,
				    snap: true
				});
	  		})
			 	$('.cwmrstars').each(function(){
			 		  $(this).raty({
						scoreName: $(this).data('name'),
						//path: codeies_wmr.plugin_path+'public/raty/images/',
						number: 5,
						score: parseFloat($(this).data('value')),
						halfShow:true,
						readOnly: $(this).data('disabled'),
						starType:'i',
					});
			 	});

  


		})

})( jQuery );

