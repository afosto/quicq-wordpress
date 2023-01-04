/* custom JS for plugin */
var wpqai_script;
jQuery(function($){

	wpqai_script = {
		init: function(){
			//this.handleRequest.setFormData();
			$('.afosto-wrapper').on('click',".afosto-switch-wrap #enable", this.handleRequest.enableQuicqAfosto);
			$('.afosto-wrapper').on('click',".pop-box #cancle-btn", this.handleRequest.cancleQuicqAfosto);
			$('.afosto-wrapper').on('click',".pop-box #start-btn", this.handleRequest.startQuicqAfosto);
			$('.afosto-wrapper').on('click',".btn-disconnect", this.handleRequest.disconnectAfosto);
		},
		handleRequest:{
			setFormData: function(){
				var url = window.location.href;
				if (url.indexOf("cdn_root") >= 0){
					jQuery('.afosto-wrapper .error.notice').remove();
					$.ajax({
                        method: "POST",
                        url: wpqai.ajaxurl,
                        data: { action: "wpqai_load_setting_data"},
                        success: function( result ){  
                            if(result.success){
                                $(".afosto-wrapper").html(result.data.html);    
                            }
                        }
                	}).fail(function (jqXHR, textStatus, errorThrown) {
                   		jQuery('.afosto-head').before('<div class="error notice"><p>Something went wrong.</p></div>');
                	}).always(function(jqXHR, textStatus, errorThrown) {
                		settingPage = wpqai.setting_page_url;
                		history.pushState('', '', settingPage);
                	});
				}
			},

			enableQuicqAfosto: function(e){	
				if($(".afosto-btn.hide").hasClass("btn-disconnect")){
					$("#enable").prop('checked', false);
				}
				else{
					jQuery('.afosto-wrapper .error.notice').remove();
					if(this.checked) {
						var checked = 1;
						jQuery(".status-indicator").css("background", "#027845");
						jQuery(".optext").text("Operational");
					}else{
						var checked = 0;
						jQuery(".status-indicator").css("background", "#DFE5EB");
						jQuery(".optext").text("Non-Operational");
					}
					$.ajax({
						method: "POST",
						url: wpqai.ajaxurl,
						data: { action: "wpqai_enable_quicq_afosto", checked:checked},
						success: function( result ){  
							if(!result.success){
								if(checked == 1){
									$("#enable").prop('checked', false);
								}else{
									$("#enable").prop('checked', true);
								}
								jQuery('.afosto-head').before('<div class="error notice"><p>'+result.data+'</p></div>');
							}
						}
					}).fail(function (jqXHR, textStatus, errorThrown) {
						if(checked == 1){
							$("#enable").prop('checked', false);
						}else{
							$("#enable").prop('checked', true);
						}
						jQuery('.afosto-head').before('<div class="error notice"><p>Facing issues while enabling Quicq Afosto.</p></div>');
					});
				}								
			},

			cancleQuicqAfosto: function(e){
				e.preventDefault();
				$(".afosto-wrapper .pop-overlay").hide();
				$.ajax({
                    method: "POST",
                    url: wpqai.ajaxurl,
                    data: { action: "wpqai_change_quicq_afosto_status"},
                    success: function( result ){  
                    	settingPage = wpqai.setting_page_url;
                		history.pushState('', '', settingPage);
                    }
            	})
			},

			startQuicqAfosto: function(e){
				e.preventDefault();
				$(".afosto-switch-wrap #enable").trigger('click');
				settingPage = wpqai.setting_page_url;
               	history.pushState('', '', settingPage);
				$(".afosto-wrapper .pop-overlay").hide();
			},

			disconnectAfosto: function(e){
				e.preventDefault();
				$("#enable").prop('checked', false);
				$.ajax({
                    method: "POST",
                    url: wpqai.ajaxurl,
                    data: { action: "wpqai_disconnect_quicq_afosto"},
                    success: function( result ){  
                    	$(".btn-disconnect").addClass("hide");
						$(".btn-connect").removeClass("hide");
                    }
            	})
			}
		}
	}
	wpqai_script.init();
});