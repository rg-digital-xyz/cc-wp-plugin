<?php

namespace {{ cookiecutter.php_namespace }}\Core;

if (!defined('ABSPATH')) exit;

/**
 * Plugin configuration constants.
 */
class Config
{
    /** Text domain for translations. */
    public const TEXT_DOMAIN = '{{ cookiecutter.plugin_slug }}';

    /** REST API namespace (e.g. "my-plugin/v1"). */
    public const REST_NAMESPACE = '{{ cookiecutter.plugin_slug }}/v1';
}
