<?php

namespace {{ cookiecutter.php_namespace }}\Api;

if (!defined('ABSPATH')) exit;

Class Api
{
    public function init()
    {
        add_action('rest_api_init', function () {
            // controller class
        });
    }
}
