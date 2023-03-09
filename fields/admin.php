<?php

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'title' => 'Deploy Settings',
        'fields' => array(
						array(
						    'key' => 'field_domain',
						    'label' => 'Domain',
						    'name' => 'domain',
						    'type' => 'url',
						),
            array(
                'key' => 'field_key',
                'label' => 'Key',
                'name' => 'key',
                'type' => 'text',
            ),
            array(
                'key' => 'field_secret',
                'label' => 'Secret',
                'name' => 'secret',
                'type' => 'text',
            ),
            array(
                'key' => 'field_message',
                'label' => 'Message',
                'name' => 'message',
                'type' => 'message',
                'message' => 'No report.',
            ),
						array(
                'key' => 'field_message_text',
                'label' => 'Message',
                'name' => 'message_text',
                'type' => 'textarea',
                'default' => 'No report.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'deploy',
                ),
            ),
        ),
    ));
}
