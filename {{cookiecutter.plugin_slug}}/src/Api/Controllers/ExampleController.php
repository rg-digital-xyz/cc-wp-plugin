<?php

namespace {{ cookiecutter.php_namespace }}\Api\Controllers;

use {{ cookiecutter.php_namespace }}\Api\Interfaces\RESTControllerInterface;
use {{ cookiecutter.php_namespace }}\Api\Traits\ControllerHelpers;
use {{ cookiecutter.php_namespace }}\Core\Config;
use WP_REST_Request;
use WP_REST_Response;

if (!defined('ABSPATH')) exit;

class ExampleController implements RESTControllerInterface
{
    use ControllerHelpers;

    public function register_routes(): void
    {
        register_rest_route(Config::REST_NAMESPACE, '/example', [
            'methods'             => 'GET',
            'callback'            => [$this, 'get_example_data'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function get_example_data(WP_REST_Request $request): WP_REST_Response
    {
        return $this->success_response(['message' => 'Example data'], 200);
    }
}
