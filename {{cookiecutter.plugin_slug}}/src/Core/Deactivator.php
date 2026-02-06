<?php

namespace {{ cookiecutter.php_namespace }}\Core;

if (!defined('ABSPATH')) exit;

/**
 * Handles plugin deactivation (e.g. clear scheduled events, flush rules).
 */
class Deactivator
{
    public static function deactivate(): void
    {
        // Add deactivation logic here (e.g. wp_clear_scheduled_hook, flush_rewrite_rules).
    }
}
