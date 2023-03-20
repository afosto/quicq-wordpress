<?php
/**
* Displays plugin settings.
*
* @since 1.0.0
*/ 
$data = isset( $data ) ? $data : new stdClass();
$dir = WPQAI_ASSETS;
?>
<div class="afosto-topbar">
	<div class="afosto-topbar-img">
		<img src="<?php echo esc_url( $dir ); ?>images/quicq-afosto.png" />
	</div>
	<div class="afosto-doc-links">
		<a href="https://afosto.com/docs/apps/quicq/" class="afosto-link" target="_blank"><img src="<?php echo esc_url( $dir ); ?>images/Documentation.svg" > <?php _e('Documentation','quicq'); ?></a>
	</div>
</div>
<div class="afosto-wrapper">
    <div class="afosto-head">
      <div class="afosto-row">
        <div class="col-content">
          <h3><?php _e('Boost your website','quicq'); ?></h3>
          <p><?php _e('Compress images and improve your pagespeed with Quicq.','quicq'); ?></p>
        </div>
      	<div class="col-img"><img src="<?php echo esc_url( $dir ); ?>images/powered-by.png" ></div>
      </div>
    </div>
    <!--  -->
    <div class="afosto-card">
	    <div class="afosto-row">
	      <div class="col-content">
	        <div class="card-label"><?php _e('Connect to Afosto','quicq'); ?></div>
	        <p><?php _e('Connect or create your Afosto account to optimize all of your images.','quicq'); ?></p>
	      </div>
	      <div class="col-action">
			<?php 
			$f = 0;
			$origin_url = site_url();
			$return_url = site_url() . "/wp-admin/admin.php?page=wp-quicq-afosto-settings";
			$site_name = get_bloginfo( 'name' );
			$cdn_key = get_option( 'wpqai_quicq_afosto_key' );
			$CSSclass = "hide";
			?> 
				<a class="afosto-btn btn-disconnect <?php if(!empty($cdn_key)){}else{ echo $CSSclass; } ?>"  href="#0"><?php _e('Disconnect','quicq'); ?></a>
				<a class="afosto-btn btn-fill btn-connect <?php if(!empty($cdn_key)){ echo $CSSclass; } ?>" href="https://afosto.app/api/onboarding/quicq?origin_url=<?php echo urlencode($origin_url); ?>&return_url=<?php echo urlencode($return_url); ?>&name=<?php echo urlencode($site_name); ?>" target="_blank" ><?php _e('Connect to Afosto','quicq'); ?></a>
			
	      </div>
	    </div>
  	</div>
  <!--  -->
  	<div class="afosto-card">
	   <div class="afosto-row">
		    <div class="col-content">
		      <div class="card-label"><?php _e('Enable Quicq on your website','quicq'); ?></div>
		      <p><?php _e('Enable Quicq to serve all of your images via our lightning-fast CDN.','quicq'); ?></p>
		    </div>
		    <div class="col-action">
		      <div class="afosto-switch-wrap">
		        <input type="checkbox" name="enable" id="enable" <?php echo $data->is_enabled; ?>  <?php if(!empty($cdn_key)){ echo $data->is_checked; } ?>>
		        <span class="afosto-switch"></span>
		      </div>
		    </div>
	  </div>
	</div>

	<div class="afosto-card">
	  <div class="card-title">
	  <?php _e('Your CDN','quicq'); ?> <?php //echo $data->active; ?>
	  </div>
	  	<div class="afosto-row">
	  		<?php if($data->cdn_key){ ?>
				<div class="cdn-col">
					<div class="cdn-label"><?php _e('URL key','quicq'); ?></div>
					<p><?php echo $data->cdn_key; ?></p>
				</div>
				<div class="cdn-col">
					<div class="cdn-label"><?php _e('URL','quicq'); ?></div>
					<p><?php echo $data->uploaded_url."/*"; ?></p>
				</div>
				<div class="cdn-col">
					<div class="cdn-label"><?php _e('Operational','quicq'); ?></div>
					<div class="operational"><span class="status-indicator" <?php if(!empty($data->is_checked)){ ?> style="background: #027845" <?php }else{ ?> style="background: #DFE5EB" <?php } ?>> </span> 
						<div class="optext">						
							<?php 
								if(!empty($data->is_checked)){ 
									_e('Operational','quicq'); 
								}else{  
									_e('Non-Operational','quicq'); 
								} 
							?>
						</div>
					</div>
				</div>
			<?php }else{ ?>
					<p><?php _e('Connect to Afosto en install your first CDN','quicq'); ?></p>
			<?php } ?>
	  	</div>
	</div>

	<!--  -->
	<?php if(!empty($cdn_key)){ ?>
	<div class="afosto-card">
		  <div class="card-title">
		  <?php _e('Useful links','quicq'); ?>
		  </div>
		  <div class="afosto-row">
		    <div class="col-content">
		      <div class="afosto-links">
			  	<a href="https://afosto.app/analytics" class="afosto-link" target="_blank"><img src="<?php echo esc_url( $dir ); ?>images/Analytics.svg" > <?php _e('Analytics','quicq'); ?></a>
				<a href="https://admin.afosto.app/company/contract" class="afosto-link" target="_blank"><img src="<?php echo esc_url( $dir ); ?>images/MyCompany.svg" > <?php _e('My Company','quicq'); ?></a>
		        <a href="mailto:support@afosto.com?subject=Quicq WP Plugin Support&body=Hi Afosto, I have a question regarding your WordPress Quicq Plugin. Could you help me with the following:" class="afosto-link" target="_blank"><img src="<?php echo esc_url( $dir ); ?>images/Support.svg" > <?php _e('Support','quicq'); ?></a>
		      </div>
		    </div>
		  </div>
	</div>
	<?php } if($data->status == 'added'): ?>
		<div class="pop-overlay">
		  <div class="pop-box">
		    <div class="pop-content">
		      <h4 class="pop-label"><?php _e('Start optimizing your images','quicq'); ?></h4>
		      <p><?php _e('Click on start now to enable Quicq on your website and start optimize all of your images through our lightning-fast CDN. Your images will be optimized for all visitors and devices.','quicq'); ?></p>
		    </div>
		    <div class="pop-footer">
		      <button type="cancle" class="pop-dismiss afosto-btn btn-outline" id="cancle-btn"><?php _e("I'll enable it later","quicq-afosto"); ?></button>
		      <button type="cancle" class="afosto-btn btn-fill" id="start-btn"><?php _e('start now','quicq'); ?></button>
		    </div>
		  </div>
		</div>
	<?php endif; ?>
</div>