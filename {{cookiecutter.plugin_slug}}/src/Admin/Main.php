<?php

namespace {{ cookiecutter.php_namespace }}\Admin;

if (!defined('ABSPATH')) exit;

Class Main
{
    public function init()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script(
            '{{ cookiecutter.plugin_slug }}-admin-script',
            {{ cookiecutter.plugin_slug|upper }}_WP_PLUGIN_URL . 'src/Admin/build/assets/bundle.js',
            [],
            {{ cookiecutter.plugin_slug|upper }}_VERSION,
            true
        );

        wp_enqueue_style(
            '{{ cookiecutter.plugin_slug }}-admin-style',
            {{ cookiecutter.plugin_slug|upper }}_WP_PLUGIN_URL . 'src/Admin/build/assets/bundle.css',
            [],
            {{ cookiecutter.plugin_slug|upper }}_VERSION
        );

        wp_localize_script(
            '{{ cookiecutter.plugin_slug }}-admin-script',
            '{{ cookiecutter.plugin_slug }}',
            [
                'root' => esc_url_raw(rest_url('{{ cookiecutter.plugin_slug }}/v1/')),
                'nonce'    => wp_create_nonce('wp_rest'),
            ]
        );

    }
}
