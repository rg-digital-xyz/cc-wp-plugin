<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @package {{ cookiecutter.php_namespace }}
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

if (!current_user_can('activate_plugins')) {
    return;
}

// Optionally remove plugin data. Uncomment and adjust option keys as needed.
// delete_option('{{ cookiecutter.plugin_slug }}_settings');
// flush_rewrite_rules();
