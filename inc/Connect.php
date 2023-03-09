<?php

namespace Deploy;

class Connect
{
    public function init()
    {
        $domain = get_field('domain', 'option');
        $key = get_field('key', 'option');
        $secret = get_field('secret', 'option');

				$url = $domain . '/wp-json/wp/v2/users/me';
				$args = array(
				  'headers' => array(
				    'Authorization' => 'Basic ' . base64_encode( $key . ':' . $secret ),
				  ),
				);
				$response = wp_remote_get( $url, $args );

				// Check for errors
				if ( is_wp_error( $response ) ) {
				  //echo 'Error: ' . $response->get_error_message();
				  //die();
				}

				// Check the status code
				if ( wp_remote_retrieve_response_code( $response ) !== 200 ) {
				  //echo 'Error: Unexpected status code ' . wp_remote_retrieve_response_code( $response );
				  //die();
				}

    }
}
