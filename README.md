## S2 Plugin Dependencies

A super simple lightweight way to add admin notices to your theme when the theme requires a couple plugins for certain functionality. The notices will appear when the plugins required are inactive. An admin notice will appear and provide a link to the plugin installation window. That's it. 

No warning notices, no error messages, just a nice way of saying, "Hey, you need this for things to work right."

### Installing

1. Add the functions in the `plugin-support.php` file in your theme.
2. Edit the `s2_plugins_required` function and add the plugins needed for your theme as shown below.

Here is an example of adding the CMB2 plugin:
```
$plugins['cmb2'] = array(             // the plugin slug
	'name'        => 'CMB2',          // the plugin nice name
	'plugin_path' => 'cmb2/init.php', // the path to the initial plugin file
);
```

Version: 1.0
