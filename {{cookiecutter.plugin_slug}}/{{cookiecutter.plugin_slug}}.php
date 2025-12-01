<?php
/**
 * Plugin Name: {{ cookiecutter.plugin_name }}
 * Description: {{ cookiecutter.plugin_description }}
 * Author: {{ cookiecutter.author_name }}
 * Author URI: {{ cookiecutter.author_uri }}
 * Text Domain: {{ cookiecutter.plugin_slug }}
 */

if (!defined('ABSPATH')) exit;

define('{{ cookiecutter.plugin_slug|upper }}_VERSION', '1.0.0');
define('{{ cookiecutter.plugin_slug|upper }}_WP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('{{ cookiecutter.plugin_slug|upper }}_WP_PLUGIN_URL', plugin_dir_url(__FILE__));

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} else {
    wp_die('Please run "composer install" from the plugin root directory.');
}

/**
 * Plugin activation
 */
register_activation_hook(__FILE__, function () {
});

/**
 * Plugin deactivation
 */
register_deactivation_hook(__FILE__, function () {
});

use {{ cookiecutter.php_namespace }}\Core\Loader;

/**
 * Plugin boot
 */
add_action('plugins_loaded', function () {
    (new Loader())->run();
});
