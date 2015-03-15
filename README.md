## Pleasant Plugin Notices

A super simple way to add admin notices to a theme that requires plugins for certain functionality. The notices will appear when the plugins you include are inactive.

That's it!

No forced downloads, no fetching, just a nice way of suggesting, "Hey, you might need this plugin."

### Installing

1. Download the library to your theme
2. In your functions.php file, include the library and initialize it
	```php
	if ( is_admin() ){
		include_once get_stylesheet_directory().'/path-to-library/plugin-support.php';
	}
	```

3. Add a filter for `pleasant_plugin_notices` function.
	```php
	function my_theme_dependencies( $plugins ){
		return $plugins;
	}
	add_filter( 'pleasant_plugin_notices', 'my_theme_dependencies' );
	```

4. And add each dependency to the `$plugins` array along with its details.
	```php
	$plugins['plugin-slug'] = array(

		/**
		 * not necessary for plugins in the WP.org repo, but can be used if desired
		 * defaults to plugin-slug
		 */
		'name' => 'Plugin Nice Name',

		/**
		 * required for public, non-repo plugins.
		 * should be a website where the plugin can be purchased or downloaded
		 */
		'plugin_url' => 'http://example.com',

		/** 
		 * default to true
		 * set as false if the plugin can not be downloaded from a website
		 */
		'public' => true,

		/**
		 * override the default plugin download notice with your own text & html
		 */
		'notice' => 'This text will completely override the admin notice. It can accept <a href="http://example.com">anchor tags</a>, line breaks, <em>emphasis</em>, and <strong>strong words</strong>.',
	);
	```

### A complete example, using CMB2.

```php
if ( is_admin() ){
	include_once get_stylesheet_directory() . '/path-to-library/plugin-support.php';
}

function my_theme_dependencies( $plugins ){
	$plugins['cmb2'] = array(
		'name' => 'CMB2',
	);
	return $plugins;
}
add_filter( 'pleasant_plugin_notices', 'my_theme_dependencies' );	
```

## Version: 1.0

