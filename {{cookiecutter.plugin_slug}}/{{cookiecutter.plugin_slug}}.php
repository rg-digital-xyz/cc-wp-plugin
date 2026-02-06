<?php
/**
 * Plugin Name: {{ cookiecutter.plugin_name }}
 * Description: {{ cookiecutter.plugin_description }}
 * Version: {{ cookiecutter.version }}
 * Author: {{ cookiecutter.author_name }}
 * Author URI: {{ cookiecutter.author_uri }}
 * Text Domain: {{ cookiecutter.plugin_slug }}
 * Domain Path: /languages
 * License: {{ cookiecutter.license }}
 * License URI: {{ cookiecutter.license_uri }}
 * Requires at least: {{ cookiecutter.requires_at_least }}
 * Requires PHP: {{ cookiecutter.requires_php }}
 */

if (!defined('ABSPATH')) exit;

define('{{ cookiecutter.plugin_slug|replace('-','_')|upper }}_VERSION', '{{ cookiecutter.version }}');
define('{{ cookiecutter.plugin_slug|replace('-','_')|upper }}_WP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('{{ cookiecutter.plugin_slug|replace('-','_')|upper }}_WP_PLUGIN_URL', plugin_dir_url(__FILE__));

$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    add_action('admin_init', function (): void {
        if (!current_user_can('activate_plugins')) {
            return;
        }
        if (function_exists('deactivate_plugins')) {
            deactivate_plugins(plugin_basename(__FILE__));
        }
    });
    add_action('admin_notices', function (): void {
        if (!current_user_can('activate_plugins')) {
            return;
        }
        echo '<div class="notice notice-error"><p>';
        echo esc_html__('This plugin is missing dependencies. Please run "composer install" in the plugin directory, then re-activate.', '{{ cookiecutter.plugin_slug }}');
        echo '</p></div>';
    });
    return;
}

require $autoload;

use {{ cookiecutter.php_namespace }}\Core\Activator;
use {{ cookiecutter.php_namespace }}\Core\Deactivator;
use {{ cookiecutter.php_namespace }}\Core\Loader;

register_activation_hook(__FILE__, function (): void {
    Activator::activate();
});

register_deactivation_hook(__FILE__, function (): void {
    Deactivator::deactivate();
});

add_action('plugins_loaded', function (): void {
    (new Loader())->run();
}, 10);
