<?php

namespace Deploy;

class ReportPlugins {

	public $message;

    public function init() {

				include_once ABSPATH . 'wp-admin/includes/plugin.php';

			  $remote_plugins = $this->get_remote_plugins();
				$remote_plugins = $this->get_remote_plugins_with_keys( $remote_plugins );
        $local_plugins = \get_plugins();

        // Compare the remote and local plugins
				$diff = $this->diff($local_plugins, $remote_plugins);

				// Create report output.
        $this->createReport($diff);
				$this->saveReport();
    }

    private function get_remote_plugins() {
        // Get the domain, key, and secret from ACF options
        $domain = get_field('domain', 'option');
        $key = get_field('key', 'option');
        $secret = get_field('secret', 'option');

        // Build the URL for the remote plugins endpoint
        $url = $domain . '/wp-json/wp/v2/plugins';

        // Set the arguments for the API call
        $args = [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode("$key:$secret"),
            ],
        ];

        // Make the API call
        $response = wp_remote_get($url, $args);



        // If the API call was successful, return the list of plugins
        if (is_array($response) && 200 === wp_remote_retrieve_response_code($response)) {
            $plugins = json_decode(wp_remote_retrieve_body($response), true);
            return $plugins;
        }

				// If the API call was not successful, return an empty array
        return [];


    }

		public function diff($local, $remote) {
			$diff = array();
			foreach ($local as $key => $value) {
				if (!isset($remote[$key])) {
					$diff[$key] = (object) array(
						'name' => $key,
						'status' => 'missing_from_remote'
					);
				}
			}
			foreach ($remote as $key => $value) {
				if (!isset($local[$key])) {
					$diff[$key] = (object) array(
						'name' => $key,
						'status' => 'missing_from_local'
					);
				}
			}
			return $diff;
		}

		private function get_remote_plugins_with_keys( $remote_plugins ) {

			// Adjust names so they match the local plugins list format.
			foreach ($remote_plugins as $key => $value) {
			  $remote_plugins[$key]['plugin'] = $remote_plugins[$key]['plugin'] . '.php';
			}

			// Add to new array with plugin name as keys.
	    $remote_plugins_with_keys = [];
	    foreach ( $remote_plugins as $remote_plugin ) {
	        $remote_plugins_with_keys[ $remote_plugin['plugin'] ] = $remote_plugin;
	    }
	    return $remote_plugins_with_keys;
		}

		public function createReport($diff) {
		  $message = '';
		  if (!empty($diff)) {
		    $message .= '<h3>Plugins Comparison Report</h3><ul>';
		    foreach ($diff as $plugin) {
		      $message .= '<li>' . $plugin->name . ' is ' . $plugin->status . '</li>';
		    }
		    $message .= '</ul>';
		  } else {
		    $message = '<h3>No differences found between local and remote plugins.</h3>';
		  }
		  $this->message = $message;
		}

		public function saveReport() {
			update_field('message_text', $this->message, 'option');
		}


}
