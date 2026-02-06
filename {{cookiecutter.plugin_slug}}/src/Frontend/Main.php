<?php

namespace {{ cookiecutter.php_namespace }}\Frontend;

if (!defined('ABSPATH')) exit;

class Main
{
    private const JS_PATH = 'src/Frontend/build/assets/bundle.js';
    private const CSS_PATH = 'src/Frontend/build/assets/bundle.css';

    public function init(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts(): void
    {
        if (isset($_GET['ct_builder']) || defined('OXYGEN_IFRAME')) {
            return;
        }

        $base = {{ cookiecutter.plugin_slug|replace('-','_')|upper }}_WP_PLUGIN_DIR;
        $url  = {{ cookiecutter.plugin_slug|replace('-','_')|upper }}_WP_PLUGIN_URL;

        if (!file_exists($base . self::JS_PATH)) {
            return;
        }

        wp_enqueue_script(
            '{{ cookiecutter.plugin_slug }}-frontend-script',
            $url . self::JS_PATH,
            [],
            {{ cookiecutter.plugin_slug|replace('-','_')|upper }}_VERSION,
            true
        );

        if (file_exists($base . self::CSS_PATH)) {
            wp_enqueue_style(
                '{{ cookiecutter.plugin_slug }}-frontend-style',
                $url . self::CSS_PATH,
                [],
                {{ cookiecutter.plugin_slug|replace('-','_')|upper }}_VERSION
            );
        }

        wp_localize_script(
            '{{ cookiecutter.plugin_slug }}-frontend-script',
            '{{ cookiecutter.plugin_slug }}',
            [
                'root'  => esc_url_raw(rest_url('{{ cookiecutter.plugin_slug }}/v1/')),
                'nonce' => wp_create_nonce('wp_rest'),
            ]
        );
    }
}
