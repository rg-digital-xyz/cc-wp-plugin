<?php

namespace {{ cookiecutter.php_namespace }}\Api;

use {{ cookiecutter.php_namespace }}\Api\Controllers\ExampleController;

if (!defined('ABSPATH')) exit;

class Api
{
    public function init(): void
    {
        add_action('rest_api_init', function (): void {
            (new ExampleController())->register_routes();
        });
    }
}
