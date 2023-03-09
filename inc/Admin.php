<?php

namespace Deploy;

class Admin {

    public function init() {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title' => 'Deploy',
                'menu_title' => 'Deploy',
                'menu_slug' => 'deploy',
                'capability' => 'edit_posts',
                'redirect' => false
            ));
        }
    }
}
