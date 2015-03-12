<?php

/**
 * Theme Dependency Admin Notice
 * 
 * @return string | admin notices asking user to install plugins which the theme requires
 */
function s2_theme_plugin_dependency() {

	// The filter where all plugins needed will be passed
	$plugin_slugs = apply_filters( 's2_plugin_dependencies', array() );

	foreach ( $plugin_slugs as $slug => $data ) {

		// if the plugin is not active display the notice
	    if ( is_plugin_active( $data['plugin_path'] ) ) {
	    	continue;
	    }
	 
	 	// the URL for the thickbox
		$thickbox_url = sprintf( 'plugin-install.php?tab=plugin-information&plugin=%s&TB_iframe=true&width=600&height=550', $slug );

		if ( is_multisite() ) {
			$url = network_admin_url( $thickbox_url );
		} else {
			$url = admin_url( $thickbox_url  );
		}

		// the link in the notice which refers to the thickbox
		$link_string = sprintf( '<a href="%1$s" class="thickbox">%2$s</a>', esc_url( $url ), $data['name'] );
		
	    ?>
	    <div class="updated">
	        <p><?php printf( __( 'This theme requires the %s plugin' ), $link_string ); ?></p>
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
function my_plugin_dependencies( $plugins ) {

	$plugins['cmb2'] = array(             // the plugin slug
		'name'        => 'CMB2',          // the plugin nice name
		'plugin_path' => 'cmb2/init.php', // the path to the initial plugin file
	);

	// add another plugin :)
	$plugins['akismet'] = array(
		'name'        => 'Akismet',
		'plugin_path' => 'akismet/akismet.php',
	);

	return $plugins;
}
add_filter( 's2_plugin_dependencies', 'my_plugin_dependencies' );
