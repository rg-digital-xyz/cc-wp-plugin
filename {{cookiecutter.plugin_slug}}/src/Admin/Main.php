<?php

namespace {{ cookiecutter.php_namespace }}\Admin;

if (!defined('ABSPATH')) exit;

class Main
{
    private const JS_PATH = 'src/Admin/build/assets/bundle.js';
    private const CSS_PATH = 'src/Admin/build/assets/bundle.css';

    public function init(): void
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts(): void
    {
        $base = {{ cookiecutter.plugin_slug|replace('-','_')|upper }}_WP_PLUGIN_DIR;
        $url  = {{ cookiecutter.plugin_slug|replace('-','_')|upper }}_WP_PLUGIN_URL;

        if (!file_exists($base . self::JS_PATH)) {
            return;
        }

        wp_enqueue_script(
            '{{ cookiecutter.plugin_slug }}-admin-script',
            $url . self::JS_PATH,
            [],
            {{ cookiecutter.plugin_slug|replace('-','_')|upper }}_VERSION,
            true
        );

        if (file_exists($base . self::CSS_PATH)) {
            wp_enqueue_style(
                '{{ cookiecutter.plugin_slug }}-admin-style',
                $url . self::CSS_PATH,
                [],
                {{ cookiecutter.plugin_slug|replace('-','_')|upper }}_VERSION
            );
        }

        wp_localize_script(
            '{{ cookiecutter.plugin_slug }}-admin-script',
            '{{ cookiecutter.plugin_slug }}',
            [
                'root'  => esc_url_raw(rest_url('{{ cookiecutter.plugin_slug }}/v1/')),
                'nonce' => wp_create_nonce('wp_rest'),
            ]
        );
    }
}
