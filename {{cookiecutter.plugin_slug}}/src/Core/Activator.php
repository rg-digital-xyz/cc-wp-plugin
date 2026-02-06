<?php

namespace {{ cookiecutter.php_namespace }}\Core;

if (!defined('ABSPATH')) exit;

/**
 * Handles plugin activation (e.g. options, caps, flush rewrite rules).
 */
class Activator
{
    public static function activate(): void
    {
        // Add activation logic here (e.g. default options, custom roles).
        // flush_rewrite_rules();
    }
}
