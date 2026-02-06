<?php

namespace {{ cookiecutter.php_namespace }}\Api\Interfaces;

if (!defined('ABSPATH')) exit;

/**
 * Contract for REST API controllers. Ensures consistent route registration.
 */
interface RESTControllerInterface
{
    public function register_routes(): void;
}
