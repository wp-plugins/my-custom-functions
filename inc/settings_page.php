<?php

defined('ABSPATH') or die("Restricted access!");

/**
 * Render Settings Page
 *
 * @since 1.0
 */
function anarcho_cfunctions_render_submenu_page() {

	// Variables
	$options = get_option( 'anarcho_cfunctions_settings' );
	$content = isset( $options['anarcho_cfunctions-content'] ) && ! empty( $options['anarcho_cfunctions-content'] ) ? $options['anarcho_cfunctions-content'] : '/* Enter Your Custom Functions Here */';
        $error = get_option( 'anarcho_cfunctions_error' );

	// Settings update message
	if ( isset( $_GET['settings-updated'] ) ) :
		?>
			<div id="message" class="updated">
				<p>
					<?php _e( 'Custom functions updated successfully.', 'anarcho_cfunctions' ); ?>
				</p>
			</div>
		<?php
	endif;

	// Error message
	if ( $error == '1' ) :
                ?>
                        <div id="message" class="error">
				<p>
					<?php _e( 'Sorry, but your code causes a "Fatal error", so it is not applied!', 'anarcho_cfunctions' ); ?><br/>
					<?php _e( 'Please, check the code and try again.', 'anarcho_cfunctions' ); ?>
				</p>
			</div>
                <?php
	endif;

	// Page
	?>
	   <div class="wrap">
		<h2 style="margin-bottom: 1em;"><?php _e( 'My Custom Functions', 'anarcho_cfunctions' ); ?></h2>
		<form name="anarcho_cfunctions-form" action="options.php" method="post" enctype="multipart/form-data">
			<?php settings_fields( 'anarcho_cfunctions_settings_group' ); ?>
			<!-- Sidebar -->
			 <div id="templateside">
				<?php do_action( 'anarcho_cfunctions-sidebar-top' ); ?>
				<p style="margin-top: 0">
					<?php _e( 'This plugin allows you to EASILY and SAFELY add your own functions, snippets or any custom code to your site.', 'anarcho_cfunctions' ) ?>
				</p>
				<p>
					<?php _e( 'To use, enter your custom functions, then click "Update Custom Functions". It\'s that simple!', 'anarcho_cfunctions' ) ?>
				</p>
				<?php submit_button( __( 'Update Custom Functions', 'anarcho_cfunctions' ), 'primary', 'submit', true ); ?>
                                <p style="margin-top:20px; border:1px solid rgb(184, 186, 184); border-radius:5px; padding:3px; text-align:center; background:rgb(234, 234, 234);">If you find it useful, consider making a donation:
                                        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JG3SB73K86FA8" target="_blank" rel="nofollow">
                                                <img src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" alt="Make a donation">
                                        </a>
                                </p>
				<?php do_action( 'anarcho_cfunctions-sidebar-bottom' ); ?>
			 </div>
                        <!-- END-Sidebar -->
                        <!-- Form -->
			 <div id="template">
				<?php do_action( 'anarcho_cfunctions-form-top' ); ?>
				<div>
					<textarea cols="70" rows="30" name="anarcho_cfunctions_settings[anarcho_cfunctions-content]" id="anarcho_cfunctions_settings[anarcho_cfunctions-content]" ><?php echo esc_attr( $content ); ?></textarea>
				</div>
				<?php do_action( 'anarcho_cfunctions-textarea-bottom' ); ?>
				<div>
					<?php submit_button( __( 'Update Custom Functions', 'anarcho_cfunctions' ), 'primary', 'submit', true ); ?>
				</div>
				<?php do_action( 'anarcho_cfunctions-form-bottom' ); ?>
			 </div>
                        <!-- END-Form -->
		</form>
	   </div>
	<?php
}
