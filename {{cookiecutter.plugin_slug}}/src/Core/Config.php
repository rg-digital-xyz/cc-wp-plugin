<?php

namespace {{ cookiecutter.php_namespace }}\Core;

if (!defined('ABSPATH')) exit;

/**
 * Plugin configuration constants.
 */
class Config
{
    /** REST API namespace (e.g. "my-plugin/v1"). */
    public const REST_NAMESPACE = '{{ cookiecutter.plugin_slug }}/v1';
}
