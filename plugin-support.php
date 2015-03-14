<?php

function s2_get_plugin_data_from_slug( $plugin_slug ) {

    if ( ! function_exists('get_plugins') ){
    	require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugin_data = FALSE;

	$plugins = get_plugins( '/' . $plugin_slug ); // Retrieve all plugins.

	if  ( ! empty( $plugins ) ){
		$plugin_keys = array_keys( $plugins ); 
		$plugin_data = array_shift( $plugins );
		$plugin_data['plugin_file'] = $plugin_slug . '/' . $plugin_keys[0];
	}
	
	return $plugin_data;

}

/**
 * Theme Dependency Admin Notice
 * 
 * @return string | admin notices asking user to install plugins which the theme requires
 */
function s2_theme_plugin_dependency() {

	// The filter where all plugins needed will be passed
	$plugin_slugs = apply_filters( 's2_plugin_dependencies', array() );

	foreach ( $plugin_slugs as $slug => $data ) {

		$plugin_data = s2_get_plugin_data_from_slug( $slug );

		// if the plugin is not active display the notice
		if ( $plugin_data && isset( $plugin_data['plugin_file'] ) && is_plugin_active( $plugin_data['plugin_file'] ) ) {
			continue;
		}

		if ( ! isset( $data['notice'] ) ) {

			if ( ! isset( $data['plugin_url'] ) ) {
				// the URL for the thickbox
				$thickbox_url = sprintf( 'plugin-install.php?tab=plugin-information&plugin=%s&TB_iframe=true&width=600&height=550', $slug );

				if ( is_multisite() ) {
					$url = network_admin_url( $thickbox_url );
				} else {
					$url = admin_url( $thickbox_url  );
				}			

			} else {

				$url = $data['plugin_url'];
			}

			if  ( ! isset( $data['name'] ) && isset( $plugin_data['Name'] ) ){
				$data['name'] = $plugin_data['Name'];
			}

			if ( isset( $data['public'] ) && $data['public'] === false ) {
				$link_string = $data['name'];
			}
			else {
				// the link in the notice which refers to the thickbox
				$link_string = sprintf( '<a href="%1$s" class="thickbox">%2$s</a>', esc_url( $url ), $data['name'] );
			}
			
			// get the notice text
			$notice_text = sprintf( __( 'This theme requires the %s plugin' ), $link_string );

		} else { 

			$allowed_html = array(
				'a' => array(
			        'href' => array(),
			        'title' => array()
			    ),
			    'br' => array(),
			    'em' => array(),
			    'strong' => array(),
			);

			$notice_text = wp_kses( $data['notice'], $allowed_html );

		}
		
		?>
		<div class="error">
			<h5>Theme dependency warning<h5>
			<p><?php echo $notice_text; ?></p>
		</div>
		<?php

	}

}
add_action( 'admin_notices', 's2_theme_plugin_dependency' );


/**
 * The Plugins which are required by this theme
 * 
 * @param  array 	$plugins  Plugins required for theme
 * @return array    Plugins to be passed in the s2_theme_plugin_dependency
 */
function s2_plugins_required( $plugins ) {

	$plugins['plugin-slug'] = array(
		// not necessary for plugins in the WP.org repo, but can be used if desired
		// require for non-repo plugins
		'name' => 'Plugin Nice Name',
		// required for non-repo plugins.
		// should be a website where the plugin can be purchased or downloaded
		'plugin_url' => 'http://sweetplugin.com',
		// default to true, set as false if the plugin can not be downloaded from a website
		'public' => true,
		// override the default plugin download notice with your own text & html
		'notice' => 'This text will completely override the admin notice. It can accept <a href="http://example.com">anchor tags</a>, line breaks, <em>emphasis</em>, and <strong>strong words</strong>.',
	);

	$plugins['cmb2'] = array();

	$plugins['soliloquy'] = array(            
		'name'        => 'Soliloquy',         
		'plugin_url'  => 'http://soliloquywp.com', 
	);

	$plugins['s2-profiles'] = array(
		'public' => false,
	);

	return $plugins;
}
add_filter( 's2_plugin_dependencies', 's2_plugins_required' );
