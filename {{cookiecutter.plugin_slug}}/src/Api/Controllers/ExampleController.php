<?php
namespace {{ cookiecutter.php_namespace }}\Api\Controllers;

use WP_REST_Request;
use WP_REST_Response;

if (!defined('ABSPATH')) exit;

Class ExampleController
{
    public function register_routes()
    {
        // Register your REST API routes here
    }

    public function get_example_data(WP_REST_Request $request): WP_REST_Response
    {
        // Handle GET request and return data
        return new WP_REST_Response(['message' => 'Example data'], 200);
    }
}
