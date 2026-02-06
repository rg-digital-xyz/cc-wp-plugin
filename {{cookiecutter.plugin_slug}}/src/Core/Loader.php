<?php

namespace {{ cookiecutter.php_namespace }}\Core;

if (!defined('ABSPATH')) exit;

use {{ cookiecutter.php_namespace }}\Admin\Main as AdminMain;
use {{ cookiecutter.php_namespace }}\Api\Api;
use {{ cookiecutter.php_namespace }}\Core\I18n;
use {{ cookiecutter.php_namespace }}\Frontend\Main as FrontendMain;

class Loader
{
    private AdminMain $admin;
    private FrontendMain $frontend;
    private Api $api;
    private I18n $i18n;

    public function __construct()
    {
        $this->admin = new AdminMain();
        $this->frontend = new FrontendMain();
        $this->api = new Api();
        $this->i18n = new I18n();
    }

    public function run(): void
    {
        $this->i18n->load_plugin_textdomain();
        $this->api->init();

        if (is_admin()) {
            $this->admin->init();
        } else {
            $this->frontend->init();
        }
    }
}
