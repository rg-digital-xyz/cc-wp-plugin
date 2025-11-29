<?php

namespace {{ cookiecutter.php_namespace }}\Core;

if (!defined('ABSPATH')) exit;

use {{ cookiecutter.php_namespace }}\Admin\Main as AdminMain;
use {{ cookiecutter.php_namespace }}\Frontend\Main as FrontendMain;


class Loader
{
    private AdminMain $admin;
    private FrontendMain $frontend;

    public function __construct()
    {
        $this->admin = new AdminMain();
        $this->frontend = new FrontendMain();
    }

    public function run()
    {
        if (is_admin()) {
            $this->admin->init();
        } else {
            $this->frontend->init();
        }
    }
}
