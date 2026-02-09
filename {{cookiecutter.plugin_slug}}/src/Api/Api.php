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

    /**
     * Register AJAX handlers. Override in your plugin to add wp_ajax_* actions.
     */
    public function register_ajax_handlers(): void
    {
        // Add your AJAX actions here, e.g. add_action('wp_ajax_my_action', [...]);
    }
}
