<?php

namespace {{ cookiecutter.php_namespace }}\Core;

if (!defined('ABSPATH')) exit;

/**
 * Loads the plugin text domain for translations.
 */
class I18n
{
    public function load_plugin_textdomain(): void
    {
        $relative_path = dirname(dirname(dirname(plugin_basename(__FILE__)))) . '/languages/';
        load_plugin_textdomain(
            Config::TEXT_DOMAIN,
            false,
            $relative_path
        );
    }
}
