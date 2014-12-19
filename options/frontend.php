<?php
function required_fields()
	{
		$opt = get_option('rf_settings');
		if( !isset($opt['rf_enabled_settings']) )
		{
			echo '';
		}
		else
		{
			$rf_style = "{'background':'#FFEBE8', 'border':'#CC0000 solid 1px'}";
			if ( isset($opt['rf_title_settings']) )
			{	
				if (isset($opt['rf_for_page_enabled']) && isset($opt['rf_title_for_page']))
				{
					global $typenow;
					if(in_array($typenow, array('post','page')))
					{	
						echo "<script type='text/javascript'>\n";
						  echo "
						  jQuery('#publish').click(function(){
								var testervar = jQuery('[id^=\"titlediv\"]')
								.find('#title');
								if (testervar.val().length < 1)
								{
									jQuery('[name^=\"post_title\"]').css( ".$rf_style." );
									setTimeout(\"jQuery('#ajax-loading').css('visibility', 'hidden');\", 100);
									alert('".$opt['rf_title_error']."');
									setTimeout(\"jQuery('#publish').removeClass('button-primary-disabled');\", 100);
									return false;
								}
							});
						  ";
						echo "</script>\n";
					}
					
				} else {
					global $post_type;
					if($post_type == 'post')
					{	
						echo "<script type='text/javascript'>\n";
						  echo "
						  jQuery('#publish').click(function(){
								var testervar = jQuery('[id^=\"titlediv\"]')
								.find('#title');
								if (testervar.val().length < 1)
								{
									jQuery('[name^=\"post_title\"]').css( ".$rf_style." );
									setTimeout(\"jQuery('#ajax-loading').css('visibility', 'hidden');\", 100);
									alert('".$opt['rf_title_error']."');
									setTimeout(\"jQuery('#publish').removeClass('button-primary-disabled');\", 100);
									return false;
								}
							});
						  ";
						echo "</script>\n";
					}
				}
			}
			
			if ( isset($opt['rf_category_settings']) )
			{
				global $post_type;
				if($post_type=='post')
				{	
					echo "<script>
							jQuery(function($){
								$('#publish, #save-post').click(function(e){
									if($('#taxonomy-category input:checked').length==0){
										jQuery('[id^=\"categorydiv\"]').css( ".$rf_style." );
										alert('" . __(''.$opt['rf_cat_error'].'', 'require-post-category') . "');
										e.stopImmediatePropagation();
										return false;
									}else{
										return true;
									}
								});
								var publish_click_events = $('#publish').data('events').click;
								if(publish_click_events){
									if(publish_click_events.length>1){
										publish_click_events.unshift(publish_click_events.pop());
									}
								}
								if($('#save-post').data('events') != null){
									var save_click_events = $('#save-post').data('events').click;
									if(save_click_events){
									  if(save_click_events.length>1){
										  save_click_events.unshift(save_click_events.pop());
									  }
									}
								}
							});
							</script>";
				}
			}
			if ( isset($opt['rf_image_settings']) )
			{
				if (isset($opt['rf_for_page_enabled']) && isset($opt['rf_image_for_page']))
				{
					global $typenow;
					if(in_array($typenow, array('post','page')))
					{
						echo "<script language='javascript' type='text/javascript'>
							jQuery(document).ready(function() {
								jQuery('#post').submit(function() {
									if (jQuery('#set-post-thumbnail').find('img').size() > 0) {
										jQuery('#ajax-loading').hide();
										jQuery('#publish').removeClass('button-primary-disabled');
										return true;
									}else{
										jQuery('[id^=\'postimagediv\']').css( ".$rf_style." );
										alert('".$opt['rf_img_error']."');
										jQuery('#ajax-loading').hide();
										jQuery('#publish').removeClass('button-primary-disabled');
										return false;
									}
									return false;
								});
							});
						</script>";
					}
				}
				else
				{
					global $typenow;
					if(in_array($typenow, array('post')))
					{
						echo "<script language='javascript' type='text/javascript'>
							jQuery(document).ready(function() {
								jQuery('#post').submit(function() {
									if (jQuery('#set-post-thumbnail').find('img').size() > 0) {
										jQuery('#ajax-loading').hide();
										jQuery('#publish').removeClass('button-primary-disabled');
										return true;
									}else{
										jQuery('[id^=\'postimagediv\']').css( ".$rf_style." );
										alert('".$opt['rf_img_error']."');
										jQuery('#ajax-loading').hide();
										jQuery('#publish').removeClass('button-primary-disabled');
										return false;
									}
									return false;
								});
							});
						</script>";
					}
				}
			}
			
			if ( isset($opt['rf_tag_settings']) ) 
			{
				global $post_type;
				if($post_type=='post'){
					echo "<script>
					jQuery(function($){
						$('#publish, #save-post').click(function(e){
							if($('#post_tag .tagchecklist span').length==0){
								jQuery('[id^=\"tagsdiv-post_tag\"]').css( ".$rf_style." );
								alert('".$opt['rf_tag_error']."');
								e.stopImmediatePropagation();
								return false;
							}else{
								return true;
							}
						});
						var publish_click_events = $('#publish').data('events').click;
						if(publish_click_events){
							if(publish_click_events.length>1){
								publish_click_events.unshift(publish_click_events.pop());
							}
						}
						if($('#save-post').data('events') != null){
							var save_click_events = $('#save-post').data('events').click;
							if(save_click_events){
							  if(save_click_events.length>1){
								  save_click_events.unshift(save_click_events.pop());
							  }
							}
						}
					});
					</script>";
				}
			}
		}
	}
?>