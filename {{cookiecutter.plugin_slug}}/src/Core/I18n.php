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
        load_plugin_textdomain(
            '{{ cookiecutter.plugin_slug }}',
            false,
            dirname(plugin_basename({{ cookiecutter.plugin_slug|replace('-','_')|upper }}_WP_PLUGIN_DIR)) . '/languages'
        );
    }
}
