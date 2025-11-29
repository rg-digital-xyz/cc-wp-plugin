<?php

namespace {{ cookiecutter.php_namespace }}\Frontend;

if (!defined('ABSPATH')) exit;

Class Main
{
    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts()
    {
        // Prevent loading scripts in oxygen page builders
        if (isset($_GET['ct_builder']) || defined('OXYGEN_IFRAME')) {
            return;
        }

        wp_enqueue_script(
            '{{ cookiecutter.plugin_slug }}-frontend-script',
            {{ cookiecutter.plugin_slug|upper }}_WP_PLUGIN_URL . 'src/Frontend/build/assets/bundle.js',
            [],
            {{ cookiecutter.plugin_slug|upper }}_VERSION,
            true
        );

        wp_enqueue_style(
            '{{ cookiecutter.plugin_slug }}-frontend-style',
            {{ cookiecutter.plugin_slug|upper }}_WP_PLUGIN_URL . 'src/Frontend/build/assets/bundle.css',
            [],
            {{ cookiecutter.plugin_slug|upper }}_VERSION
        );

        wp_localize_script(
            '{{ cookiecutter.plugin_slug }}-frontend-script',
            '{{ cookiecutter.plugin_slug }}',
            [
                'root' => esc_url_raw(rest_url('{{ cookiecutter.plugin_slug }}/v1/')),
                'nonce'    => wp_create_nonce('wp_rest'),
            ]
        );
    }
}
