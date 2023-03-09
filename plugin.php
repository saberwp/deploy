<?php
/**
 * Plugin Name: Deploy
 * Description: A sample plugin to demonstrate the plugin structure and activation hook.
 * Version: 1.0.0
 * Author: SaberWP
 * Author URI: https://saberwp.com
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Deploy;

class Plugin {

    public function __construct() {

			// Include admin class.
			require_once plugin_dir_path(__FILE__) . '/inc/Admin.php';

			// Create an instance of the Admin class and call the init() method
			$admin = new Admin();
			$admin->init();

			// Add field group.
			require_once plugin_dir_path(__FILE__) . '/fields/admin.php';

			// Include connect class.
			require_once plugin_dir_path(__FILE__) . '/inc/Connect.php';
			$connect = new Connect();
			$connect->init();

			// Report on plugins.
			require_once plugin_dir_path(__FILE__) . '/inc/ReportPlugins.php';
			$ReportPlugins = new ReportPlugins();
			$ReportPlugins->init();

			// Show report as HTML in message field.
			add_filter('acf/prepare_field/key=field_message', function($field) {
				$field['message'] = get_field('message_text', 'options');
				return $field;
			});

    }
}

// Create an instance of the Plugin class and store it in the $plugin variable
$plugin = new \Deploy\Plugin();

/*
 * WordPress Installation Hook
 *
 * The following code is executed during the installation of the plugin.
 */
register_activation_hook(__FILE__, function() use ($plugin) {
    // Plugin activation code goes here
});
